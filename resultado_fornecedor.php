<?php
if (!isset($_GET['score'])) {
    header("Location: formulario_fornecedor.php");
    exit();
}

$score = intval($_GET['score']);

// Classificação simples
if ($score >= 800) {
    $nivel = "Excelente";
    $descricao = "Sua empresa demonstrou práticas sólidas de sustentabilidade.";
} elseif ($score >= 600) {
    $nivel = "Bom";
    $descricao = "Sua empresa possui boas práticas, mas há pontos a melhorar.";
} elseif ($score >= 400) {
    $nivel = "Aceitável";
    $descricao = "Sua empresa atende ao mínimo, porém precisa evoluir.";
} else {
    $nivel = "Crítico";
    $descricao = "Sua empresa apresenta sérias deficiências nas práticas ESG.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Avaliação ESG</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main class="container">

        <div class="form-container" style="max-width: 700px; margin: auto;">

            <h1>Resultado da Avaliação ESG</h1>

            <p style="font-size: 18px; margin-top: 10px;">
                Obrigado por preencher o formulário! Sua pontuação final foi:
            </p>

            <div style="
                background: var(--primary-color);
                padding: 20px;
                border-radius: 10px;
                color: white;
                text-align: center;
                margin: 20px 0;
                font-size: 28px;
                font-weight: bold;">
                <?php echo $score; ?> pontos
            </div>

            <h2 style="text-align:center;"><?php echo $nivel; ?></h2>

            <p style="font-size: 17px; margin-top: 15px; text-align: justify;">
                <?php echo $descricao; ?>
            </p>

            <hr>

            <p style="font-size: 17px; text-align: justify; margin-top: 20px;">
                Suas respostas foram enviadas com sucesso para a empresa contratante.
                Agora, a empresa responsável irá analisar seus dados e decidir os próximos passos.
            </p>

            <br>
            <a href="https://google.com" class="cta-button" 
               style="text-align:center; display:block; width:100%;">
                Finalizar
            </a>

        </div>

    </main>

</body>
</html>
