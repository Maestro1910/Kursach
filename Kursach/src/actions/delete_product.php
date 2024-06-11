<?php
session_start();
require_once __DIR__ . '/../helpers.php';

if (isset($_GET['id'])) {
    $pdo = getPDO();
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM product WHERE id_product = ?");
    $stmt->execute([$id]);

    header('Location: /Kursach/HTML/product_catalog.php');
} else {
    die('Некорректный запрос');
}
