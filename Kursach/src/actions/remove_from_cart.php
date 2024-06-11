<?php
session_start();
require_once __DIR__ . '/../helpers.php';

if (!isset($_SESSION['user'])) {
    header('Location: /Kursach/HTML/log_in.php');
    exit();
}

$pdo = getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $basketId = $_POST['basket_id'];

    $stmt = $pdo->prepare("DELETE FROM basket WHERE id_basket = :id_basket");
    $stmt->execute(['id_basket' => $basketId]);

    header('Location: /Kursach/HTML/cart.php');
}
?>
