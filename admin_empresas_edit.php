<?php
include('verifica_admin.php');
require_once "conexao.php";

if (!isset($_GET['id'])) {
    header("Location: admin_empresas.php");
    exit;
}

$id = intval($_GET['id']);

// Buscar empresa
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ? AND perfil_acesso = 'usuario'");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$empresa = $result->fetch_assoc();

if (!$empresa) {
    die("Empresa não encontrada.");
}

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // SQL base
    if (!empty($senha)) {
        $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmtUp = $conn->prepare($sql);
        $stmtUp->bind_param("sssi", $nome, $email, $senhaHash, $id);
    } else {
        $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
        $stmtUp = $conn->prepare($sql);
        $stmtUp->bind_param("ssi", $nome, $email, $id);
    }

    if ($stmtUp->execute()) {
        $sucesso = "Empresa atualizada com sucesso!";
    } else {
        $erro = "Erro ao atualizar: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Empresa</title>
    <link rel="shortcut icon" href="imagens/favicon-16x16.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <div class="logo"><img src="imagens/logo.png"></div>
</header>

<main>
    <div class="form-container">

        <h1>Editar Empresa</h1>

        <?php if ($erro): ?>
            <p style="color:red;"><?= $erro ?></p>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <p style="color:green;"><?= $sucesso ?></p>
        <?php endif; ?>

        <form method="post">

            <div class="form-group">
                <label>Nome da Empresa</label>
                <input type="text" name="nome" value="<?= htmlspecialchars($empresa['nome']) ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($empresa['email']) ?>" required>
            </div>

            <div class="form-group">
                <label>Nova Senha (opcional)</label>
                <input type="password" name="senha" placeholder="Deixe em branco para não alterar">
            </div>

            <button class="cta-button" type="submit">Salvar Alterações</button>
        </form>

        <br>
        <a class="back-link" href="admin_empresas.php">⟵</a>

    </div>
</main>

<footer>
    <p>&copy; 2025 Sustain Flow</p>
</footer>

</body>
</html>
