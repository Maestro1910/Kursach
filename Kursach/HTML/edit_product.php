<?php
require_once __DIR__ . '/../src/helpers.php';

$pdo = getPDO();
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM product WHERE id_product = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Товар не найден");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <title>Редактировать товар</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <div class="create-product">
        <div class="main">
            <form action="../src/actions/update_product.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_product" value="<?php echo $product['id_product']; ?>">
                <div class="inputbox">
                    <input type="text" name="product-name" value="<?php echo htmlspecialchars($product['product_name']); ?>">
                    <label for="product-name">Название</label>
                </div>
                <div class="inputbox">
                    <input type="text" name="product-description" value="<?php echo htmlspecialchars($product['product_description']); ?>">
                    <label for="product-description">Описание</label>
                </div>
                <div class="inputbox">
                    <input type="file" name="photo">
                </div>
                <div class="inputbox">
                    <input type="text" name="price" value="<?php echo htmlspecialchars($product['price']); ?>">
                    <label for="price">Укажите цену товара</label>
                </div>
                <button class="btn-add_product">Сохранить изменения</button>
            </form>
        </div>
    </div>
</body>
</html>
