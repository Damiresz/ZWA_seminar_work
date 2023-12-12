<?php
require_once '../get_data.php';
require_once '../pagination.php';
$perPage = 12;

try {
    header('Content-Type: application/json');
    $searchValue = $_GET['search'];
    $products = getProducts(null,$perPage,null,$searchValue);
    if ($products !== false) {
        echo json_encode($products);
        exit;
    } else {
        echo json_encode(array('error' => 'Failed to retrieve categories.'));
        exit;
    }
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
    exit;
}

?>