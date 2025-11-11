<?php
// verifica_login.php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    $_SESSION['erro_login'] = "Você precisa estar logado para acessar esta página.";
    header("Location: login.html");
    exit();
}
?>