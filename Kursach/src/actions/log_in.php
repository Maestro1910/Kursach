<?php

require_once __DIR__ . '/../helpers.php';

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    addOldValue('email', $email);
    addValidationError('email', 'Неверный формат электронной почты');
    setMessage('error', 'Ошибка валидации');
    redirect('/Kursach/HTML/log_in.php');
}

if (empty($password)) {
    addOldValue('email', $email);
    addValidationError('password', 'Пароль обязателен');
    setMessage('error', 'Ошибка валидации');
    redirect('/Kursach/HTML/log_in.php');
}

$user = findUser($email);

if (!$user) {
    setMessage('error', "Пользователь $email не найден");
    redirect('/Kursach/HTML/log_in.php');
}

if (!password_verify($password, $user['password'])) {
    setMessage('error', "Неверный пароль");
    redirect('/Kursach/HTML/log_in.php');
}

$_SESSION['user']['id'] = $user['id'];
redirect('/Kursach/HTML/home.php');
?>
