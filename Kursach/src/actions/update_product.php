<?php
session_start();
require_once __DIR__ . '/../helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = getPDO();

    $id = $_POST['id_product'];
    $name = $_POST['product-name'];
    $description = $_POST['product-description'];
    $price = $_POST['price'];

    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo'];
        $uploadDir = __DIR__ . '/../img/';
        $photoPath = $uploadDir . basename($photo['name']);
        

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        if (move_uploaded_file($photo['tmp_name'], $photoPath)) {
            // Относительный путь для хранения в базе данных
            $relativePhotoPath = 'img/' . basename($photo['name']);
            $stmt = $pdo->prepare("UPDATE product SET product_name = ?, product_description = ?, price = ?, photo = ? WHERE id_product = ?");
            $stmt->execute([$name, $description, $price, $relativePhotoPath, $id]);
        } else {
            die('Ошибка при загрузке изображения');
        }
    } else {
        $stmt = $pdo->prepare("UPDATE product SET product_name = ?, product_description = ?, price = ? WHERE id_product = ?");
        $stmt->execute([$name, $description, $price, $id]);
    }

    header('Location: /Kursach/HTML/product_catalog.php');
    exit();
}
?>
