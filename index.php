<?php
session_start();
require_once 'const.php';
require_once 'routes.php';
require_once BASE_DIR . 'php_logic/pagination.php';
require_once BASE_DIR . 'php_logic/func.php';
require_once BASE_DIR . 'php_logic/category_sort.php';
require_once BASE_DIR . 'php_logic/crsf.php';



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Получаем текущий URL
    $uri = $_SERVER['REQUEST_URI'];
    // Если страница то предедаем страницу в GET['page']
    getCurrentPage($uri);
    getCurrenCategotyPage($uri);
    $clean_url = clean_uri($uri);
    // Обрабатываем маршруты
    foreach ($urls as $url => $handler) {
        if ($clean_url === $url) {
            // Выполняем обработчик маршрута
            include $handler;
            exit();
        }
        // if (strpos($uri, $url) === 0 && (isset($_GET['page']) || isset($_GET['category_page']))) {error_log("uri: $uri, url: $url, page: " . $_GET['page'] . ", category_page: " . $_GET['category_page']);
        //     echo("uri: $uri, url: $url, page: " . $_GET['page'] . ", category_page: " . $_GET['category_page']);
        //     // Перенаправляем на тот же URL, но с параметром page
        //     include $handler;
        //     exit();
        // }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once BASE_DIR . 'php_logic/post_settings.php';
    postWhat($_POST,);
}

// Выводим 404, если маршрут не найден


Not_Found();
// chmod -R 777 /home/abduldam/www/nailimage/image/products/
