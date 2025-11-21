<?php
include('verifica_admin.php');
require_once "conexao.php";

// Busca empresas (usuários com perfil 'usuario')
$sql = "SELECT * FROM usuarios WHERE perfil_acesso = 'usuario' ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Empresas | Sustain Flow</title>
    <link rel="shortcut icon" href="imagens/favicon-16x16.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <a href="admin_dashboard.php" class="back-link" style="position: absolute; top: 30px; left: 30px;">&larr;</a>
</header>

<hr>

<main class="container">

    <div class="table-wrapper">

        <h1>Gerenciar Empresas</h1>

        <p style="text-align: center; color: var(--text-dark); text-shadow: none; margin-top: 10px;">
            Lista de empresas cadastradas no sistema.
        </p>

        <div style="text-align: center; margin-top: 20px;">
            <a href="admin_empresas_add.php" class="cta-button">Cadastrar Nova Empresa</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Razão Social</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($emp = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $emp['id'] ?></td>
                            <td><?= htmlspecialchars($emp['nome']) ?></td>
                            <td><?= htmlspecialchars($emp['email']) ?></td>
                            <td>
                                <a href="admin_empresas_edit.php?id=<?= $emp['id'] ?>" class="link">Editar</a> | 
                                <a href="admin_empresas_delete.php?id=<?= $emp['id'] ?>"
                                   onclick="return confirm('Tem certeza que deseja excluir esta empresa?');"
                                   class="link">
                                   Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">Nenhuma empresa cadastrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

</main>

<footer>
    <p>&copy; 2025 Sustain Flow</p>
</footer>

</body>
</html>
