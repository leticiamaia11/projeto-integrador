<?php
// Arquivo: principal.php

// 1. ATENÇÃO: É fundamental que o arquivo 'verifica_login.php' exista na mesma pasta.
// Ele deve conter session_start() e a lógica de redirecionamento para login se o usuário não estiver logado.
require_once 'verifica_login.php'; 

// Variável auxiliar para verificar se o usuário é administrador (Requisito 04)
// Assume que a SESSION 'perfil_acesso' foi definida no script de login.
$is_admin = (isset($_SESSION['perfil_acesso']) && $_SESSION['perfil_acesso'] === 'admin');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <title>Principal</title>
    <link rel="shortcut icon" href="imagens/favicon-16x16.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        <div class="logo"><img src="imagens/logo.png" alt="Logo Sustain Flow"></div>
        <nav>
            <a href="index.html">Início</a>
            
            <?php if ($is_admin): ?>
                <a href="admin_dashboard.php">Admin Dashboard</a>
            <?php endif; ?>
            
            <a href="logout.php" class="cta-button">Sair</a>
        </nav>
    </header>

    <main>
        <div class="form-container" style="max-width: 500px; padding: 30px; text-align: center;"> 
            
            <h1 style="color: var(--text-dark); text-shadow: none; margin-bottom: 20px;">
                Olá, <?= htmlentities($_SESSION['nome']) ?>
            </h1>
            
            <p style="color: var(--text-dark); text-shadow: none; font-size: 1.1em; margin-bottom: 30px;">
                Acesso ao Painel do Usuário Comum.
            </p>

            <hr>

            <div class="container-links" style="display: flex; flex-direction: column; gap: 15px; margin-top: 30px;">
                
                <a href="formulario_sustentavel.php" class="cta-button" style="width: 100%;">
                    Acessar Formulário Sustentável
                </a>
                
                <a href="ranking.php" class="cta-button" style="width: 100%;">
                    Visualizar Ranking de Fornecedores
                </a>
                
                <a href="relatorios.php" class="cta-button" style="width: 100%;">
                    Meus Relatórios
                </a>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Sustain Flow</p>
    </footer>
</body>
</html>