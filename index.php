<?php
/**
 * Hlavní soubor aplikace.
 *
 * Tento soubor inicializuje relaci, včetně potřebných souborů a zpracovává
 * příchozí GET a POST požadavky podle definovaných tras.
 */
session_start();
// Připojení konstant a nastavení
require_once 'const.php';
require_once 'routes.php';
require_once BASE_DIR . 'php_logic/pagination.php';
require_once BASE_DIR . 'php_logic/func.php';
require_once BASE_DIR . 'php_logic/crsf.php';
/**
 * Zpracování GET požadavků.
 *
 * Získává URI, určuje odpovídající trasu a zahrnuje odpovídající zpracovatel.
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $uri = $_SERVER['REQUEST_URI'];
    // Určení parametrů a vyčištění URI
    paramsPage($uri);
    $clean_uri = clean_uri($uri);
    // Hledání odpovídajícího URI a zpracovatele
    foreach ($urls as $url => $handler) {
        if ($clean_uri === $url) {
            include $handler;
            exit();
        }
    }
}
/**
 * Zpracování POST požadavků.
 *
 * Zahrnuje soubor s nastaveními pro POST požadavky a volá odpovídající funkci pro zpracování.
 */
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentSessionId = session_id();
    require_once BASE_DIR . 'php_logic/post_settings.php';
    postWhat($_POST);
    
}
// Pokud žádná z tras neodpovídá, zobrazí stránku "Not Found"
Not_Found();

