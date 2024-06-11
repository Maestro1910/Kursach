<?php
session_start();
require_once __DIR__ . '/../helpers.php';

$user = currentUser();

if ($user === false) {
    header('Location: ../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['order_id'])) {
        echo "Ошибка: Не указан идентификатор заказа.";
        exit();
    }

    try {
        $pdo = getPDO();
        $orderId = $_POST['order_id'];

        $stmt = $pdo->prepare("DELETE FROM orders WHERE id_orders = :order_id");
        $stmt->execute(['order_id' => $orderId]);

        header('Location: /Kursach/HTML/orders.php');
        exit();
    } catch (Exception $e) {
        echo "Произошла ошибка: " . $e->getMessage();
        exit();
    }
} else {
    header('Location: /Kursach/HTML/orders.php');
    exit();
}
