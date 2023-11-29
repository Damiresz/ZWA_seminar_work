<?php
// Очистка всех данных сессии
$_SESSION = array();

// Если требуется, удалить куки, связанные с сессией
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Уничтожение сессии
session_destroy();

// Перенаправление на страницу после выхода
header('Location:'.INDEX_URL); // Укажите свой путь к главной странице
exit();
?>