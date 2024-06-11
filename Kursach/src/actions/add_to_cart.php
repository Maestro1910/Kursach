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
    $userId = $user['id'];
    $productId = $_POST['product_id'];

    $stmtProduct = $pdo->prepare("SELECT * FROM product WHERE id_product = :id_product");
    $stmtProduct->execute(['id_product' => $productId]);
    $product = $stmtProduct->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "Ошибка: товар не найден.";
        exit();
    }

    $stmtBasket = $pdo->prepare("SELECT * FROM basket WHERE id_user = :id_user AND id_product = :id_product");
    $stmtBasket->execute(['id_user' => $userId, 'id_product' => $productId]);
    $basketItem = $stmtBasket->fetch(PDO::FETCH_ASSOC);

    if ($basketItem) {
        $stmtUpdate = $pdo->prepare("UPDATE basket SET quantity = quantity + 1 WHERE id_basket = :id_basket");
        if (!$stmtUpdate->execute(['id_basket' => $basketItem['id_basket']])) {
            echo "Ошибка выполнения запроса: " . $stmtUpdate->errorInfo()[2];
            exit();
        }
    } else {
        $stmtInsert = $pdo->prepare("INSERT INTO basket (id_user, id_product, product_name, product_price, quantity, name) 
                                     VALUES (:id_user, :id_product, :product_name, :product_price, 1, :name)");
        if (!$stmtInsert->execute([
            'id_user' => $userId,
            'id_product' => $productId,
            'product_name' => $product['product_name'],
            'product_price' => $product['price'],
            'name' => $user['name']
        ])) {
            echo "Ошибка выполнения запроса: " . $stmtInsert->errorInfo()[2];
            exit();
        }
    }

    header('Location: /Kursach/HTML/cart.php');
    exit();
}
