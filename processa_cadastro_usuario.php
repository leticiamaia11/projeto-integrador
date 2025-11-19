<?php
// Apenas Admin executa
include('verifica_admin.php'); 
include('conexao.php');
include('utils.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha_pura = $_POST['senha'];
    $perfil_acesso = $_POST['perfil_acesso'];

    // 1. Validação de Senha (Requisito 01)
    $validacao = validarSenha($senha_pura);
    if ($validacao !== true) {
        die("Erro de segurança na senha: " . $validacao);
    }
    
    // 2. Hash da Senha (Requisito 17)
    $senha_hash = password_hash($senha_pura, PASSWORD_DEFAULT);

    // 3. Inserção no DB (Requisito 01)
    $sql = "INSERT INTO usuarios (nome, email, senha, perfil_acesso) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nome, $email, $senha_hash, $perfil_acesso);

    if ($stmt->execute()) {
    header("Location: cadastro_usuario.php?status=cadastro_sucesso");
    exit();
} else {
    if ($conn->errno == 1062) {
        header("Location: cadastro_usuario.php?status=email_duplicado");
        exit();
    } else {
        header("Location: cadastro_usuario.php?status=erro_interno");
        exit();
    }
}
    $stmt->close();
    $conn->close();
}
?>
<br><a href="admin_dashboard.php">Voltar</a>