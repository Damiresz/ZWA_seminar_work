<?php
function getCategories()
{
    include_once 'connect_db.php';
    $connect = connectToDatabase();
    $categories_from_db = $connect->query("SELECT * FROM Category");
    if ($categories_from_db->num_rows > 0) {
        // Преобразование результатов в ассоциативный массив
        $categories = array();
        while ($category = $categories_from_db->fetch_assoc()) {
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

function getProducts($currentPage,$perPage)
{
    include_once 'connect_db.php';
    $connect = connectToDatabase();

    // Рассчитываем смещение для SQL LIMIT
    $offset = ($currentPage - 1) * $perPage;


    $products_from_db = $connect->query("SELECT * FROM Products LIMIT $offset, $perPage");
    if ($products_from_db->num_rows > 0) {
        // Преобразование результатов в ассоциативный массив
        $products = array();
        while ($product = $products_from_db->fetch_assoc()) {
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


function uploadFile($productImg)
{   $local_error = array();
    $main_error = array();
    if (!in_array($productImg['type'], ['image/png', 'image/webp'])) {
        $local_error['type_error'] = 'invalid file type';
        setErrorSession($local_error, $main_error);
        return $local_error['type_error'];
    }
    $productImgFile = BASE_DIR . "image/products/" . time() . '_' . $productImg['name'];

 
    if (move_uploaded_file($productImg['tmp_name'], $productImgFile)) {
        $main_success['success_writting_file'] = 'The product has been added';
        $_SESSION['main_success'] = $main_success;
        return $_SESSION['main_success'];
    }  else {
        $main_error['move_error'] = 'Ошибка при перемещении файла';
        setErrorSession($local_error, $main_error);
        return $main_error['move_error'];
    }
}