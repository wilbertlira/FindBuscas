<?php
$host = 'localhost';
$dbname = 'findy_settings';
$user = 'root'; // Altere conforme necessário
$password = ''; // Altere conforme necessário

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro de conexão: ' . $e->getMessage());
}
?>
