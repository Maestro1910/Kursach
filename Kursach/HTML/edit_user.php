<?php
session_start();
require_once __DIR__ . '/../src/helpers.php';

$user = currentUser();

if ($user === false) {
    header('Location: ../../login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];

    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $user_id]);
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_data === false) {
            throw new Exception("Пользователь с указанным ID не найден.");
        }

        // Вывод формы для редактирования данных пользователя
        // Внимание: этот код предполагает, что у вас есть поля для изменения информации о пользователе (например, имя, email, телефон и т.д.).
        // Не забудьте добавить соответствующие поля в форму редактирования.
    } catch (Exception $e) {
        echo "Произошла ошибка: " . $e->getMessage();
        exit();
    }
} else {
    echo "Неверный запрос.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать пользователя</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <div class="wrapper">
        <header class="container">
            <div class="logo"></div>
            <a href="/Kursach/HTML/home.php"><img src="../img/logo.png" class="logo.png" width="150px" alt="Company Logo" /></a>
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
        <div class="create-product">
            <div class="main">
             <h2>Редактировать пользователя</h2>
                <form action="../src/actions/update_user.php" method="post">
                    <div class="inputbox">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_data['id']); ?>">
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>">
                        <label class="edit-user" for="name">Имя:</label>
                    </div>
                    <div class="inputbox">
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>">
                        <label class="edit-user" for="email">Email:</label>
                    </div>
                    <div class="inputbox">
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user_data['phone']); ?>">
                        <label class="edit-user" for="phone">Телефон:</label>
                    </div>
                    <button type="submit">Сохранить изменения</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
