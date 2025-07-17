<?php
require '../config.php';

// Obtém o ID do usuário da URL
$id = $_GET['id'] ?? null;

// Busca as informações do usuário
if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Usuário não encontrado.";
        exit;
    }
} else {
    echo "ID do usuário não fornecido.";
    exit;
}

// Atualiza as informações do usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? $user['usuario'];
    $telegram = $_POST['telegram'] ?? $user['telegram'];
    $block = isset($_POST['block']) ? 1 : 0;
    $senha = $_POST['senha'] ?? null;
    $data_expira = $_POST['data_expira'] ?? null;

    // Se a senha foi preenchida, atualiza a senha
    if (!empty($senha)) {
        $senha = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a senha
        $stmt = $pdo->prepare('UPDATE usuarios SET usuario = :usuario, telegram = :telegram, senha = :senha, block = :block, data_expira = :data_expira WHERE id = :id');
        $stmt->execute([
            'usuario' => $usuario,
            'telegram' => $telegram,
            'senha' => $senha,
            'block' => $block,
            'data_expira' => $data_expira,
            'id' => $id
        ]);
    } else {
        // Se não houver senha, apenas atualiza os outros campos
        $stmt = $pdo->prepare('UPDATE usuarios SET usuario = :usuario, telegram = :telegram, block = :block, data_expira = :data_expira WHERE id = :id');
        $stmt->execute([
            'usuario' => $usuario,
            'telegram' => $telegram,
            'block' => $block,
            'data_expira' => $data_expira,
            'id' => $id
        ]);
    }

    echo "<script>alert('Usuário atualizado com sucesso!'); window.location.href = 'admin.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin.css">
    <title>Editar Usuário</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Usuário</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="usuario">Usuário:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo htmlspecialchars($user['usuario']); ?>" required>
            </div>

            <div class="form-group">
                <label for="telegram">Telegram:</label>
                <input type="text" class="form-control" id="telegram" name="telegram" value="<?php echo htmlspecialchars($user['telegram']); ?>" required>
            </div>

            <div class="form-group">
                <label for="senha">Nova Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite a nova senha (deixe em branco para não alterar)">
            </div>

            <div class="form-group">
                <label for="data_expira">Data de Expiração:</label>
                <input type="date" class="form-control" id="data_expira" name="data_expira" value="<?php echo $user['data_expira'] ? $user['data_expira'] : ''; ?>">
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="block" name="block" <?php echo $user['block'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="block">Bloqueado</label>
            </div>

            <button type="submit" class="btn btn-success">Salvar Alterações</button>
            <a href="admin.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
