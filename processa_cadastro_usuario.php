<?php
// Arquivo: processa_cadastro_usuario.php
// Apenas Admin executa
include('verifica_admin.php');
include('conexao.php');
include('utils.php');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cadastro_usuario.php");
    exit();
}

// Coleta e sanitiza entradas
$nome = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS));
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$senha_pura = isset($_POST['senha']) ? $_POST['senha'] : null;
$confirma_senha = isset($_POST['confirma_senha']) ? $_POST['confirma_senha'] : null;
$perfil_acesso = isset($_POST['perfil_acesso']) ? $_POST['perfil_acesso'] : null;

// Validações básicas
if (!$nome || !$email || !$senha_pura || !$confirma_senha || !$perfil_acesso) {
    // Dados obrigatórios faltando
    header("Location: cadastro_usuario.php?status=erro_interno");
    exit();
}

// Confirmação de senha no backend (importante caso o JS esteja desabilitado)
if ($senha_pura !== $confirma_senha) {
    header("Location: cadastro_usuario.php?status=erro_interno");
    exit();
}

// Valida perfil de acesso (evitar valores maliciosos)
$perfis_validos = ['usuario', 'admin'];
if (!in_array($perfil_acesso, $perfis_validos, true)) {
    header("Location: cadastro_usuario.php?status=erro_interno");
    exit();
}

// Valida regras de senha usando sua função em utils.php
$validacao = validarSenha($senha_pura);
if ($validacao !== true) {
    // Você pode redirecionar para uma página mais amigável indicando a mensagem em $validacao
    // Por enquanto usamos erro_interno para manter consistência com sua página.
    header("Location: cadastro_usuario.php?status=erro_interno");
    exit();
}

// Verifica se a conexão está ok
if (!isset($conn) || $conn->connect_errno) {
    header("Location: cadastro_usuario.php?status=erro_interno");
    exit();
}

// 1) Verificar se o e-mail já existe (prevenção de duplicidade)
$sql_check = "SELECT id FROM usuarios WHERE email = ?";
$stmt_check = $conn->prepare($sql_check);
if (!$stmt_check) {
    header("Location: cadastro_usuario.php?status=erro_interno");
    exit();
}
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
if ($result_check && $result_check->num_rows > 0) {
    // Fechar recursos antes do redirect
    $stmt_check->close();
    $conn->close();
    header("Location: cadastro_usuario.php?status=email_duplicado");
    exit();
}
$stmt_check->close();

// 2) Inserir novo usuário (com hash de senha)
$senha_hash = password_hash($senha_pura, PASSWORD_DEFAULT);

$sql_insert = "INSERT INTO usuarios (nome, email, senha, perfil_acesso) VALUES (?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
if (!$stmt_insert) {
    header("Location: cadastro_usuario.php?status=erro_interno");
    exit();
}
$stmt_insert->bind_param("ssss", $nome, $email, $senha_hash, $perfil_acesso);

// Executa e captura erro antes de fechar conexão
$exec_ok = $stmt_insert->execute();
$insert_errno = $stmt_insert->errno; // captura do erro do stmt
$insert_error = $stmt_insert->error; // para debug se quiser registrar
$stmt_insert->close();
$conn->close();

if ($exec_ok) {
    header("Location: cadastro_usuario.php?status=cadastro_sucesso");
    exit();
} else {
    // Se por algum motivo houve duplicidade (race condition) ou outro erro, trate
    if ($insert_errno == 1062) { // duplicate entry
        header("Location: cadastro_usuario.php?status=email_duplicado");
        exit();
    } else {
        header("Location: cadastro_usuario.php?status=erro_interno");
        exit();
    }
}
