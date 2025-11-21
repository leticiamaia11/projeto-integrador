<?php
include('verifica_admin.php');
require_once "conexao.php"; // aqui deve existir $conn (mysqli)

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome  = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // SQL com placeholders ?
    $sql = "INSERT INTO usuarios (email, senha, nome, perfil_acesso) 
            VALUES (?, ?, ?, 'usuario')";

    // prepara a query
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $erro = "Erro no prepare: " . $conn->error;
    } else {
        // vincula os parâmetros
        $stmt->bind_param("sss", $email, $senha, $nome);

        // executa
        if ($stmt->execute()) {
            $sucesso = "Empresa cadastrada com sucesso!";
        } else {
            $erro = "Erro ao cadastrar: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Empresa</title>
    <link rel="shortcut icon" href="imagens/favicon-16x16.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <div class="logo"><img src="imagens/logo.png"></div>
</header>

<hr>

<main>
    <div class="form-container">

        <h1>Cadastrar Empresa</h1>

        <?php if ($erro): ?>
            <p style="color:red;"><?= $erro ?></p>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <p style="color:green;"><?= $sucesso ?></p>
        <?php endif; ?>

        <form method="post">

            <div class="form-group">
                <label>Nome da Empresa</label>
                <input type="text" name="nome" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="senha" required>
            </div>

            <button class="cta-button" type="submit">Cadastrar</button>
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
