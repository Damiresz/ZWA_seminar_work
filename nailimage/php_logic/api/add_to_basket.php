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
  };

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
  $userId = $_SESSION['id'];

  $connect = connectToDatabase();

  // Проверяем, существует ли товар с указанным productId в таблице Products
  $sqlCheckProductExists = "SELECT id FROM Products WHERE id = ?";
  $stmtCheckProductExists = $connect->prepare($sqlCheckProductExists);
  $stmtCheckProductExists->bind_param("i", $productId);
  $stmtCheckProductExists->execute();
  $resultCheckProductExists = $stmtCheckProductExists->get_result();
  
  if ($resultCheckProductExists->num_rows == 0) {
    $stmtCheckProductExists->close();
    $connect->close();
    $data = [
      'status' => 'error',
      'message' => 'Products not exist',
    ];
    echo json_encode($data);
    exit;
  }

  // Проверяем, есть ли у пользователя активный заказ (без close_order)
  $sqlCheckOrder = "SELECT id_order FROM Orders WHERE user_id = ? AND close_order IS NULL";
  $stmtCheckOrder = $connect->prepare($sqlCheckOrder);
  $stmtCheckOrder->bind_param("i", $userId);
  $stmtCheckOrder->execute();
  $resultCheckOrder = $stmtCheckOrder->get_result();

  if ($resultCheckOrder->num_rows > 0) {
    // Если есть активный заказ, используем его
    $orderId = $resultCheckOrder->fetch_assoc()['id_order'];
  } else {
    // Если у пользователя нет активного заказа, создаем новый
    $sqlInsertOrder = "INSERT INTO Orders (user_id, createon_order) VALUES (?, NOW())";
    $stmtInsertOrder = $connect->prepare($sqlInsertOrder);
    $stmtInsertOrder->bind_param("i", $userId);
    $stmtInsertOrder->execute();
    // Получаем идентификатор только что созданного заказа
    $orderId = $stmtInsertOrder->insert_id;
  }

  // Проверяем, есть ли уже такой товар в корзине
  $sqlCheckProduct = "SELECT * FROM order_product WHERE order_id = ? AND product_id = ?";
  $stmtCheckProduct = $connect->prepare($sqlCheckProduct);
  $stmtCheckProduct->bind_param("ii", $orderId, $productId);
  $stmtCheckProduct->execute();
  $resultCheckProduct = $stmtCheckProduct->get_result();

  if ($resultCheckProduct->num_rows > 0) {
    // Если товар уже есть в корзине, увеличиваем количество
    $sqlUpdate = "UPDATE order_product SET quantity = quantity + 1,time_add = NOW() WHERE order_id = ? AND product_id = ?";
    $stmtUpdate = $connect->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ii", $orderId, $productId);
    $stmtUpdate->execute();
    $stmtUpdate->close();
    $stmtCheckProduct->close();
    $stmtCheckOrder->close();
    $stmtCheckProductExists->close();
    $connect->close();
    $data = [
      'status' => 'success',
      'message' => 'The product has been added to the cart',
    ];
    echo json_encode($data);
    exit;
  } else {
    // Если товара нет в корзине, добавляем его
    $sqlInsert = "INSERT INTO order_product (order_id, product_id, quantity, time_add) VALUES (?, ?, 1, NOW())";
    $stmtInsert = $connect->prepare($sqlInsert);
    $stmtInsert->bind_param("ii", $orderId, $productId);
    $stmtInsert->execute();
    $stmtInsert->close();
    $stmtCheckProduct->close();
    $stmtCheckOrder->close();
    $stmtCheckProductExists->close();
    $connect->close();
    $data = [
      'status' => 'success',
      'message' => 'The product has been added to the cart',
    ];
    echo json_encode($data);
    exit;
  }
} catch (Exception $e) {
  $data = [
    'status' => 'Error',
    'message' => $e,
  ];
  echo json_encode($data);
  exit;
}
?>
