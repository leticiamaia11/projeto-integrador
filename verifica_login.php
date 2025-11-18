<?php
// Arquivo: verifica_sessao.php (Verificador de login geral)

// Inicia a sessão para que possamos acessar as variáveis de usuário
session_start();

// Verifica se a variável de sessão 'id' ou 'nome' existe
if (!isset($_SESSION['id'])) {
    // Se o usuário não estiver logado, redireciona para a página de login
    header("Location: login.php?error=nao_logado");
    exit;
}
// Se estiver logado, o script prossegue para exibir o HTML da página que o incluiu.
?>