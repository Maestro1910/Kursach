<?php
session_start();
require_once __DIR__ . '/../src/helpers.php';

$user = currentUser();
$isAdmin = $user['email'] === 'abdul.abdullaev.2005@gmail.com';

$pdo = getPDO();
$stmt = $pdo->query("SELECT * FROM product");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600&display=swap" rel="stylesheet">
    <title>Каталог товаров</title>
    <link rel="stylesheet" href="../CSS/style.css">
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
                <?php if ($isAdmin): ?> <!-- Проверка на администратора -->
                    <span><a href="create_product.php">Добавить товар</a></span>
                    <span class="customers"><a href="clients.php">Клиенты</a></span>
                    <span class="customers"><a href="clients_order.php">Заказы клиентов</a></span>
                <?php endif; ?>
                <span class="user">Здравствуйте, <?php echo htmlspecialchars($user['name']); ?></span>
              </ul>
            </nav>
        </header>
        <div class="product-catalog">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="../<?php echo htmlspecialchars($product['photo']); ?>" class="responsive-img" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                    <div class="product-card-content">
                        <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <p><?php echo htmlspecialchars($product['product_description']); ?></p>
                        <?php if ($product['price'] > 0): ?>
                            <p class="price">Цена: <?php echo number_format(htmlspecialchars($product['price']), 0, ',', ' '); ?> ₽</p>
                        <?php else: ?>
                            <p class="price">Цена: Бесплатно</p>
                        <?php endif; ?>
                    </div>
                    <?php if ($isAdmin): ?> <!-- Проверка на администратора -->
                        <button onclick="location.href='edit_product.php?id=<?php echo $product['id_product']; ?>'">Редактировать</button>
                        <button onclick="location.href='../src/actions/delete_product.php?id=<?php echo $product['id_product']; ?>'">Удалить</button>
                    <?php endif; ?>
                    <form action="../src/actions/add_to_cart.php" method="post" class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?php echo $product['id_product']; ?>">
                        <button type="submit" class="add-to-cart">В корзину</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Отладка формы -->
    <script>
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', event => {
                event.preventDefault();
                const formData = new FormData(form);
                const productId = formData.get('product_id');
                console.log(`Submitting form for product ID: ${productId}`);
                fetch(form.action, {
                    method: form.method,
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.text();
                })
                .then(data => {
                    console.log('Form submitted successfully.');
                    console.log(data);
                    window.location.href = '/Kursach/HTML/cart.php';
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
            });
        });
    </script>
</body>
</html>
