<?php
require 'config.php';

// Inicializa a variável de mensagem
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // Processo de Login
        $usuario = trim($_POST['usuario']);
        $senha = trim($_POST['senha']);

        $stmt = $pdo->prepare('SELECT id, senha, block, data_expira FROM usuarios WHERE usuario = ?');
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($senha, $user['senha'])) {
                if ($user['block'] == 1) {
                    $mensagem = 'Usuário bloqueado!';
                } elseif (strtotime($user['data_expira']) < time()) {
                    $mensagem = 'Acesso expirado!';
                } else {
                    header('Location: dashboard.php');
                    exit;
                }
            } else {
                $mensagem = 'Senha incorreta!';
            }
        } else {
            $mensagem = 'Usuário não encontrado!';
        }
    } elseif (isset($_POST['register'])) {
        // Processo de Registro
        $usuario = trim($_POST['usuario']);
        $telegram = trim($_POST['telegram']);
        $senha = password_hash(trim($_POST['senha']), PASSWORD_BCRYPT);

        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE usuario = ?');
        $stmt->execute([$usuario]);

        if ($stmt->rowCount() > 0) {
            $mensagem = 'Usuário já existe!';
        } else {
            $stmt = $pdo->prepare('INSERT INTO usuarios (usuario, senha, telegram, data_expira, block, ultimo_ip) VALUES (?, ?, ?, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 0, ?)');
            if ($stmt->execute([$usuario, $senha, $telegram, $_SERVER['REMOTE_ADDR']])) {
                $mensagem = 'Registro realizado com sucesso! Aguarde a aprovação.';
            } else {
                $mensagem = 'Erro ao registrar usuário!';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css" />
    <title>Findy - Painel</title>
</head>
<body>
<?php if ($mensagem): ?>
<script>
    Swal.fire({
        icon: '<?= strpos($mensagem, "sucesso") !== false ? "success" : "error" ?>',
        title: '<?= strpos($mensagem, "sucesso") !== false ? "Sucesso" : "Oops..." ?>',
        text: '<?= $mensagem ?>'
    });
</script>
<?php endif; ?>

<div class="container">
    <div class="forms-container">
        <div class="signin-signup">
            <form method="POST" class="sign-in-form">
                <h2 class="title">Acesso Restrito</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="usuario" placeholder="Usuário" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="senha" placeholder="Senha" required />
                </div>
                <input type="submit" name="login" value="Autenticar-se" class="btn solid" />
            </form>
            <form method="POST" class="sign-up-form">
                <h2 class="title">Solicitar Aprovação</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="usuario" placeholder="Seu Usuário" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="text" name="telegram" placeholder="Seu Telegram" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="senha" placeholder="Sua Senha" required />
                </div>
                <input type="submit" name="register" class="btn" value="Solicitar" />
            </form>
        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
                <h3>Adquira seu acesso em Solicitar Aprovação!</h3>
                <p>
                    Faça o cadastro e receba sua confirmação em <a href="https://t.me/seuusuario" target="_blank">t.me/seuusuario</a>.
                    Informe seu nome de usuário do Telegram para receber a aprovação do pedido caso esteja qualificado.
                    Aqui na Findy, trabalhamos no ramo há mais de uma década, trazendo soluções com respostas de qualidade e precisão.
                </p>
                <button class="btn transparent" id="sign-up-btn">Solicitar Aprovação</button>
            </div>
            <img src="landing.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
            <div class="content">
                <h3>Já está Pronto?</h3>
                <p>Para acessar o portal, faça agora sua autenticação caso já esteja elegível!</p>
                <button class="btn transparent" id="sign-in-btn">Autenticar-se</button>
            </div>
            <img src="fetch.svg" class="image" alt="" />
        </div>
    </div>
</div>

<script src="app.js"></script>
</body>
</html>