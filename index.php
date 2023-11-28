<?php
$BASE_DIR = 'nailimage/';
include_once $BASE_DIR .'php_logic/session_start.php';

include 'routes.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Получаем текущий URL
    $uri = $_SERVER['REQUEST_URI'];
    // Обрабатываем маршруты
    foreach ($routes as $route => $handler) {
    if ($uri === $route) {
        // Выполняем обработчик маршрута
        include $handler;
        exit();
    }
}
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'nailimage/php_logic/user_data.php';
}




// Выводим 404, если маршрут не найден
echo "404 Not Found";