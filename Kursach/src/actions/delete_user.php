<?php
session_start();
require_once __DIR__ . '/../helpers.php';

if (!isset($_POST['user_id'])) {
    echo "Некорректный запрос.";
    exit();
}

$userId = $_POST['user_id'];

try {
    $pdo = getPDO();
    
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    
    header('Location: /Kursach/HTML/clients.php');
    exit();
} catch (Exception $e) {
    echo "Произошла ошибка: " . $e->getMessage();
    exit();
}
?>
