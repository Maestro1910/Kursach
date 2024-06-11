<?php
session_start();
require_once __DIR__ . '/../src/helpers.php';

$user = currentUser();

if ($user === false) {
    header('Location: ../../login.php');
    exit();
}

try {
    $pdo = getPDO();

    $stmt = $pdo->prepare("SELECT * FROM orders");
    if (!$stmt->execute()) {
        throw new Exception("Ошибка выполнения запроса: " . implode(", ", $stmt->errorInfo()));
    }

    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($orders === false) {
        throw new Exception("Ошибка получения данных из базы данных.");
    }
} catch (Exception $e) {
    echo "Произошла ошибка: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style.css">
    <title>Заказы клиентов</title>
</head>
<body>
    <div class="wrapper">
        <header class="container">
            <div class="logo"></div>
            <a href = "/Kursach/HTML/home.php"><img
              src="../img/logo.png"
              class="logo.png"
              width="150px"
              alt="Company Logo"
            /></a>
            <nav>
              <ul>
                <span><a href="product_catalog.php">Каталог товаров</a></span>
                <span><a href="cart.php">Корзина</a></span>
                <span><a href="orders.php">Заказы</a></span>
                <span><a href="create_product.php">Добавить товар</a></span>
                <span class="customers"><a href="clients.php">Клиенты</a></span>
                <span class="customers"><a href="clients_order.php">Заказы клиентов</a></span>
                <?php if (isset($user['name'])): ?>
                    <span class="user">Здравствуйте, <?php echo htmlspecialchars($user['name']); ?></span>
                <?php endif; ?>
              </ul>
            </nav>
        </header>
        <div class="clients_orders-container">
            <h2>Заказы клиентов</h2>
            <?php if (empty($orders)): ?>
                <p>Нет данных о заказах.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID Заказа</th>
                            <th>ID Продукта</th>
                            <th>Название Продукта</th>
                            <th>Цена Продукта</th>
                            <th>ID Пользователя</th>
                            <th>Имя Пользователя</th>
                            <th>Email Пользователя</th>
                            <th>Дата Заказа</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['id_orders']); ?></td>
                                <td><?php echo htmlspecialchars($order['id_product']); ?></td>
                                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['product_price']); ?> ₽</td>
                                <td><?php echo htmlspecialchars($order['id_user']); ?></td>
                                <td><?php echo htmlspecialchars($order['name']); ?></td>
                                <td><?php echo htmlspecialchars($order['email']); ?></td>
                                <td><?php echo htmlspecialchars((new DateTime($order['order_date']))->format('Y-m-d')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
