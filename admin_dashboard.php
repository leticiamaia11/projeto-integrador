<?php
include('verifica_admin.php'); 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Dashboard Administrativo | Sustain Flow</title>
    <link rel="shortcut icon" href="imagens/favicon-16x16.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

    <header>
        <div class="logo"><img src="imagens/logo.png" alt="Logo Sustain Flow"></div>
        <div class="container"></div>
    </header>

    <hr>

    <main>
        <div class="form-container"> 
            <h1>Dashboard Administrativo</h1>
            <p>Bem-vindo(a) Admin!</p>
            
            <a href="admin_empresas.php">Gerenciar Empresas</a>

            <br>
            <br>
                
            <a href="ranking.php">Visualizar Ranking e Gerar Relatórios</a>

            <p>
                <a href="logout.php" class="cta-button">Sair (Logout)</a>
            </p>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Sustain Flow</p>
    </footer>

</body>
</html>
