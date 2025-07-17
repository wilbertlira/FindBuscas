<?php
require '../config.php';

// Consulta para pegar todos os usuários
$stmt = $pdo->query('SELECT * FROM usuarios');
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="admin.css">

    <title>Findy - Painel Administrativo</title>
</head>
<body>
    <div class="container admin-container">
        <h1 class="text-center mb-4">Painel Administrativo</h1>
        
        <!-- Tabela de Usuários -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Telegram</th>
                    <th>Status</th>
                    <th>Data de Expiração</th> <!-- Nova coluna para data de expiração -->
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $user): ?>
                    <tr id="user-<?= $user['id'] ?>">
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['usuario']) ?></td>
                        <td><?= htmlspecialchars($user['telegram']) ?></td>
                        <td class="status"><?= $user['block'] ? 'Bloqueado' : 'Ativo' ?></td>
                        
                        <!-- Exibe a data de expiração ou "Não Definida" se não houver data -->
                        <td><?= $user['data_expira'] ? date('d/m/Y', strtotime($user['data_expira'])) : 'Não Definida' ?></td>
                        
                        <td>
                            <button class="btn btn-warning" onclick="editUser(<?= $user['id'] ?>)">Editar</button>
                            <button class="btn btn-danger" onclick="deleteUser(<?= $user['id'] ?>)">Excluir</button>
                            <button id="block-btn-<?= $user['id'] ?>" class="btn <?= $user['block'] ? 'btn-success' : 'btn-danger' ?>" onclick="toggleBlock(<?= $user['id'] ?>, <?= $user['block'] ?>)">
                                <?= $user['block'] ? 'Desbloquear' : 'Bloquear' ?>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
