<?php
require '../config.php';

// Verifica se o ID foi enviado corretamente
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID não fornecido.']);
    exit;
}

$id = (int) $_POST['id'];

// Verifica se o usuário existe antes de excluir
$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE id = :id');
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
    exit;
}

// Exclui o usuário
$stmt = $pdo->prepare('DELETE FROM usuarios WHERE id = :id');
if ($stmt->execute(['id' => $id])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao excluir usuário no banco de dados.']);
}
?>
