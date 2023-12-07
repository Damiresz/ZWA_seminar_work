<?php
include_once '../connect_db.php';
try {
  session_start();
  header('Content-Type: application/json');
  $data = array();
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $data = [
      'status' => 'error',
      'message' => 'Invalid request method',
    ];
    echo json_encode($data);
    exit;
  }

  if (!isset($_POST['productId']) || !is_numeric($_POST['productId'])) {
    $data = [
      'status' => 'Error',
      'message' => 'Error product value',
    ];
    echo json_encode($data);
    exit;
  }

  if (!isset($_SESSION['id'])) {
    $data = [
      'status' => 'not_login',
      'message' => '',
    ];
    echo json_encode($data);
    exit;
  }

  $productId = $_POST['productId'];
  // $productId = 130;
  $userId = $_SESSION['id'];
  // $userId = 31;

  $connect = connectToDatabase();

  // Проверяем, существует ли товар с указанным productId в таблице Products
  $sqlCheckProductExists = "SELECT id FROM Products WHERE id = $productId";
  $resultCheckProductExists = $connect->query($sqlCheckProductExists);

  if ($resultCheckProductExists->num_rows == 0) {
    $connect->close();
    $data = [
      'status' => 'error',
      'message' => 'Products not exist',
    ];
    echo json_encode($data);
    exit;
  }

  // Проверяем, есть ли у пользователя активный заказ (без close_order)
  $sqlCheckOrder = "SELECT id_order FROM Orders WHERE user_id = $userId AND close_order IS NULL";
  $resultCheckOrder = $connect->query($sqlCheckOrder);

  if ($resultCheckOrder->num_rows > 0) {
    // Если есть активный заказ, используем его
    $orderId = $resultCheckOrder->fetch_assoc()['id_order'];
  } else {
    // Если у пользователя нет активного заказа, создаем новый
    $sqlInsertOrder = "INSERT INTO Orders (user_id, createon_order) VALUES ($userId, NOW())";
    $connect->query($sqlInsertOrder);
    // Получаем идентификатор только что созданного заказа
    $orderId = $connect->insert_id;
  }

  // Проверяем, есть ли уже такой товар в корзине
  $sqlCheckProduct = "SELECT * FROM order_product WHERE order_id = $orderId AND product_id = $productId";
  $resultCheckProduct = $connect->query($sqlCheckProduct);

  if ($resultCheckProduct->num_rows > 0) {
    // Если товар уже есть в корзине, увеличиваем количество
    $sqlUpdate = "UPDATE order_product SET quantity = quantity + 1 WHERE order_id = $orderId AND product_id = $productId";
    $connect->query($sqlUpdate);
    $connect->close();
    $data = [
      'status' => 'success',
      'message' => 'The product has been added to the cart',
    ];
    echo json_encode($data);
    exit;
  } else {
    // Если товара нет в корзине, добавляем его
    $sqlInsert = "INSERT INTO order_product (order_id, product_id, quantity) VALUES ($orderId, $productId, 1)";
    $connect->query($sqlInsert);
    $connect->close();
    $data = [
      'status' => 'success',
      'message' => 'The product has been added to the cart',
    ];
    echo json_encode($data);
    exit;
  }

  // Закрываем соединение с базой данных
  $connect->close();
} catch (Exception $e) {
  $errorData = [
    'status' => 'error',
    'message' => $e->getMessage(),
  ];

  // Записываем ошибку в локальный файл
  $logFile = 'errors.log';
  error_log("[" . date("Y-m-d H:i:s") . "] Error: " . $e->getMessage() . PHP_EOL, 3, $logFile);

  echo json_encode($errorData);
}
