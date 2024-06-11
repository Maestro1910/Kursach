<?php
session_start();
require_once __DIR__ . '/../src/helpers.php';

$user = currentUser();

if ($user === false) {
    header('Location: ../../login.php');
    exit();
}

$isAdmin = $user['email'] === 'abdul.abdullaev.2005@gmail.com';

try {
    $pdo = getPDO();
    $userId = $user['id'];
    $stmt = $pdo->prepare("SELECT id_orders, product_name, product_price, order_date, SUM(quantity) as total_quantity 
                       FROM orders 
                       WHERE id_user = :id_user 
                       GROUP BY id_orders, product_name, product_price, order_date");

    $stmt->execute(['id_user' => $userId]);
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
    <title>Ваши заказы</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600&display=swap" rel="stylesheet">
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
                    <?php if ($isAdmin): ?> <!-- Проверка на админа -->
                        <span><a href="create_product.php">Добавить товар</a></span>
                        <span class="customers"><a href="clients.php">Клиенты</a></span>
                        <span class="customers"><a href="clients_order.php">Заказы клиентов</a></span>
                    <?php endif; ?>
                    <?php if (isset($user['name'])): ?>
                        <span class="user">Здравствуйте, <?php echo htmlspecialchars($user['name']); ?></span>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>

        <div class="orders-container">
            <h2>Ваши заказы</h2>
            <?php if (empty($orders)): ?>
                <p>У вас еще нет заказов.</p>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order-item">
                        <h3><?php echo htmlspecialchars($order['product_name']); ?></h3>
                        <p>Цена: <?php echo htmlspecialchars($order['product_price']); ?> ₽</p>
                        <p>Кол-во: <?php echo htmlspecialchars($order['total_quantity']); ?></p>
                        <p>Дата заказа: <?php echo htmlspecialchars($order['order_date']); ?></p>
                        <!-- Добавляем кнопку удаления -->
                        <form action="../src/actions/delete_order.php" method="post">
                            <input type="hidden" name="order_id" value="<?php echo $order['id_orders']; ?>">
                            <button type="submit" class="delete-button">Отменить</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
