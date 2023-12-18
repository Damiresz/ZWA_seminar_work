<?php

function getCategories()
{
    include_once 'connect_db.php';
    $connect = connectToDatabase();
    $categories_from_db = $connect->query("SELECT * FROM Categories");
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

function getProducts($currentPage = null, $perPage = null, $category = null, $search = null)
{
    include_once 'connect_db.php';
    $connect = connectToDatabase();

    // Рассчитываем смещение для SQL LIMIT
    $offset = ($currentPage - 1) * $perPage;

    // Добавляем условие WHERE, если категория указана
    if ($search !== null && $perPage !== null) {
        $sql = "SELECT * FROM Products 
                WHERE (Products.name LIKE ?) 
                ORDER BY date_update DESC LIMIT ?";
        $searchParam = "%$search%";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("si",  $searchParam, $perPage);
    } else if ($category !== null && $currentPage !== null && $perPage !== null) {
        $sql = "SELECT * FROM Products
        JOIN Categories ON Products.category_id = Categories.id_category WHERE Categories.name_category = ? ORDER BY date_update DESC LIMIT ?, ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sii", $category, $offset, $perPage);
    } elseif ($category === null && $currentPage !== null && $perPage !== null) {
        $sql = "SELECT * FROM Products
        JOIN Categories ON Products.category_id = Categories.id_category ORDER BY date_update DESC LIMIT ?, ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ii", $offset, $perPage);
    } elseif ($category !== null  && $currentPage === null && $perPage === null) {
        $sql = "SELECT * FROM Products WHERE category_id = ? ORDER BY date_update DESC";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i",  $category);
    }
    $stmt->execute();

    $products_from_db = $stmt->get_result();
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

function getProductById($product_id)
{

    if (!is_numeric($product_id)) {
        Not_Found();
    }

    include_once 'connect_db.php';
    $connect = connectToDatabase();
    // Добавляем условие WHERE, если категория указана
    if ($product_id) {
        $sql = "SELECT * FROM Products WHERE id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();

        if ($stmt->error) {
            return null;
        }
        $product_id_db = $stmt->get_result();
        if ($product_id_db->num_rows == 1) {
            // Получаем ассоциативный массив с данными товара
            $productData_db = $product_id_db->fetch_assoc();

            // Закрываем соединение с базой данных
            $stmt->close();
            $connect->close();

            return $productData_db;
        } else {
            return null;
        }
    }
}


function getBasketItems()
{
    $positions = array();
    $main_error = array();
    if (isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];
        include_once 'connect_db.php';
        $connect = connectToDatabase();
        $sqlCheckOrder = "SELECT id_order FROM Orders WHERE user_id = ? AND close_order IS NULL";
        $stmtCheckOrder = $connect->prepare($sqlCheckOrder);
        $stmtCheckOrder->bind_param("i", $userId);
        $stmtCheckOrder->execute();
        $resultCheckOrder = $stmtCheckOrder->get_result();

        if ($resultCheckOrder->num_rows > 0) {
            $orderId = $resultCheckOrder->fetch_assoc()['id_order'];
            $sqlCheckBasket = "SELECT * FROM order_product
            JOIN Products ON order_product.product_id = Products.id WHERE order_id = ? ORDER BY time_add DESC";
            $stmtCheckBasket = $connect->prepare($sqlCheckBasket);
            $stmtCheckBasket->bind_param("i", $orderId);
            $stmtCheckBasket->execute();
            $resultCheckBasket = $stmtCheckBasket->get_result();
            if ($resultCheckBasket->num_rows > 0) {
                while ($position = $resultCheckBasket->fetch_assoc()) {
                    $positions[] = $position;
                }
                $connect->close();
                return $positions;
            } else {
                $connect->close();
                return $main_error;
            }
        } else {
            $connect->close();
            return array();
        }
    } else {
        return array();
    }
}


function uploadFile($productImg)
{
    $local_error = array();
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
    } else {
        $main_error['move_error'] = 'Ошибка при перемещении файла';
        setErrorSession($local_error, $main_error);
        return $main_error['move_error'];
    }
}
