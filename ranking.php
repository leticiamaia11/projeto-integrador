<?php
// Arquivo: ranking.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('conexao.php'); 

// Query modificada apenas para incluir endereço e telefone
$sql = "SELECT f.razao_social, f.endereco, f.telefone, r.pontuacao_final
        FROM fornecedores f
        JOIN respostas_fornecedores r ON f.id = r.fornecedor_id
        WHERE r.id IN (
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

                        <!-- ADICIONADO -->
                        <th>Endereço</th>
                        <th>Telefone</th>

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

                            if ($pontuacao >= 900) {
                                $classificacao = "Excelente";
                                $classificacao_css = "rank-excelente";
                            } elseif ($pontuacao >= 700) {
                                $classificacao = "Bom";
                                $classificacao_css = "rank-bom";
                            } elseif ($pontuacao >= 500) {
                                $classificacao = "Aceitável";
                                $classificacao_css = "rank-aceitavel";
                            } else {
                                $classificacao = "Crítico";
                                $classificacao_css = "rank-critico";
                            }

                            echo "<tr>";
                            echo "<td>" . $posicao++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['razao_social']) . "</td>";

                            // ADICIONADO
                            echo "<td>" . htmlspecialchars($row['endereco']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['telefone']) . "</td>";

                            echo "<td>" . $pontuacao . "</td>";
                            echo "<td><span class='rank-badge " . $classificacao_css . "'>" . $classificacao . "</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align: center;'>Nenhum fornecedor ranqueado ainda.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 Sustain Flow</p>
    </footer>
</body>
</html>
