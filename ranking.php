<?php
// Arquivo: ranking.php
// Não requer session_start() se o ranking for público (Requisito 12)
// Adicionando display de erros temporariamente (pode ser removido depois)
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('conexao.php'); 

// Query para buscar o ÚLTIMO score de cada fornecedor e ordená-los (Requisito 10 e 12)
$sql = "SELECT f.razao_social, r.pontuacao_final
        FROM fornecedores f
        JOIN respostas_fornecedores r ON f.id = r.fornecedor_id
        WHERE r.id IN (
            -- Subquery para garantir que pegamos apenas a resposta mais recente (MAX ID)
            SELECT MAX(id) FROM respostas_fornecedores GROUP BY fornecedor_id
        )
        ORDER BY r.pontuacao_final DESC, f.razao_social ASC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Ranking Sustain Flow</title>
    <link rel="shortcut icon" href="imagens/favicon-16x16.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        <a href="admin_dashboard.php" class="back-link" style="position: absolute; top: 30px; left: 30px;">&larr;</a>
    </header>

    <main class="container">
        <div class="table-wrapper"> 
            
            <h1>Ranking de Fornecedores Sustentáveis</h1>
            <p style="text-align: center; color: var(--text-dark); text-shadow: none; margin-top: 10px;">
                Desempenho da última avaliação ESG de cada fornecedor.
            </p>

            <table>
                <thead>
                    <tr>
                        <th>Posição</th>
                        <th>Fornecedor</th>
                        <th>Pontuação</th>
                        <th>Nível de Desempenho</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $posicao = 1;
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $pontuacao = $row['pontuacao_final'];
                            
                            // Lógica de Classificação e Definição da Classe CSS
                            $classificacao = "Crítico";
                            $classificacao_css = "rank-critico";

                            if ($pontuacao >= 80) {
                                $classificacao = "Excelente";
                                $classificacao_css = "rank-excelente";
                            } elseif ($pontuacao >= 60) {
                                $classificacao = "Bom";
                                $classificacao_css = "rank-bom";
                            } elseif ($pontuacao >= 40) {
                                $classificacao = "Aceitável";
                                $classificacao_css = "rank-aceitavel";
                            }
                            
                            echo "<tr>";
                            echo "<td>" . $posicao++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['razao_social']) . "</td>";
                            echo "<td>" . $pontuacao . "</td>";
                            // Aplica a classe CSS para o estilo colorido
                            echo "<td><span class='rank-badge " . $classificacao_css . "'>" . $classificacao . "</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align: center;'>Nenhum fornecedor ranqueado ainda.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        </footer>
</body>
</html>