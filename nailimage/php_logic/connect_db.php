<?php

function connectToDatabase() {
  $mutex = sem_get(ftok(__FILE__, 'a'));

    // Захватываем блокировку
    sem_acquire($mutex);

        $localhost = "localhost";
        $username_db = "abduldam";
        $password_db = "Derevo1602";
        $db = "abduldam";

        $connect = new mysqli($localhost, $username_db, $password_db, $db);

        // Проверка успешного подключения
        if ($connect->connect_error) {
            die("Ошибка подключения к базе данных: " . $connect->connect_error);
        }

    // Освобождаем блокировку
    sem_release($mutex);

    return $connect;
}
?>