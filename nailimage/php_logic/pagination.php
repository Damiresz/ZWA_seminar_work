<?php

$perPage = 3;

function getTotalPages($perPage) {
  require_once 'connect_db.php';
  $connect = connectToDatabase();

  $stmt = $connect->prepare("SELECT COUNT(id) as total FROM Products");
  $stmt->execute();

  // Получение результата запроса
  $quantity_db = $stmt->get_result();
  $quantity = $quantity_db->fetch_assoc();

  // Закрытие соединения с базой данных
  $stmt->close();
  $connect->close();

  // Получение общего количества продуктов из результата запроса
  $totalQuantityProducts = $quantity['total'];

  // Возвращение общего количества страниц, округленного вверх
  return ceil($totalQuantityProducts / $perPage);
}


function getCurrentPage ($uri){
  preg_match("/page\/(\d+)/", $uri, $matches);

    // Если найдено совпадение, передаем значение в $_GET['page']
    if (!empty($matches[1])) {
        $_GET['page'] = $matches[1];
    }

    return $matches;
}