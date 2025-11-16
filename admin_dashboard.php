<?php
include('verifica_admin.php'); 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Dashboard Administrativo | Sustain Flow</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        </header>

    <main>
        <div class="form-container"> 
            <h1>Dashboard Administrativo</h1>
            <p>Bem-vindo(a) Admin!</p>
            
            <a href="cadastro_usuario.php">Cadastrar Novo Usuário do Sistema (Admin/Comum)</a>
                
            <a href="ranking.php">Visualizar Ranking e Gerar Relatórios</a>

            <p>
                <a href="logout.php" class="cta-button">Sair (Logout)</a>
            </p>
        </div>
    </main>

    <footer>
        </footer>
</body>
</html>