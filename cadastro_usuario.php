<?php
// Arquivo: cadastro_usuario.php (Apenas Admin acessa)
include('verifica_admin.php'); 

$status_message = "";
// Exibe mensagem de sucesso se vier de processa_cadastro_usuario.php
if (isset($_GET['status']) && $_GET['status'] == 'cadastro_sucesso') {
    $status_message = '<div class="status-message" style="background: var(--primary-color); color: var(--text-light); padding: 10px; border-radius: 6px; margin-bottom: 20px; font-weight: bold;">Usuário cadastrado com sucesso!</div>';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cadastro de Usuário | Admin</title>
    <link rel="shortcut icon" href="imagens/favicon-16x16.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        <a href="admin_dashboard.php" class="back-link" style="position: absolute; top: 30px; left: 30px;">&larr;</a>
    </header>

    <main>
        <div class="form-container"> 
            
            <h1>Cadastrar Novo Usuário</h1>
            
            <?php echo $status_message; ?>
            
            <p style="font-size: 1.1em; color: var(--text-dark); text-shadow: none; margin-bottom: 25px;">
                Preencha os dados do novo usuário do sistema.
            </p>
            
            <hr>
            
            <form action="processa_cadastro_usuario.php" method="POST" style="width: 100%;">
                
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required minlength="8">
                </div>
                
                <div class="form-group">
                    <label for="confirma_senha">Confirmar Senha</label>
                    <input type="password" id="confirma_senha" name="confirma_senha" required minlength="8">
                </div>

                <div class="form-group">
                    <label for="perfil_acesso">Perfil de Acesso</label>
                    <select id="perfil_acesso" name="perfil_acesso" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #A3AD90; color: var(--text-dark);">
                        <option value="usuario">Usuário Comum</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>

                <button type="submit" class="cta-button" style="width: 100%;">Cadastrar Usuário</button>
            </form>
            
            <script>
                // Validação simples em JS para conferir senhas
                document.querySelector('form').addEventListener('submit', function(event) {
                    var senha = document.getElementById('senha').value;
                    var confirma_senha = document.getElementById('confirma_senha').value;

                    if (senha !== confirma_senha) {
                        alert("Erro: A senha e a confirmação de senha não são iguais.");
                        event.preventDefault(); 
                    }
                });
            </script>
        </div>
    </main>
    
    <footer>
        </footer>
</body>
</html>