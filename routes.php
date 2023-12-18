<?php

// Asociativní pole obsahující URL adresy a příslušné šablony
$urls = [
    BASE_DIR_URL => BASE_DIR.'templates/products.php', // Hlavní stránka eshopu
    LOGIN_URL => BASE_DIR.'templates/login.php', // Stránka pro přihlášení
    LOGOUT_URL => BASE_DIR.'templates/logout.php', // Stránka pro odhlášení
    REGISTRATION_URL => BASE_DIR.'templates/registration.php', // Stránka pro registraci
    PROFILE_URL => BASE_DIR.'templates/profil_basket.php', // Stránka uživatelského profilu a košíku
    ADMIN_PANEL_URL => BASE_DIR.'templates/admin_panel/admin_panel.php', // Administrátorský panel
    PRODUCT_SETTINGS_URL => BASE_DIR.'templates/admin_panel/products_settings.php', // Stránka pro nastavení produktů
    CATEGORY_SETTINGS_URL => BASE_DIR.'templates/admin_panel/category_settings.php', // Stránka pro nastavení kategorií
    USERS_SETTINGS_URL => BASE_DIR.'templates/admin_panel/users_settings.php', // Stránka pro nastavení uživatelů
    PROCESSING_PRODUCT_URL => BASE_DIR.'templates/admin_panel/processing_product.php', // Stránka pro zpracování produktů
    PROCESSING_CATEGORY_URL => BASE_DIR.'templates/admin_panel/processing_category.php', // Stránka pro zpracování kategorií
];

/**
 * Asociativní pole obsahující URL adresy a příslušné šablony pro eshop.
 *
 * Toto pole slouží k mapování URL adres na příslušné šablony pro jednotlivé části eshopu.
 *
 * @var array $urls - Asociativní pole s URL adresami a šablonami.
 * Klíče jsou URL adresy, hodnoty jsou cesty k odpovídajícím šablonám.
 */
