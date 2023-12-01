<?php
try {
    header('Content-Type: application/json');
    $data = array();
    if (isset($_FILES['productImg'])) {
        if (!in_array($_FILES['productImg']['type'], ['image/png', 'image/webp'])) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid file type',
            ];
            echo json_encode($data);
            exit;
        }

        $productImgFile = "nailimage/image/products/" . time() . '_' . $_FILES['productImg']['name'];

        if (move_uploaded_file($_FILES['productImg']['tmp_name'], '/home/abduldam/www/'.$productImgFile)) {
            $data = [
                'status' => 'success',
                'file_url' =>$productImgFile,
                'message' => 'Is uploaded',
            ];
            echo json_encode($data);
            exit;
        } else {
            $data = array(
                'status' => 'error',
                'message' => 'Is not uploaded',
            );
            echo json_encode($data);
            exit;
        }
    } else {
        $data = [
            'status' => 'error',
            'message' => 'File is not',
        ];
        echo json_encode($data);
        exit;
    }
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
    exit;
}?>