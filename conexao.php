<?php
// ===============================================
// ATIVA EXIBIÇÃO DE ERROS PARA DEBUG (REMOVER EM PRODUÇÃO)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ===============================================


// Arquivo: conexao.php
// Configurações do Banco de Dados
$servername = "localhost";
$username = "root";   // GERALMENTE É 'root' NO XAMPP
$password = "root";     // GERALMENTE É VAZIA ('') NO XAMPP
$dbname = "sustainflow_db"; // VERIFIQUE O NOME EXATO DO SEU BANCO DE DADOS

// Conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// VERIFICA SE HOUVE ERRO E MOSTRA A MENSAGEM DETALHADA
if ($conn->connect_error) {
    // Se a conexão falhar, o script para AQUI e exibe o erro exato:
    die("Erro FATAL na conexão com o banco de dados: " . $conn->connect_error . 
        "<br>Verifique se o MySQL no XAMPP está ativo e se os dados (usuário, senha, dbname) em conexao.php estão corretos.");
}

// Configura o charset
$conn->set_charset("utf8mb4");
?>