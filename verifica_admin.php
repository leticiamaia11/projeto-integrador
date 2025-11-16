<?php
// includes/verifica_admin.php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.html?error=nao_logado");
    exit;
}

if (!isset($_SESSION['perfil_acesso']) || $_SESSION['perfil_acesso'] !== 'admin') {
    header("Location: ../public/principal.php?error=acesso_nao_autorizado");
    exit;
}
?>
