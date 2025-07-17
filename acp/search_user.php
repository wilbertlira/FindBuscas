<?php
require '../config.php';

$query = $_GET['query'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario LIKE :query OR telegram LIKE :query");
$stmt->execute(['query' => "%$query%"]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
?>
