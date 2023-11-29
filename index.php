<?php
include_once 'nailimage/php_logic/session_start.php';
include_once 'const.php';
include 'routes.php';


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Получаем текущий URL
    $uri = $_SERVER['REQUEST_URI'];
    // Обрабатываем маршруты
    foreach ($urls as $url => $handler) {
    if ($uri === $url) {
        // Выполняем обработчик маршрута
        include $handler;
        exit();
    }
}
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include $BASE_DIR .'/php_logic/user_data.php';
}

// Выводим 404, если маршрут не найден
http_response_code(404);
include_once $BASE_DIR.'404.php';
exit();