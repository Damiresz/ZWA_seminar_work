<?php
$urls = [
    BASE_DIR_URL => BASE_DIR.'templates/products.php',
    // PRODUCTS_URL=> BASE_DIR.'templates/products.php',
    LOGIN_URL => BASE_DIR.'templates/login.php',
    LOGOUT_URL => BASE_DIR.'templates/logout.php',
    REGISTRATION_URL => BASE_DIR.'templates/registration.php',
    PROFILE_URL => BASE_DIR.'templates/profil_basket.php',
    PROFILE_URL => BASE_DIR.'templates/profil_basket.php',

    ADMIN_PANEL_URL => BASE_DIR.'templates/admin_panel/admin_panel.php',
    PRODUCT_SETTINGS_URL => BASE_DIR.'templates/admin_panel/products_settings.php',
    // PRODUCT_SETTINGS_URL_PAGES => BASE_DIR.'templates/admin_panel/products_settings.php',
    ADD_PRODUCT => BASE_DIR.'templates/admin_panel/add_product.php',
    ADD_CATEGORY => BASE_DIR.'templates/admin_panel/add_category.php',
];

function Not_Found () {
    http_response_code(404);
    include_once BASE_DIR.'templates/404.php';
    exit();
}

