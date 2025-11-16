<?php
require_once __DIR__ . 'verifica_login.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Principal</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div class="logo"><img src="imagens/logo.png" alt="Logo"></div>
    <nav>
      <a href="index.html">Início</a>
      <a href="logout.php">Sair</a>
    </nav>
  </header>

  <main>
    <h1>Olá, <?= htmlentities($_SESSION['nome']) ?></h1>
    <p>Conteúdo do usuário comum.</p>
  </main>
</body>
</html>
