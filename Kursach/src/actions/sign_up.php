<?php

require_once __DIR__ . '/../helpers.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirmation = $_POST['conf_pass'];
$phone = $_POST['phone'];

if (empty($name)) {
    addValidationError('name', 'Имя не может быть пустым');
}

if (!preg_match('/^([А-ЯA-Z][а-яa-z]*\s*)+$/u', $name)) {
    addValidationError('name', 'Каждое слово в имени должно начинаться с заглавной буквы');
} else {
    $name = ucwords($name);
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    addValidationError('email', 'Указана неправильная почта');
}

if (empty($password)) {
    addValidationError('password', 'Пароль пустой');
}

if ($password != $passwordConfirmation) {
    addValidationError('password', 'Пароли не совпадают');
}

if (empty($phone)) {
    addValidationError('phone', 'Номер телефона пустой');
}

if (strlen($phone) < 12 || strlen($phone) > 12) {
    addValidationError('phone', 'Номер телефона должен содержать ровно 12 символов');
}

if (!empty($_SESSION['validation'])) {
    addOldValue('name', $name);
    addOldValue('email', $email);
    addOldValue('phone', $phone);
    redirect('/Kursach/HTML/sign_up.php');
}

$pdo = getPDO();

$query = "INSERT INTO users (name, email, password, phone) VALUES (:name, :email, :password, :phone)";
$params = [
    'name' => $name, 
    'email' => $email, 
    'password' => password_hash($password, PASSWORD_DEFAULT),
    'phone' => $phone
];

$stmt = $pdo->prepare($query);

try {
    $stmt->execute($params);
} catch (\Exception $e) {
    die($e->getMessage());
}

redirect('/Kursach/HTML/log_in.php');
?>
