<?php 
function getCategories() {
  include_once 'connect_db.php';
  $connect = connectToDatabase();
  $categories_from_db = $connect->query("SELECT * FROM Category");
  if ($categories_from_db->num_rows > 0) {
    // Преобразование результатов в ассоциативный массив
    $categories = array();
    while($category = $categories_from_db->fetch_assoc()) {
        $categories[] = $category;
    }

    // Закрытие соединения с базой данных
    $connect->close();

    // Возврат результатов
    return $categories;
} else {
    // Закрытие соединения с базой данных
    $connect->close();

    return array(); // Возвращаем пустой массив, если нет данных о категориях
}
}

function getProducts() {
    include_once 'connect_db.php';
    $connect = connectToDatabase();
    $products_from_db = $connect->query("SELECT * FROM Products");
    if ($products_from_db->num_rows > 0) {
      // Преобразование результатов в ассоциативный массив
      $products = array();
      while($product = $products_from_db->fetch_assoc()) {
          $products[] = $product;
      }
  
      // Закрытие соединения с базой данных
      $connect->close();
  
      // Возврат результатов
      return $products;
  } else {
      // Закрытие соединения с базой данных
      $connect->close();
  
      return array(); // Возвращаем пустой массив, если нет данных о категориях
  }
  }