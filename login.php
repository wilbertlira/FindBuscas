<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $senha = trim($_POST['senha']);

    $stmt = $pdo->prepare('SELECT id, senha, block, data_expira FROM usuarios WHERE usuario = ?');
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
        if ($user['block'] == 1) {
            echo 'Usuário bloqueado!';
            exit;
        }
        if (strtotime($user['data_expira']) < time()) {
            echo 'Acesso expirado!';
            exit;
        }
        header('Location: dashboard.php');
        exit;
    } else {
        echo 'Usuário ou senha incorretos!';
    }
}
?>
