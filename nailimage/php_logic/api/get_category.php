<?php

/**
 * PHP skript pro načítání kategorií z databáze.
 *
 * Skript načte kategorie z databáze a vrátí je ve formátu JSON.
 *
 * @package ApiScripts
 * @author [Damir Abdullayev]
 */

// Načtení externího skriptu pro získání dat
include_once '../get_data.php';

try {
    // Nastavení HTTP hlavičky pro JSON odpověď
    header('Content-Type: application/json');
    // Získání kategorií z databáze
    $categories = getCategories();

    // Výstup JSON odpovědi
    if ($categories !== false) {
        echo json_encode($categories);
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
