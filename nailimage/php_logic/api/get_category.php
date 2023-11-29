<?php
include_once '../get_data.php';

try {
    header('Content-Type: application/json');
    $categories = getCategories();

    if ($categories !== false) {
        echo json_encode($categories);
    } else {
        echo json_encode(array('error' => 'Failed to retrieve categories.'));
    }
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}

?>
