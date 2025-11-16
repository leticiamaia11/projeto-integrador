<?php
// Não requer session_start() se o ranking for público (Requisito 12)
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
    </head>
<body>
    <header></header>

    <main class="container">
        <h1>Ranking de Fornecedores Sustentáveis</h1>

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
                        
                        // Lógica de Classificação (Requisito 10)
                        $classificacao = "Crítico";
                        if ($pontuacao >= 80) $classificacao = "Excelente";
                        elseif ($pontuacao >= 60) $classificacao = "Bom";
                        elseif ($pontuacao >= 40) $classificacao = "Aceitável";
                        
                        echo "<tr>";
                        echo "<td>" . $posicao++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['razao_social']) . "</td>";
                        echo "<td>" . $pontuacao . "</td>";
                        echo "<td>" . $classificacao . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Nenhum fornecedor ranqueado ainda.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </main>
    <footer></footer>
</body>
</html>
