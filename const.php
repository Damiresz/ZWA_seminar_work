<?php

// Konstanty pro cesty k souborům
const BASE_DIR = 'nailimage/';

// Konstanty pro URL adresy
const BASE_DIR_URL = '/~abduldam/';
const LOGIN_URL = BASE_DIR_URL.'login';
const LOGOUT_URL = BASE_DIR_URL.'logout';
const REGISTRATION_URL = BASE_DIR_URL.'registration';
const PROFILE_URL = BASE_DIR_URL.'profile';

// Konstanty pro URL adresy administrátorského panelu
const ADMIN_PANEL_URL = BASE_DIR_URL.'admin_panel';

// Konstanty pro URL adresy nastavení
const PRODUCT_SETTINGS_URL = BASE_DIR_URL.'settings_products/';
const CATEGORY_SETTINGS_URL = BASE_DIR_URL.'settings_categories/';
const USERS_SETTINGS_URL = BASE_DIR_URL.'settings_users/';

// Konstanty pro URL adresy zpracování
const PROCESSING_PRODUCT_URL = BASE_DIR_URL.'processing_product/';
const PROCESSING_CATEGORY_URL = BASE_DIR_URL.'processing_categories/';

// Konstanty pro stránkování
const PER_PAGE = 6;
const PER_PAGE_ADMIN = 10;

/**
 * Konstanty obsahující základní cesty a URL adresy pro správu eshopu.
 *
 * Tyto konstanty jsou používány pro definici cest a URL adres pro různé části eshopu,
 * včetně přihlášení, odhlášení, registrace, administrátorského panelu a dalších.
 *
 * @var string BASE_DIR - Základní cesta k souborům.
 * @var string BASE_DIR_URL - Základní URL adresa pro navigaci.
 * @var string LOGIN_URL - URL adresa pro přihlášení.
 * @var string LOGOUT_URL - URL adresa pro odhlášení.
 * @var string REGISTRATION_URL - URL adresa pro registraci.
 * @var string PROFILE_URL - URL adresa pro uživatelský profil.
 * @var string ADMIN_PANEL_URL - URL adresa pro administrátorský panel.
 * @var string PRODUCT_SETTINGS_URL - URL adresa pro nastavení produktů.
 * @var string CATEGORY_SETTINGS_URL - URL adresa pro nastavení kategorií.
 * @var string USERS_SETTINGS_URL - URL adresa pro nastavení uživatelů.
 * @var string PROCESSING_PRODUCT_URL - URL adresa pro zpracování produktů.
 * @var string PROCESSING_CATEGORY_URL - URL adresa pro zpracování kategorií.
 * @var int PER_PAGE - Počet položek na stránku pro standardní stránkování.
 * @var int PER_PAGE_ADMIN - Počet položek na stránku pro administrátorské stránkování.
 */
