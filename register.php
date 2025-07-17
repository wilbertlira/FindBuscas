<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $telegram = trim($_POST['telegram']);
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    // Verificação de usuário existente
    $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE usuario = ?');
    $stmt->execute([$usuario]);
    if ($stmt->fetch()) {
        echo 'Usuário já existe!';
        exit;
    }

    // Inserção do novo usuário com plano de 1 dia e bloqueio 0
    $stmt = $pdo->prepare('INSERT INTO usuarios (usuario, senha, telegram, data_expira, block) VALUES (?, ?, ?, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 0)');
    if ($stmt->execute([$usuario, $senha, $telegram])) {
        header('Location: dashboard.php');
        exit;
    } else {
        echo 'Erro ao registrar!';
    }
}
?>