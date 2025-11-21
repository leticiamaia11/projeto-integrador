<?php
include('verifica_admin.php');
require_once "conexao.php";

if (!isset($_GET['id'])) {
    header("Location: admin_empresas.php");
    exit;
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id AND perfil_acesso = 'usuario'");
$stmt->execute([':id' => $id]);

header("Location: admin_empresas.php");
exit;
