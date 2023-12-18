<?php

/**
 * PHP skript pro odebraní produktu do košíku uživatele.
 *
 * Skript ověřuje a zpracovává POST požadavek na odebirání produktu z košíku. Kontroluje platnost požadavku,
 * existence produktu, aktivního objednávky uživatele a stavu produktu v košíku.
 *
 * @package ApiScripts
 * @author [Damir Abdullayev]
 */

// Načtení externího skriptu pro připojení k databázi
include_once '../connect_db.php';
try {
  // Spuštění relace pro práci se session
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
  if (!isset($_SESSION['id'])) {
    $data = [
      'status' => 'not_login',
      'message' => '',
    ];
    echo json_encode($data);
    exit;
  }

  // Získání hodnoty productId z POST
  $productId = $_POST['productId'];
  $userId = $_SESSION['id'];
  // Připojení k databázi
  $connect = connectToDatabase();

  // Kontrola existence produktu s daným productId v tabulce Products
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


  $sqlCheckOrder = "SELECT id_order FROM Orders WHERE user_id = ? AND close_order IS NULL";
  $stmtCheckOrder = $connect->prepare($sqlCheckOrder);
  $stmtCheckOrder->bind_param("i", $userId);
  $stmtCheckOrder->execute();
  $resultCheckOrder = $stmtCheckOrder->get_result();

  if ($resultCheckOrder->num_rows > 0) {

    $orderId = $resultCheckOrder->fetch_assoc()['id_order'];
  } else {
    $stmtCheckProductExists->close();
    $connect->close();
    $data = [
      'status' => 'error',
      'message' => 'Busket not exist',
    ];
    echo json_encode($data);
    exit;
  }
  // Kontrola, zda již takový produkt je v košíku
  $sqlCheckProduct = "SELECT * FROM order_product WHERE order_id = ? AND product_id = ?";
  $stmtCheckProduct = $connect->prepare($sqlCheckProduct);
  $stmtCheckProduct->bind_param("ii", $orderId, $productId);
  $stmtCheckProduct->execute();
  $resultCheckProduct = $stmtCheckProduct->get_result();

  if ($resultCheckProduct->num_rows > 0) {
    // Pokud produkt již existuje v košíku, odstraníme ho
    $sqlDelete = "DELETE FROM order_product WHERE order_id = ? AND product_id = ?";
    $stmtDelete = $connect->prepare($sqlDelete);
    $stmtDelete->bind_param("ii", $orderId, $productId);
    $stmtDelete->execute();
    $stmtDelete->close();
    $stmtCheckProduct->close();
    $stmtCheckOrder->close();
    $stmtCheckProductExists->close();
    $connect->close();
    $data = [
      'status' => 'success',
    ];
    // Přidělit oznámení o uspěchu
    echo json_encode($data);
    exit;
  } else {
    $stmtCheckProduct->close();
    $stmtCheckOrder->close();
    $stmtCheckProductExists->close();
    $connect->close();
    $data = [
      'status' => 'error',
      'message' => 'The product is not basket',
    ];
    // Přidělit oznámení o chybě
    echo json_encode($data);
    exit;
  }
} catch (Exception $e) {
  // Přidělit oznámení o chybě
  $data = [
    'status' => 'Error',
    'message' => $e,
  ];
  echo json_encode($data);
  exit;
}
