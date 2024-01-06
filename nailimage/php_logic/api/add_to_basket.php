<?php

/**
 * PHP skript pro přidání produktu do košíku uživatele.
 *
 * Skript ověřuje a zpracovává POST požadavek na přidání produktu do košíku. Kontroluje platnost požadavku,
 * existence produktu, aktivní objednávky uživatele a stavu produktu v košíku.
 *
 * @package ApiScripts
 * @author [Damir Abdullayev]
 */
// Načtení externího skriptu pro připojení k databázi
include_once '../connect_db.php';
try {
  // Spuštění relace pro práci se session
  session_name('/~abduldam');
  session_start();
  // Nastavení HTTP hlavičky pro JSON odpověď
  header('Content-Type: application/json');
  // Inicializace pole pro odpověď
  $data = array();
  // Kontrola platnosti požadavku
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $data = [
      'status' => 'error',
      'message' => 'Invalid request method',
    ];
    echo json_encode($data);
    exit;
  };
  // Kontrola existence hodnoty productId v POST
  if (!isset($_POST['productId']) || !is_numeric($_POST['productId'])) {
    $data = [
      'status' => 'Error',
      'message' => 'Error product value',
    ];
    echo json_encode($data);
    exit;
  }
  // Kontrola, zda je uživatel přihlášen
  if (!isset($_SESSION[$_SESSION['secret_key'] . 'id'])) {
    $data = [
      'status' => 'not_login',
      'message' => '',
    ];
    echo json_encode($data);
    exit;
  }
  // Získání hodnoty productId z POST
  $productId = $_POST['productId'];
  $userId = $_SESSION[$_SESSION['secret_key'] . 'id'];
  // Připojení k databázi
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

  // Kontrola existence aktivní objednávky uživatele (bez close_order)
  $sqlCheckOrder = "SELECT id_order FROM Orders WHERE user_id = ? AND close_order IS NULL";
  $stmtCheckOrder = $connect->prepare($sqlCheckOrder);
  $stmtCheckOrder->bind_param("i", $userId);
  $stmtCheckOrder->execute();
  $resultCheckOrder = $stmtCheckOrder->get_result();

  if ($resultCheckOrder->num_rows > 0) {
    // Pokud existuje aktivní objednávka, použijeme ji
    $orderId = $resultCheckOrder->fetch_assoc()['id_order'];
  } else {
    // Pokud uživatel nemá aktivní objednávku, vytvoříme novou
    $sqlInsertOrder = "INSERT INTO Orders (user_id, createon_order) VALUES (?, NOW())";
    $stmtInsertOrder = $connect->prepare($sqlInsertOrder);
    $stmtInsertOrder->bind_param("i", $userId);
    $stmtInsertOrder->execute();
    // Získání identifikátoru právě vytvořené objednávky
    $orderId = $stmtInsertOrder->insert_id;
  }

  // Kontrola, zda již takový produkt není v košíku
  $sqlCheckProduct = "SELECT * FROM order_product WHERE order_id = ? AND product_id = ?";
  $stmtCheckProduct = $connect->prepare($sqlCheckProduct);
  $stmtCheckProduct->bind_param("ii", $orderId, $productId);
  $stmtCheckProduct->execute();
  $resultCheckProduct = $stmtCheckProduct->get_result();

  if ($resultCheckProduct->num_rows > 0) {
    // Pokud produkt již existuje v košíku, zvýšíme jeho počet
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
    // Pokud produktu není v košíku, přidáme ho
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
    ]; // Přidělit oznámení o uspěchu
    echo json_encode($data);
    exit;
  }
} catch (Exception $e) {
  $data = [
    'status' => 'Error',
    'message' => $e,
  ];
  // Přidělit oznámení o chybě
  echo json_encode($data);
  exit;
}
