<?php
session_start();
require_once __DIR__ . '/../helpers.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    try {
        $pdo = getPDO();

        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :id");

        $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'id' => $user_id]);

        header('Location: /Kursach/HTML/clients.php');
        exit();
    } catch (Exception $e) {
        echo "Произошла ошибка: " . $e->getMessage();
        exit();
    }
} else {
    echo "Неверный запрос.";
    exit();
}
?>
