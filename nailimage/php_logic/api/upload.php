<?php

/**
 * PHP skript pro zpracování nahrávání obrázků produktu.
 *
 * Skript ověřuje, zda požadavek používá metodu POST a zda je uživatel administrátorem.
 * Následně provádí validaci nahrávaného obrázku produktu.
 *
 * @package ApiScripts
 * @author [Damir Abdullayev]
 */
session_start();
try {

    // Nastavení HTTP hlavičky pro JSON odpověď
    header('Content-Type: application/json');

    // Inicializace datového pole
    $data = array();

    // Ověření platnosti metody požadavku
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $data = [
            'status' => 'error',
            'message' => 'Invalid request method',
        ];
        echo json_encode($data);
        exit;
    };

    // Ověření, zda je nahráván soubor 'productImg' a zda je uživatel administrátorem
    if (isset($_FILES['productImg']) && $_SESSION['isAdmin'] == 1) {

        // Získání rozměrů nahrávaného obrázku
        list($width, $height) = getimagesize($_FILES['productImg']['tmp_name']);

        // Kontrola, zda je obrázek čtvercový
        if ($width !== $height) {
            $data = [
                'status' => 'error',
                'message' => 'The image should be square',
            ];
            echo json_encode($data);
            exit;
        }

        // Kontrola povolených typů souborů
        if (!in_array($_FILES['productImg']['type'], ['image/png', 'image/webp', 'image/jpeg', 'image/jpg', 'image/heif',])) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid file type.',
            ];
            echo json_encode($data);
            exit;
        }

        // Nastavení cesty pro uložení nahrávaného obrázku
        $productImgFile = "/home/abduldam/www/nailimage/image/products/" . time() . '_' . $_FILES['productImg']['name'];

        // Přesunutí nahrávaného souboru na server
        if (move_uploaded_file($_FILES['productImg']['tmp_name'], $productImgFile)) {

            // Vytvoření obrázku z načtených dat
            $image = imagecreatefromstring(file_get_contents($productImgFile));

            // Nové rozměry obrázku
            $newWidth = 280;
            $newHeight = 280;

            // Vytvoření zmenšené verze obrázku
            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

            // Zkopírování a zmenšení obrázku
            imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            
            // Nová cesta pro zmenšený obrázek s novým názvem
            $new_productImgFile = 'nailimage/image/products/' . date('d.m.Y_H.i.s') . '_' . pathinfo($_FILES['productImg']['name'], PATHINFO_FILENAME) . '.webp';
            
            // Uložení zmenšeného obrázku ve formátu webp
            if (imagewebp($resizedImage, '/home/abduldam/www/' . $new_productImgFile, 80)) {
                // Odstranění původního obrázku
                unlink($productImgFile);
                // Vymazání paměti
                imagedestroy($image);
                imagedestroy($resizedImage);
                $data = [
                    'status' => 'success',
                    'file_url' => $new_productImgFile,
                    'message' => 'Is uploaded',
                ];
                // Přidělit oznámení o úspěchu
                echo json_encode($data);
                exit;
            } else {
                // Odstranění původního obrázku
                unlink($productImgFile);
                // Vymazání paměti
                imagedestroy($image);
                imagedestroy($resizedImage);
                $data = array(
                    'status' => 'error',
                    'message' => 'Convertation Error',
                );
                // Přidělit oznámení o chybě
                echo json_encode($data);
                exit;
            }
        } else {
            // Přidělit oznámení o chybě
            $data = array(
                'status' => 'error',
                'message' => 'Is not uploaded',
            );
            echo json_encode($data);
            exit;
        }
    } else {
        // Přidělit oznámení o chybě
        $data = [
            'status' => 'error',
            'message' => 'File is not',
        ];
        echo json_encode($data);
        exit;
    }
} catch (Exception $e) {
    // Přidělit oznámení o chybě
    echo json_encode(array('error' => $e->getMessage()));
    exit;
}
