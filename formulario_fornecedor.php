<?php
include("conexao.php"); 
include("utils.php");   

if ($conn->connect_errno) {
    // Formulário não carrega
    header("Location: formulario_fornecedor.php?erro=nao_carregou");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sustain Flow — Formulário ESG</title>
    <link rel="shortcut icon" href="imagens/favicon-16x16.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

    <?php if (isset($_GET['erro'])): ?>
    <div class="erro-mensagem" style="
        background: #ffdddd;
        color: #a30000;
        padding: 15px;
        border-left: 5px solid #cc0000;
        margin: 20px auto;
        width: 90%;
        border-radius: 6px;
        font-weight: bold;
        text-align: center;
    ">
        <?php
            if ($_GET['erro'] === 'nao_carregou') {
                echo "Erro: O formulário não pôde ser carregado. Tente novamente mais tarde.";
            } 
            elseif ($_GET['erro'] === 'interno') {
                echo "Erro interno ao processar sua requisição. Nossa equipe já está verificando.";
            }
        ?>
    </div>
<?php endif; ?>


    <header>
        <div class="logo"><img src="imagens/logo.png" alt="Logo Sustain Flow"></div>
        <div class="container"></div>
    </header>

    <hr>

    <main>
        <form action="processa_formulario_fornecedor.php" method="POST" class="form-esg">
            
            <h1>Avaliação de Sustentabilidade</h1>
            <p>Pontuação inicial: 1000 pontos. O resultado final será exibido no ranking.</p>

            <hr>

            <h2>1. Dados do Fornecedor</h2>
            
            <div class="form-group">
                <label for="razao_social">Razão Social</label>
                <input type="text" id="razao_social" name="razao_social" required>
            </div>

            <div class="form-group">
                <label for="cnpj">CNPJ (Apenas números, 14 dígitos)</label>
                <input type="text" id="cnpj" name="cnpj" required maxlength="14" pattern="\d{14}" title="Digite 14 números para o CNPJ">
            </div>
            
            <div class="form-group">
                <label for="endereco">Endereço Completo</label>
                <input type="text" id="endereco" name="endereco" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail de Contato</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone">
            </div>

            <hr>

            <h2>2. Questionário ESG</h2>

            <div class="form-group">
                <label>1. A empresa possui uma política formal de redução de emissões de CO2?</label>
                <div class="options">
                    <label><input type="radio" name="q1_emissao" value="a_sem_deducao" required> A) Política estabelecida e monitorada.</label>
                    <label><input type="radio" name="q1_emissao" value="b_media_deducao"> B) Em planejamento ou piloto.</label>
                    <label><input type="radio" name="q1_emissao" value="c_alta_deducao"> C) Não possui política formal.</label>
                </div>
            </div>

            <div class="form-group">
                <label>2. Como é feito o descarte e gestão de resíduos industriais?</label>
                <div class="options">
                    <label><input type="radio" name="q2_residuos" value="a_sem_deducao" required> A) Certificada com rastreabilidade.</label>
                    <label><input type="radio" name="q2_residuos" value="b_media_deducao"> B) Terceiros sem auditoria.</label>
                    <label><input type="radio" name="q2_residuos" value="c_alta_deducao"> C) Descarte comum sem foco sustentável.</label>
                </div>
            </div>

            <div class="form-group">
                <label>3. Percentual aproximado de água de reuso?</label>
                <div class="options">
                    <label><input type="radio" name="q3_reuso" value="a_sem_deducao" required> A) Acima de 50%.</label>
                    <label><input type="radio" name="q3_reuso" value="b_media_deducao"> B) Entre 10% e 50%.</label>
                    <label><input type="radio" name="q3_reuso" value="c_alta_deducao"> C) Menos de 10%.</label>
                </div>
            </div>

            <div class="form-group">
                <label>4. Principal fonte de energia elétrica da operação:</label>
                <div class="options">
                    <label><input type="radio" name="q4_energia" value="a_sem_deducao" required> A) Fontes renováveis.</label>
                    <label><input type="radio" name="q4_energia" value="b_media_deducao"> B) Rede elétrica tradicional.</label>
                    <label><input type="radio" name="q4_energia" value="c_alta_deducao"> C) Geradores a diesel integralmente.</label>
                </div>
            </div>

            <div class="form-group">
                <label>5. O conselho administrativo possui diversidade de gênero/etnia?</label>
                <div class="options">
                    <label><input type="radio" name="q5_diversidade" required value="a_sem_deducao"> A) Sim, com metas formais.</label>
                    <label><input type="radio" name="q5_diversidade" value="b_media_deducao"> B) Sim, sem metas formais.</label>
                    <label><input type="radio" name="q5_diversidade" value="c_alta_deducao"> C) Não, maioria homogênea.</label>
                </div>
            </div>

            <div class="form-group">
                <label>6. Frequência de treinamentos em ética, segurança e sustentabilidade:</label>
                <div class="options">
                    <label><input type="radio" name="q6_treinamento" required value="a_sem_deducao"> A) Anual com avaliação.</label>
                    <label><input type="radio" name="q6_treinamento" value="b_media_deducao"> B) Apenas onboarding.</label>
                    <label><input type="radio" name="q6_treinamento" value="c_alta_deducao"> C) Não há treinamento.</label>
                </div>
            </div>

            <div class="form-group">
                <label>7. Código de Ética e Canal de Denúncias:</label>
                <div class="options">
                    <label><input type="radio" name="q7_etica" required value="a_sem_deducao"> A) Externo e independente.</label>
                    <label><input type="radio" name="q7_etica" value="b_media_deducao"> B) Interno apenas.</label>
                    <label><input type="radio" name="q7_etica" value="c_alta_deducao"> C) Não possui canal formal.</label>
                </div>
            </div>

            <div class="form-group">
                <label>8. Publicação anual de relatórios de sustentabilidade:</label>
                <div class="options">
                    <label><input type="radio" name="q8_relatorios" required value="a_sem_deducao"> A) Auditados por terceiros.</label>
                    <label><input type="radio" name="q8_relatorios" value="b_media_deducao"> B) Não auditados.</label>
                    <label><input type="radio" name="q8_relatorios" value="c_alta_deducao"> C) Não há publicação.</label>
                </div>
            </div>

            <div class="form-group">
                <label>9. Certificações ambientais (ex: ISO 14001):</label>
                <div class="options">
                    <label><input type="radio" name="q9_certificacao" required value="a_sem_deducao"> A) Possui certificação válida.</label>
                    <label><input type="radio" name="q9_certificacao" value="b_media_deducao"> B) Em processo de certificação.</label>
                    <label><input type="radio" name="q9_certificacao" value="c_alta_deducao"> C) Não possui certificação.</label>
                </div>
            </div>

            <div class="form-group">
                <label>10. Programas de saúde e bem-estar:</label>
                <div class="options">
                    <label><input type="radio" name="q10_saude" required value="a_sem_deducao"> A) Programas robustos com orçamento.</label>
                    <label><input type="radio" name="q10_saude" value="b_media_deducao"> B) Programas básicos.</label>
                    <label><input type="radio" name="q10_saude" value="c_alta_deducao"> C) Apenas exigido por lei.</label>
                </div>
            </div>

            <br>
            <button type="submit" class="cta-button">Enviar Formulário</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 Sustain Flow</p>
    </footer>

</body>
</html>