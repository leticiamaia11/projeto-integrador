<?php
require_once __DIR__ . 'verifica_admin.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div class="logo"><img src="imagens/logo.png" alt="Logo"></div>
    <nav>
      <a href="principal.php">Principal</a>
      <a href="logout.php">Sair</a>
    </nav>
  </header>

  <main>
    <h1>Bem-vindo, <?= htmlentities($_SESSION['nome']) ?></h1>
    <p>Painel do administrador.</p>
  </main>
</body>
</html>
