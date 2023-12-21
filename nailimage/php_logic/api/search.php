<?php

/**
 * PHP skript pro načítání produktů z databáze s možností vyhledávání.
 *
 * Skript načte produkty z databáze na základě zadaného vyhledávacího řetězce a vrátí je ve formátu JSON.
 *
 * @package ApiScripts
 * @author [Damir Abdullayev]
 */
// Načtení externích skriptů pro získání dat a pro stránkování
require_once '../get_data.php';
require_once '../pagination.php';
// Počet produktů na stránku
$perPage = 12;

try {
    // Nastavení HTTP hlavičky pro JSON odpověď
    header('Content-Type: application/json');
    // Získání hodnoty vyhledávání z parametru GET
    $searchValue = isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : null;
    // Získání produktů z databáze na základě vyhledávání a stránkování
    $products = getProducts(null, $perPage, null, $searchValue);
    // Výstup JSON odpovědi
    if ($products !== false) {
        echo json_encode($products);
        exit;
    } else {
        // Přidělit oznámení o chybě
        echo json_encode(array('error' => 'Failed to retrieve categories.'));
        exit;
    }
} catch (Exception $e) {
    // Přidělit oznámení o chybě
    echo json_encode(array('error' => $e->getMessage()));
    exit;
}
