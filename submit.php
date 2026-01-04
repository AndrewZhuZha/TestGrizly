<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

/**
 * Конфигурация
 */
$dbFile = __DIR__ . '/data.json';

/**
 * Проверка метода запроса
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    response(false, ['form' => 'Метод запроса должен быть POST'], []);
}

/**
 * Получение данных из формы
 */
$data = [
    'firstName'     => trim($_POST['firstName'] ?? ''),
    'lastName'      => trim($_POST['lastName'] ?? ''),
    'middleName'    => trim($_POST['middleName'] ?? ''),
    'birthDate'     => $_POST['birthDate'] ?? '',
    'email'         => trim($_POST['email'] ?? ''),
    'maritalStatus' => $_POST['maritalStatus'] ?? '',
    'about'         => trim($_POST['about'] ?? ''),
    'phones'        => $_POST['phones'] ?? [],
    'codes'         => $_POST['country_codes'] ?? [],
    'createdAt'     => date('c'),
];

/**
 * Валидация
 */
$errors = [];

if ($data['firstName'] === '') {
    $errors['firstName'] = 'Имя обязательно';
}
if ($data['lastName'] === '') {
    $errors['lastName'] = 'Фамилия обязательна';
}
if ($data['birthDate'] === '') {
    $errors['birthDate'] = 'Дата рождения обязательна';
}
if ($data['maritalStatus'] === '') {
    $errors['maritalStatus'] = 'Укажите семейное положение';
}
if ($data['email'] === '' && empty($data['phones'])) {
    $errors['contact'] = 'Укажите телефон или email';
}
if (mb_strlen($data['about']) > 1000) {
    $errors['about'] = 'Максимум 1000 символов';
}

if (!empty($errors)) {
    response(false, $errors, $data);
}

/**
 * Работа с JSON "базой данных"
 */
if (!file_exists($dbFile)) {
    if (file_put_contents($dbFile, '[]') === false) {
        response(false, ['server' => 'Не удалось создать файл базы данных'], $data);
    }
}

$json = file_get_contents($dbFile);
$rows = json_decode($json, true);

if (!is_array($rows)) {
    $rows = [];
}

$rows[] = $data;

if (file_put_contents(
    $dbFile,
    json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
) === false) {
    response(false, ['server' => 'Не удалось сохранить данные'], $data);
}

/**
 * Успех
 */
response(true, [], $data);

/**
 * Универсальная функция ответа
 */
function response(bool $success, array $errors = [], array $data = []): void
{
    echo json_encode([
        'success' => $success,
        'errors'  => $errors,
        'data'    => $data,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
