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

try {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM users");

    if (!$stmt->execute()) {
        throw new Exception("Ошибка выполнения запроса: " . implode(", ", $stmt->errorInfo()));
    }

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users === false) {
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
    <title>Пользователи</title>
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
                <span><a href="create_product.php">Добавить товар</a></span>
                <span class="customers"><a href="clients.php">Клиенты</a></span>
                <span class="customers"><a href="clients_order.php">Заказы клиентов</a></span>
                <?php if (isset($user['name'])): ?>
                    <span class="user">Здравствуйте, <?php echo htmlspecialchars($user['name']); ?></span>
                <?php endif; ?>
              </ul>
            </nav>
        </header>
        <div class="users-container">
            <h2>Пользователи</h2>
            <?php if (empty($users)): ?>
                <p>Нет данных о пользователях.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Телефон</th>
                            <th>Написать на почту</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                <td>
                                    <form action="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo urlencode($user['email']); ?>" method="post" target="_blank">
                                        <button class = "table-button" type="submit">Написать</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="../src/actions/delete_user.php" method="post" onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя?');">
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                                        <button type="submit" class = "table-button">Удалить</button>
                                        <button class = "table-button" formaction="edit_user.php" formmethod="post" formtarget="_self">Редактировать</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
