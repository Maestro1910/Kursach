<?php


session_start();


require_once __DIR__ . '/config.php';

function redirect(string $path)
{
    header (header:"Location: $path");
    die();
}

function addValidationError(string $fieldName, string $message)
{
    $_SESSION['validation'][$fieldName] = $message;
}



function hasValidationError(string $fieldName): bool
{
    return isset($_SESSION['validation'][$fieldName]);
}

function validationErrorAttr(string $fieldName)
{
    echo isset($_SESSION['validation'][$fieldName]) ? 'aria-invalid="true"' : '';
}

function validationErrorMessage(string $fieldName)
{
    $message = $_SESSION['validation'][$fieldName] ?? '';
    unset($_SESSION['validation'][$fieldName]);
    echo $message;
}

function addOldValue(string $key, mixed $value)
{
    $_SESSION['old'][$key] = $value;
}

function old(string $key)
{
    $value = $_SESSION['old'][$key] ?? '';
    unset($_SESSION['old'][$key]);
    return $value;

}


function hasMessage(string $key): bool
{
    return isset($_SESSION['message'][$key]);
}


function setMessage(string $key, string $message): void
{
    $_SESSION['message'][$key] = $message;
}

function getMessage(string $key): string
{
    $message = $_SESSION['message'][$key] ?? '';
    unset($_SESSION['message'][$key]);
    return $message;
}


function getPDO(): PDO
{
    try{
        return new \PDO(dsn:'mysql:host='. DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, username: DB_USERNAME, password: DB_PASSWORD);
    }catch (\PDOException $e){
        die($e -> getMessage());
    }
}

function findUser(string $email): array|bool
{
    $pdo = getPDO();

    $stmt = $pdo -> prepare(query:"SELECT * FROM users WHERE `email`= :email");
    $stmt -> execute(['email' => $email]);
    return $stmt -> fetch(mode:\PDO::FETCH_ASSOC);
}


function currentUser(): array|false
{
    $pdo = getPDO();
    if(!isset($_SESSION['user'])) {
        return false;
    }

    $userId = $_SESSION['user']['id'] ?? null;

    $stmt = $pdo -> prepare(query:"SELECT * FROM users WHERE `id`= :id");
    $stmt -> execute(['id' => $userId]);
    return $stmt -> fetch(mode:\PDO::FETCH_ASSOC);
}


?>