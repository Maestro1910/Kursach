<?php
require_once __DIR__ . '/../helpers.php';

$user = currentUser();

if ($user === false) {
    header('Location: ../../login.php');
    exit();
}

$pdo = getPDO();
$userId = $user['id'];

$orderDate = $_POST['order_date'] ?? null;

if ($orderDate === null) {
    // Обработать ошибку: дата заказа не указана
    header('Location: ../../cart.php?error=missing_date');
    exit();
}

$currentDate = time();
$orderTimestamp = strtotime($orderDate);

if ($orderTimestamp === false || $orderTimestamp < $currentDate) {
    header('Location: /Kursach/HTML/cart.php?error=invalid_date');
    exit();
}

$stmt = $pdo->prepare("SELECT b.id_product, b.product_name, b.product_price, b.quantity 
                       FROM basket b
                       WHERE b.id_user = :id_user");
$stmt->execute(['id_user' => $userId]);
$basketItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($basketItems)) {
    header('Location: ../../cart.php?error=empty_cart');
    exit();
}

$pdo->beginTransaction();

try {
    $insertQuery = "INSERT INTO orders (id_product, product_name, product_price, id_user, name, order_date, email, quantity) 
                    VALUES (:id_product, :product_name, :product_price, :id_user, :name, :order_date, :email, :quantity)";

    $insertValues = [];
    foreach ($basketItems as $item) {
        $insertValues[] = [
            'id_product' => $item['id_product'],
            'product_name' => $item['product_name'],
            'product_price' => $item['product_price'],
            'id_user' => $userId,
            'name' => $user['name'],
            'order_date' => $orderDate,
            'email' => $user['email'],
            'quantity' => $item['quantity']
        ];
    }

    $stmt = $pdo->prepare($insertQuery);
    foreach ($insertValues as $values) {
        $stmt->execute($values);
    }

    $stmt = $pdo->prepare("DELETE FROM basket WHERE id_user = :id_user");
    $stmt->execute(['id_user' => $userId]);

    $pdo->commit();

    header('Location: /Kursach/HTML/orders.php');
} catch (Exception $e) {
    $pdo->rollBack();
    header('Location: /Kursach/HTML/cart.php?error=order_failed');
    exit();
}
?>
