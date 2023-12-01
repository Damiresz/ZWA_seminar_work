<?php
$urls = [
    INDEX_URL => BASE_DIR.'products.php',
    PRODUCTS_URL => BASE_DIR.'products.php',
    LOGIN_URL => BASE_DIR.'login.php',
    LOGOUT_URL => BASE_DIR.'logout.php',
    REGISTRATION_URL => BASE_DIR.'registration.php',
    PROFILE_URL => BASE_DIR.'profil_basket.php',
    PROFILE_URL => BASE_DIR.'profil_basket.php',
    ADMIN_PANEL_URL => BASE_DIR.'admin_panel.php',
    ADD_PRODUCT => BASE_DIR.'add_product.php',
    ADD_CATEGORY => BASE_DIR.'add_category.php',
];

function Not_Found () {
    http_response_code(404);
    include_once BASE_DIR.'404.php';
    exit();
}

