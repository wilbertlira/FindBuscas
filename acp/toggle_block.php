<?php
require '../config.php';

if (!isset($_POST['id']) || !isset($_POST['block'])) {
    echo json_encode(['success' => false, 'message' => 'Dados não fornecidos.']);
    exit;
}

$id = (int) $_POST['id'];
$block = (int) $_POST['block'];

$stmt = $pdo->prepare('UPDATE usuarios SET block = :block WHERE id = :id');
if ($stmt->execute(['block' => $block, 'id' => $id])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar status do usuário.']);
}
?>
