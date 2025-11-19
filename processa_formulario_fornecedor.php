<?php
include("conexao.php"); 
include("utils.php"); 

if (!isset($conn) || $conn->connect_errno) {
    header("Location: formulario_fornecedor.php?erro=interno");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Coletar e Sanitizar Dados Cadastrais
    $razao_social = filter_input(INPUT_POST, 'razao_social', FILTER_SANITIZE_SPECIAL_CHARS);
    $cnpj = preg_replace('/[^0-9]/', '', $_POST['cnpj']);
    $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if (strlen($cnpj) != 14 || !$email) {
        die("Erro: CNPJ inválido ou e-mail faltando.");
    }
    
    // 2. Coletar as 10 Respostas do Questionário
    $respostas = [];
    $questoes_nomes = [
        'q1_emissao', 'q2_residuos', 'q3_reuso', 'q4_energia', 
        'q5_diversidade', 'q6_treinamento', 'q7_etica', 'q8_relatorios', 
        'q9_certificacao', 'q10_saude'
    ];
    
    foreach ($questoes_nomes as $nome) {
        $respostas[$nome] = filter_input(INPUT_POST, $nome, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$respostas[$nome]) {
            die("Erro: Resposta faltando para a pergunta: " . $nome);
        }
    }

    // 3. VERIFICAR/CADASTRAR FORNECEDOR (Requisito 06)
    $fornecedor_id = null;
    // ... (O código de verificação/cadastro/update do fornecedor é o mesmo da resposta anterior) ...
    // A. Tenta buscar o fornecedor pelo CNPJ
    $sql_check = "SELECT id FROM fornecedores WHERE cnpj = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $cnpj);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // B. Fornecedor EXISTE: Pega o ID e Atualiza (Update)
        $fornecedor_id = $result_check->fetch_assoc()['id'];
        
        $sql_update = "UPDATE fornecedores SET razao_social = ?, endereco = ?, email = ?, telefone = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssi", $razao_social, $endereco, $email, $telefone, $fornecedor_id);
        $stmt_update->execute();
        $stmt_update->close();

    } else {
        // C. Fornecedor NÃO EXISTE: Insere novo registro (Insert)
        $sql_insert = "INSERT INTO fornecedores (razao_social, cnpj, endereco, email, telefone) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sssss", $razao_social, $cnpj, $endereco, $email, $telefone);

        if ($stmt_insert->execute()) {
            $fornecedor_id = $conn->insert_id;
        } else {
            die("Erro ao cadastrar novo fornecedor: " . $stmt_insert->error);
        }
        $stmt_insert->close();
    }
    $stmt_check->close();

    // 4. CÁLCULO DE PONTUAÇÃO (RF08)
    $pontuacao_final = 1000; // começa em 1000
    
    foreach ($respostas as $resposta) {
        if ($resposta === 'b_media_deducao') {
            $pontuacao_final -= 30;
        } elseif ($resposta === 'c_alta_deducao') {
            $pontuacao_final -= 50;
        }
    }

    // garante que nunca fique negativo
    if ($pontuacao_final < 0) {
     $pontuacao_final = 0;
    }


    // 5. SALVAR RESPOSTAS E PONTUAÇÃO (Requisito 09)
    $sql_respostas = "INSERT INTO respostas_fornecedores (
        fornecedor_id, q1_emissao, q2_residuos, q3_reuso, q4_energia, 
        q5_diversidade, q6_treinamento, q7_etica, q8_relatorios, 
        q9_certificacao, q10_saude, pontuacao_final
    ) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_respostas = $conn->prepare($sql_respostas);
    
    // Note que o 'bind_param' deve ter 'i' para o ID e Pontuação (Inteiros) e 's' para as 10 respostas (Strings)
    $stmt_respostas->bind_param("issssssssssi", 
        $fornecedor_id, 
        $respostas['q1_emissao'], $respostas['q2_residuos'], $respostas['q3_reuso'], $respostas['q4_energia'], 
        $respostas['q5_diversidade'], $respostas['q6_treinamento'], $respostas['q7_etica'], $respostas['q8_relatorios'], 
        $respostas['q9_certificacao'], $respostas['q10_saude'], 
        $pontuacao_final
    );

    if ($stmt_respostas->execute()) {
        header("Location: resultado_fornecedor.php?score=" . $pontuacao_final);
        exit();
    } else {
        die("Erro ao salvar o formulário de respostas: " . $stmt_respostas->error);
    }
    
    $stmt_respostas->close();
    $conn->close();

} else {
    header("Location: formulario_fornecedor.php");
    exit();
}
?>