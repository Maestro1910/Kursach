<?php
session_start();
require_once __DIR__ . '/../helpers.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_FILES['photo'])) {
            throw new Exception('Файл не загружен.');
        } elseif ($_FILES['photo']['error'] != UPLOAD_ERR_OK) {
            throw new Exception('Ошибка при загрузке файла: ' . $_FILES['photo']['error']);
        }

        $productName = $_POST['product-name'];
        $productDescription = $_POST['product-description'];
        $price = $_POST['price'];
        $photo = $_FILES['photo'];

        $targetDir = "../../img/";
        $targetFile = $targetDir . basename($photo["name"]);
        $photoPath = "img/" . basename($photo["name"]);
        $uploadOk = 1;

        $check = getimagesize($photo["tmp_name"]);
        if ($check === false) {
            $uploadOk = 0;
            throw new Exception('Файл не является изображением.');
        }

        if ($photo["size"] > 5000000) {
            $uploadOk = 0;
            throw new Exception('Размер файла превышает допустимый предел.');
        }

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
            throw new Exception('Недопустимый формат файла.');
        }

        if ($uploadOk) {
            if (move_uploaded_file($photo["tmp_name"], $targetFile)) {
                $pdo = getPDO();
                $stmt = $pdo->prepare("INSERT INTO product (product_name, product_description, price, photo) VALUES (?, ?, ?, ?)");
                if ($stmt->execute([$productName, $productDescription, (int)$price, $photoPath])) {
                    header("Location: ../../HTML/product_catalog.php");
                    exit;
                } else {
                    throw new Exception('Ошибка при сохранении продукта.');
                }
            } else {
                throw new Exception('Ошибка при загрузке изображения на сервер.');
            }
        } else {
            throw new Exception('Файл не прошел проверку.');
        }
    } else {
        throw new Exception('Неверный метод запроса.');
    }
} catch (Exception $e) {
    echo 'Исключение: ',  $e->getMessage(), "\n";
}
?>
