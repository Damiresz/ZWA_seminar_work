<?php

/**
 * Získá seznam všech kategorií z databáze.
 *
 * @return array Pole kategorií (každá kategorie je asociativní pole).
 */
function getCategories()
{ // Připojení k databázi
    include_once 'connect_db.php';
    $connect = connectToDatabase();
    // Dotaz na získání všech kategorií
    $categories_from_db = $connect->query("SELECT * FROM Categories");
    if ($categories_from_db->num_rows > 0) {
        // Inicializace pole pro kategorie
        $categories = array();
        // Převod výsledků na asociativní pole
        while ($category = $categories_from_db->fetch_assoc()) {
            $category = array_map('htmlspecialchars', $category);
            $categories[] = $category;
        }

        // Uzavření spojení s databází
        $connect->close();

        // Vrácení výsledků
        return $categories;
    } else {
        // Uzavření spojení s databází
        $connect->close();

        return array(); // Vrácení prázdného pole, pokud nejsou k dispozici žádné kategorie
    }
}


/**
 * Získá seznam produktů z databáze podle zadaných parametrů.
 *
 * @param int|null $currentPage Aktuální stránka.
 * @param int|null $perPage Počet produktů na stránce.
 * @param int|null $category ID kategorie produktů.
 * @param string|null $search Hledaný výraz pro filtrování produktů podle názvu.
 *
 * @return array Pole produktů (každý produkt je asociativní pole).
 */
function getProducts($currentPage = null, $perPage = null, $category = null, $search = null)
{
    if ($category !== null) {
        $category = htmlspecialchars($category);
    }
    // Připojení k databázi
    include_once 'connect_db.php';
    $connect = connectToDatabase();

    // Výpočet offsetu pro SQL LIMIT
    $offset = ($currentPage - 1) * $perPage;

    // Přidání WHERE podmínky, pokud je zadaná kategorie nebo hledaný výraz
    if ($search !== null && $perPage !== null) {
        $sql = "SELECT * FROM Products 
                WHERE (Products.name LIKE ?) 
                ORDER BY date_update DESC LIMIT ?";
        $searchParam = "%$search%";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("si",  $searchParam, $perPage);
    } else if ($category !== null && $currentPage !== null && $perPage !== null) {
        if ($currentPage < 1 || $currentPage > getTotalPages($perPage)) {
            // Uzavření spojení s databází
            $connect->close();
            return false; // Vrácení false pokud neexistuje stranka
        }
        $sql = "SELECT * FROM Products
        JOIN Categories ON Products.category_id = Categories.id_category WHERE Categories.name_category = ? ORDER BY date_update DESC LIMIT ?, ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sii", $category, $offset, $perPage);
    } elseif ($category === null && $currentPage !== null && $perPage !== null) {
        if ($currentPage < 1 || $currentPage > getTotalPages($perPage)) {
            // Uzavření spojení s databází
            $connect->close();
            return false; // Vrácení false pokud neexistuje stranka
        }
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
    // Získání výsledků dotazu
    $products_from_db = $stmt->get_result();
    if ($products_from_db->num_rows > 0) {
        // Inicializace pole pro produkty
        $products = array();
        // Převod výsledků na asociativní pole
        while ($product = $products_from_db->fetch_assoc()) {
            $product = array_map('htmlspecialchars', $product);
            $products[] = $product;
        }

        // Uzavření spojení s databází
        $connect->close();

        // Vrácení výsledků
        return $products;
    } else {
        // Uzavření spojení s databází
        $connect->close();

        return array(); // Vrácení prázdného pole, pokud nejsou k dispozici žádné produkty.
    }
}

/**
 * Získá informace o produktu z databáze na základě zadaného ID.
 *
 * @param int $product_id ID produktu.
 *
 * @return array|null Asociativní pole s informacemi o produktu nebo null, pokud produkt není nalezen.
 */
function getProductById($product_id)
{
    if ($product_id !== null) {
        $product_id = htmlspecialchars($product_id);
    }
    // Ověření, zda je zadané ID číselné
    if (!is_numeric($product_id)) {
        // Zavolání funkce pro přesměrovaní na 404)
        Not_Found();
    }

    include_once 'connect_db.php';
    $connect = connectToDatabase();
    // Příprava SQL dotazu s WHERE podmínkou pro získání informací o produktu
    if ($product_id) {
        $sql = "SELECT * FROM Products WHERE id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();

        if ($stmt->error) {
            return null;
        }
        // Získání výsledků dotazu
        $product_id_db = $stmt->get_result();
        // Ověření, zda existuje právě jeden produkt s daným ID
        if ($product_id_db->num_rows == 1) {
            // Získání asociativního pole s informacemi o produktu
            $productData_db = array_map('htmlspecialchars', $product_id_db->fetch_assoc());

            // Uzavření spojení s databází
            $stmt->close();
            $connect->close();
            // Vrácení informací o produktu
            return $productData_db;
        } else {
            // Pokud nebyl nalezen žádný produkt, vrátit null
            return null;
        }
    }
}

/**
 * Získá položky košíku pro přihlášeného uživatele.
 *
 * @return array Pole položek košíku nebo prázdné pole, pokud uživatel není přihlášen nebo košík neobsahuje žádné položky.
 */
function getBasketItems()
{ // Inicializace pole pro položky v košíku
    $positions = array();
    // Inicializace pole pro hlavní chyby
    $main_error = array();
    // Ověření, zda je uživatel přihlášen
    if (isset($_SESSION['id'])) {
        // Získání ID přihlášeného uživatele
        $userId = $_SESSION['id'];
        // Připojení k databázi
        include_once 'connect_db.php';
        $connect = connectToDatabase();
        // Kontrola existující objednávky uživatele
        $sqlCheckOrder = "SELECT id_order FROM Orders WHERE user_id = ? AND close_order IS NULL";
        $stmtCheckOrder = $connect->prepare($sqlCheckOrder);
        $stmtCheckOrder->bind_param("i", $userId);
        $stmtCheckOrder->execute();
        $resultCheckOrder = $stmtCheckOrder->get_result();
        // Pokud má uživatel existující otevřenou objednávku
        if ($resultCheckOrder->num_rows > 0) {
            // Získání ID objednávky
            $orderId = $resultCheckOrder->fetch_assoc()['id_order'];
            // Kontrola položek v košíku
            $sqlCheckBasket = "SELECT * FROM order_product
            JOIN Products ON order_product.product_id = Products.id WHERE order_id = ? ORDER BY time_add DESC";
            $stmtCheckBasket = $connect->prepare($sqlCheckBasket);
            $stmtCheckBasket->bind_param("i", $orderId);
            $stmtCheckBasket->execute();
            $resultCheckBasket = $stmtCheckBasket->get_result();
            // Pokud košík obsahuje položky
            if ($resultCheckBasket->num_rows > 0) {
                // Získání informací o položkách a přidání do pole
                while ($position = $resultCheckBasket->fetch_assoc()) {
                    $position = array_map('htmlspecialchars', $position);
                    $positions[] = $position;
                }
                // Uzavření spojení s databází
                $connect->close();
                // Vrácení pole s položkami košíku
                return $positions;
            } else {
                // Uzavření spojení s databází
                $connect->close();
                // Vrácení prázdného pole (košík neobsahuje položky)
                return $main_error;
            }
        } else {
            // Uzavření spojení s databází
            $connect->close();
            // Vrácení prázdného pole (uživatel nemá otevřenou objednávku)
            return array();
        }
    } else {
        // Vrácení prázdného pole (uživatel není přihlášen)
        return array();
    }
}
