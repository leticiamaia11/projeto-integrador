<?php
// Validação de senha - Requisito 01
function validarSenha($senha) {
    if (strlen($senha) < 8) {
        return "A senha deve ter no mínimo 8 caracteres.";
    }
    if (!preg_match('/[A-Z]/', $senha)) {
        return "A senha deve conter pelo menos uma letra maiúscula.";
    }
    if (!preg_match('/[a-z]/', $senha)) {
        return "A senha deve conter pelo menos uma letra minúscula.";
    }
    if (!preg_match('/[0-9]/', $senha)) {
        return "A senha deve conter pelo menos um número.";
    }
    if (!preg_match('/[^a-zA-Z0-9\s]/', $senha)) {
        return "A senha deve conter pelo menos um caractere especial.";
    }
    return true; 
}
?>
