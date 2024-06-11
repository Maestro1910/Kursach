<?php
session_start();
require_once __DIR__ . '/../src/helpers.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$user = currentUser();

if ($user === false) {
    header('Location: ../../login.php');
    exit();
}

$pdo = getPDO();
$userId = $user['id'];

$stmt = $pdo->prepare("SELECT b.id_basket, b.product_name, b.product_price, b.quantity, p.photo 
                       FROM basket b
                       JOIN product p ON b.id_product = p.id_product
                       WHERE b.id_user = :id_user");
$stmt->execute(['id_user' => $userId]);
$basketItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$isAdmin = $user['email'] === 'abdul.abdullaev.2005@gmail.com';
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
    <title>Корзина</title>
</head>
<body>
    <div class="wrapper">
        <header class="container">
            <div class="logo"></div>
            <a href="/Kursach/HTML/home.php"><img
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
                    <?php if ($isAdmin): ?>
                        <span><a href="create_product.php">Добавить товар</a></span>
                        <span class="customers"><a href="clients.php">Клиенты</a></span>
                        <span class="customers"><a href="clients_order.php">Заказы клиентов</a></span>
                    <?php endif; ?>
                    <span class="user">Здравствуйте, <?php echo htmlspecialchars($user['name']); ?></span>
                </ul>
            </nav>
        </header>
        <div class="cart-container">
            <h2>Корзина</h2>
            <?php if (empty($basketItems)): ?>
                <p>Ваша корзина пуста.</p>
            <?php else: ?>
                <?php foreach ($basketItems as $item): ?>
                    <div class="cart-item">
                    <img src="../<?php echo htmlspecialchars($item['photo']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="responsive-img">
                        <div class="cart-item-content">
                            <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                            <p class="price">Цена: <?php echo htmlspecialchars($item['product_price']); ?> ₽</p>
                            <div class="quantity-control">
                                <form action="../src/actions/decrease_quantity.php" method="post" style="display:inline;">
                                    <input type="hidden" name="basket_id" value="<?php echo $item['id_basket']; ?>">
                                    <button type="submit" class="quantity-button">-</button>
                                </form>
                                <span class="quantity"><?php echo htmlspecialchars($item['quantity']); ?></span>
                                <form action="../src/actions/increase_quantity.php" method="post" style="display:inline;">
                                    <input type="hidden" name="basket_id" value="<?php echo $item['id_basket']; ?>">
                                    <button type="submit" class="quantity-button">+</button>
                                </form>
                            </div>
                        </div>
                        <form action="../src/actions/remove_from_cart.php" method="post" class="remove-form">
                            <input type="hidden" name="basket_id" value="<?php echo $item['id_basket']; ?>">
                            <button type="submit" class="remove-from-cart">Удалить</button>
                        </form>
                    </div>
                <?php endforeach; ?>
                <form action="../src/actions/place_order.php" method="post">
                    <label class="order-date" for="order_date">Указать дату:</label>
                    <input 
                    type="date" 
                    class="date" 
                    id="order_date" 
                    name="order_date" 
                    required
                    >
                    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_date'): ?>
                        <label class="error-message">Дата заказа не может быть раньше текущей</label>
                    <?php endif; ?>
                    <button type="submit" class="order-button">Заказать</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
