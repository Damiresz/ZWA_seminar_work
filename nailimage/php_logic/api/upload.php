<?php
session_start();
try {
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
    
    if (isset($_FILES['productImg']) && $_SESSION['isAdmin'] == 1) {

        list($width, $height) = getimagesize($_FILES['productImg']['tmp_name']);

        if ($width !== $height) {
            $data = [
                'status' => 'error',
                'message' => 'The image should be square',
            ];
            echo json_encode($data);
            exit;
        }

        if (!in_array($_FILES['productImg']['type'], ['image/png', 'image/webp', 'image/jpeg', 'image/jpg', 'image/heif',])) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid file type.',
            ];
            echo json_encode($data);
            exit;
        }


        $productImgFile = "/home/abduldam/www/nailimage/image/products/" . time() . '_' . $_FILES['productImg']['name'];

        if (move_uploaded_file($_FILES['productImg']['tmp_name'], $productImgFile)) {

            $image = imagecreatefromstring(file_get_contents($productImgFile));

            $newWidth = 280;
            $newHeight = 280;

            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

            imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            $new_productImgFile = 'nailimage/image/products/' . date('d.m.Y_H.i.s') . '_' . pathinfo($_FILES['productImg']['name'], PATHINFO_FILENAME) . '.webp';
            if (imagewebp($resizedImage, '/home/abduldam/www/'.$new_productImgFile, 80)) {
                unlink($productImgFile);
                imagedestroy($image);
                imagedestroy($resizedImage);
                $data = [
                    'status' => 'success',
                    'file_url' => $new_productImgFile,
                    'message' => 'Is uploaded',
                ];
                echo json_encode($data);
                exit;
            } else {
                unlink($productImgFile);
                imagedestroy($image);
                imagedestroy($resizedImage);
                $data = array(
                    'status' => 'error',
                    'message' => 'Convertation Error',
                );
                echo json_encode($data);
                exit;
            }
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
}
