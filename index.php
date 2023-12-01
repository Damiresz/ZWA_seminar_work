<?php
session_start();
include_once 'const.php';
include 'routes.php';
require_once BASE_DIR . 'php_logic/pagination.php';
require_once BASE_DIR.'php_logic/crsf.php';



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Получаем текущий URL
    $uri = $_SERVER['REQUEST_URI'];
    // Если страница то предедаем страницу в GET['page']
    getCurrentPage($uri);
    // Обрабатываем маршруты
    foreach ($urls as $url => $handler) {
        if (strpos($uri, $url) === 0) {
            // Если URL начинается с текущего маршрута, то обрабатываем
            include $handler;
            exit();
    }
}
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once BASE_DIR .'php_logic/post_settings.php';
    postWhat($_POST,);

}

// Выводим 404, если маршрут не найден


Not_Found();
// chmod -R 777 /home/abduldam/www/nailimage/image/products/
