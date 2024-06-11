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
            <img src="../img/logo.png" class="logo.png" width="150px" alt="Company Logo" />
            <nav>
                <ul>
                    <span><a href="product_catalog.php">Каталог товаров</a></span>
                    <span><a href="cart.php">Корзина</a></span>
                    <span><a href="orders.php">Заказы</a></span>
                    <span class="admin <?php if ($user['email'] !== 'abdul.abdullaev.2005@gmail.com') echo 'hide'; ?>"><a href="create_product.php">Добавить товар</a></span>
                    <span class="customers admin <?php if ($user['email'] !== 'abdul.abdullaev.2005@gmail.com') echo 'hide'; ?>"><a href="clients.php">Клиенты</a></span>
                    <span class="customers admin <?php if ($user['email'] !== 'abdul.abdullaev.2005@gmail.com') echo 'hide'; ?>"><a href="clients_order.php">Заказы клиентов</a></span>
                    <span class="user">Здравствуйте, <?php echo htmlspecialchars($user['name']); ?></span>
                    <span class="admin <?php if ($user['email'] !== 'abdul.abdullaev.2005@gmail.com') echo 'hide'; ?>"><a href="sales_chart.php">График продаж</a></span>
                    <span class="admin <?php if ($user['email'] !== 'abdul.abdullaev.2005@gmail.com') echo 'hide'; ?>"><a href="sales_report.php">Отчет по продажам</a></span>
                    <span><a href="log_in.php" class="log-in">Выйти из аккаунта</a></span>
                </ul>
            </nav>
        </header>
        <div class="hero">
            <div class="hero-info">
                <h1>BazarCRM - Ваш универсальный инструмент для управления бизнесом</h1>
                <h2>Все, что нужно для эффективного управления товарами, заказами и клиентами, в одном месте!</h2>
                <p>
                    <span>Полный каталог товаров:</span> Легко добавляйте, обновляйте и организуйте свой ассортимент с помощью нашего удобного каталога товаров. Быстрая навигация и интуитивно понятный интерфейс помогут вам управлять продуктами с максимальной эффективностью.
                </p>
                <p>
                    <span>Удобная корзина и заказы:</span> Предоставьте своим клиентам удобный процесс покупки. Наша система корзины позволяет легко добавлять товары, оформлять заказы и отслеживать их статус. Управление заказами никогда не было проще!
                </p>
                <p>
                    <span>Детализированная аналитика и отчеты:</span> Получайте точные данные и глубокий анализ ваших продаж и заказов. Наша аналитическая система предоставляет вам важные инсайты для принятия обоснованных решений и стратегического планирования.
                </p>
                <p>
                    <span>Эффективная поддержка клиентов:</span> Обеспечьте высокий уровень обслуживания с помощью интегрированных инструментов для обратной связи и обработки запросов. Следите за удовлетворенностью клиентов и быстро реагируйте на их потребности.
                </p>
                <p>
                    <span>Интегрированные коммуникации:</span> Управляйте всеми взаимодействиями с клиентами через единую платформу. Улучшайте качество обслуживания и повышайте эффективность взаимодействия с клиентами.
                </p>
                <p>
                    <span>Расширенные административные функции:</span> Администраторы могут легко добавлять новые товары, управлять клиентскими заказами и получать доступ к аналитике продаж. Все необходимые инструменты для успешного управления бизнесом находятся под рукой.
                </p>
                <p>
                    <span>Поддержка роста и развития:</span> Наши инструменты помогают вам не только управлять текущими операциями, но и стимулировать рост вашего бизнеса. Получайте ценную аналитику для разработки стратегий и достижения новых высот.
                </p>
            </div>
            <div class="hero-png">
                <img src="../img/1.png" class="png1" width="450px" alt="Screenshot of BazarCRM" />
            </div>
        </div>
        <footer>
            <div class="footer-container">
                <div><h1 class="project">Курсовая Абдуллаев бИВТ-223</h1></div>
                <nav>
                    <ul class="footer-ul">
                        <span class="footer-text"><a href="https://vk.com/abdulsmp">Страница ВК</a></span>
                        <span class="footer-text"><a href="mailto:abdul.abdullaev.2005@gmail.com">Написать на почту</a></span>
                        <span class="footer-text"><a href=""></a></span>
                    </ul>
                </nav>
            </div>
        </footer>
    </div>
</body>
</html>
