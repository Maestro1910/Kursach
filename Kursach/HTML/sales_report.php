<?php
require_once __DIR__ . '/../src/helpers.php';

$user = currentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet" />
    <title>MarketCRM</title>
    <link rel="stylesheet" href="../CSS/style.css" />
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
                    <span class="admin <?php if ($user['email'] !== 'abdul.abdullaev.2005@gmail.com') echo 'hide'; ?>"><a href="create_product.php">Добавить товар</a></span>
                    <span class="customers admin <?php if ($user['email'] !== 'abdul.abdullaev.2005@gmail.com') echo 'hide'; ?>"><a href="clients.php">Клиенты</a></span>
                    <span class="customers admin <?php if ($user['email'] !== 'abdul.abdullaev.2005@gmail.com') echo 'hide'; ?>"><a href="clients_order.php">Заказы клиентов</a></span>
                    <span class="user">Здравствуйте, <?php echo htmlspecialchars($user['name']); ?></span>
                    <span><a href="sales_chart.php">График продаж</a></span>
                    
                </ul>
            </nav>
        </header>
        <div class="sales-report">
            <h2>Отчет по продажам</h2>
            <table>
                <thead>
                    <tr>
                        <th>Название товара</th>
                        <th>Цена</th>
                        <th>Количество заказавших клиентов</th>
                        <th>Общее количество товаров</th>
                        <th>Сумма заказов</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once __DIR__ . '/../src/helpers.php';
                    $pdo = getPDO();
                    $stmt = $pdo->query("SELECT product_name, CAST(product_price AS DECIMAL) AS product_price, COUNT(*) AS total_sales, SUM(quantity) AS total_quantity, SUM(CAST(product_price AS DECIMAL) * quantity) AS order_amount FROM orders GROUP BY product_name, product_price");
                    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($sales as $sale) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($sale['product_name']) . "</td>";
                        echo "<td>" . number_format(htmlspecialchars($sale['product_price']), 0, ',', ' ') . " ₽</td>";
                        echo "<td>" . htmlspecialchars($sale['total_sales']) . "</td>";
                        echo "<td>" . htmlspecialchars($sale['total_quantity']) . "</td>";
                        echo "<td>" . number_format(htmlspecialchars($sale['order_amount']), 0, ',', ' ') . " ₽</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
