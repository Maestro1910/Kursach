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
    <link
      href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <title>Панель админа</title>
    <link rel="stylesheet" href="../CSS/style.css" />
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
            <span class="user">Здравствуйте, <?php echo $user['name']?></span>
          </ul>
        </nav>
      </header>
      <div class="create-product">
        <div class="main">
          <form action="../src/actions/create_product.php" method="post" enctype="multipart/form-data">
            <div class="inputbox">
              <input 
                type="text"
                name="product-name"
              >
              <label for="product-name">Название</label>
            </div>
            <div class="inputbox">
              <input 
                type="text"
                name="product-description"
              >
              <label for="product-description">Описание</label>
            </div>
            <div class="inputbox">
              <input 
                type="file"
                name="photo"
              >
            </div>
            <div class="inputbox">
              <input 
                type="text"
                name="price"
              >
              <label for="price">Укажите цену товара</label>
            </div>
            <button class="btn-add_product">Добавить товар</button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
