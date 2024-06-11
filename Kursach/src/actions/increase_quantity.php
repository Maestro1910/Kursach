<?php
session_start();
require_once __DIR__ . '/../helpers.php';

$user = currentUser();

if ($user === false) {
    header('Location: ../../login.php');
    exit();
}

$pdo = getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $basketId = $_POST['basket_id'];
    $stmt = $pdo->prepare("UPDATE basket SET quantity = quantity + 1 WHERE id_basket = :id_basket AND id_user = :id_user");
    $stmt->execute([
        'id_basket' => $basketId,
        'id_user' => $user['id']
    ]);

    header('Location: /Kursach/HTML/cart.php');
    exit();
}
?>
