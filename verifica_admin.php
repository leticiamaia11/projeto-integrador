<?php
// verifica_admin.php
session_start();

// 1. Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    $_SESSION['erro_login'] = "Você precisa estar logado para acessar a área administrativa.";
    header("Location: login.html");
    exit();
}

// 2. Verifica se o usuário é um ADMINISTRADOR
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ADMIN') {
    die("Acesso negado. Você não tem permissão para acessar esta área."); 
    exit();
}
?>