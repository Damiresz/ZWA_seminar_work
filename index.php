<?php
session_start();
require_once 'const.php';
require_once 'routes.php';
require_once BASE_DIR . 'php_logic/pagination.php';
require_once BASE_DIR . 'php_logic/func.php';
require_once BASE_DIR . 'php_logic/crsf.php';
$perPage = PER_PAGE;



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Получаем текущий URL
    $uri = $_SERVER['REQUEST_URI'];
    // Если страница то предедаем страницу в GET['page']
    getPage($uri);
    $uri = clean_uri($uri);
    // Обрабатываем маршруты
    foreach ($urls as $url => $handler) {
        if ($uri === $url) {
            // Выполняем обработчик маршрута
            include $handler;
            exit();
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once BASE_DIR . 'php_logic/post_settings.php';
    postWhat($_POST);
    
}

Not_Found();
// chmod -R 777 /home/abduldam/www/nailimage/image/products/
