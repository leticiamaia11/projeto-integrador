<?php
// Configurações do Banco de Dados
define('DB_HOST', '127.0.0.1'); // usando 127.0.0.1 ao invés de localhost
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sustainflow_db');
define('DB_PORT', '3307');

try {
    // Cria a instância de PDO para MySQL, incluindo a porta
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS
    );
    
    // Define o modo de erro para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Interrompe a execução em caso de erro de conexão
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "✅ Conexão estabelecida com sucesso!";

?>