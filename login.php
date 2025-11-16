<?php
// ===============================================
// ATIVA EXIBIÇÃO DE ERROS PARA DEBUG (TEMPORÁRIO!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ===============================================

// ==========================================================
// 1. LÓGICA DE PROCESSAMENTO (SÓ RODA SE O FORMULÁRIO FOR ENVIADO)
// ==========================================================
session_start();

// Garante que o arquivo de conexão seja incluído corretamente
require_once "conexao.php"; 

// Define a página de login para redirecionamentos
$login_page = "login.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha_pura = isset($_POST['senha']) ? $_POST['senha'] : '';

    // Verifica campos vazios/inválidos
    if (!$email || empty($senha_pura)) {
        header("Location: {$login_page}?error=campos_invalidos");
        exit;
    }
    
    $sql = "SELECT id, nome, senha, perfil_acesso FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);

    // Se a consulta falhar, deve ser um erro de conexão ou SQL
    if (!$stmt) {
        header("Location: {$login_page}?error=erro_consulta");
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        if (password_verify($senha_pura, $usuario['senha'])) {
            // Login OK
            session_regenerate_id(true);
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['perfil_acesso'] = $usuario['perfil_acesso'];

            if ($usuario['perfil_acesso'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: principal.php");
            }
            exit;
        } else {
            // Senha incorreta
            header("Location: {$login_page}?error=senha_incorreta");
            exit;
        }
    } else {
        // E-mail não encontrado
        header("Location: {$login_page}?error=email_nao_encontrado");
        exit;
    }
    
    $stmt->close();
    $conn->close();
} 
// Se o método NÃO for POST, o PHP continua a execução e exibe o HTML abaixo.
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Sustain Flow — Login</title>
    <link rel="shortcut icon" href="imagens/favicon-16x16.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo"><img src="imagens/logo.png" alt="Logo Sustain Flow"></div>
        <nav>
            <div class="container">
                    <div><a href="login.php" class="link">Log-in</a></div>
                    <div><a href="sobre.html" class="link">Sobre</a></div>
                    <div><a href="precos.html" class="link">Preços</a></div>
            </div>
        </nav>
    </header>

    <hr>

    <main>
        <section class="login">
            <div class="form-container">
                <h1>Entrar</h1>

                <?php
                $errorMessage = '';
                if (isset($_GET['error'])) {
                    switch ($_GET['error']) {
                        case 'senha_incorreta':
                            $errorMessage = 'A senha fornecida está incorreta.';
                            break;
                        case 'email_nao_encontrado':
                            $errorMessage = 'O e-mail não foi encontrado em nosso sistema.';
                            break;
                        case 'campos_invalidos':
                            $errorMessage = 'E-mail ou senha não preenchidos corretamente.';
                            break;
                        case 'erro_consulta':
                            $errorMessage = 'Erro interno do banco de dados ao buscar o usuário.';
                            break;
                        default:
                            $errorMessage = 'Ocorreu um erro durante o login.';
                    }
                    if (!empty($errorMessage)) {
                        // Estiliza a mensagem de erro com cor de destaque
                        echo '<p style="color: #FF6347; font-weight: 500; margin-bottom: 20px; text-shadow: none;">' . $errorMessage . '</p>';
                    }
                }
                ?>

                <form id="loginForm" method="POST" action="login.php" autocomplete="on">
                    
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" required />
                    </div>
            
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" id="password" name="senha" required />
                    </div>
            
                    <button type="submit" class="cta-button">Entrar</button>
                    
                    <p style="margin-top: 15px; font-size: 1em; color: var(--text-dark); text-shadow: none;">
                        <a href="https://wa.me/5541987679272" style="color: var(--primary-hover);">Esqueceu a senha?</a>
                    </p>
                </form>
            
            </div>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2025 Sustain Flow</p>
    </footer>
</body>
</html>