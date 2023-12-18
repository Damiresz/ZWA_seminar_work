<?php

/**
 * Funkce isValidUsername() ověřuje platnost uživatelského jména pomocí regulárního výrazu.
 *
 * @param string $element Uživatelské jméno k ověření.
 *
 * @return bool Vrací `true`, pokud je uživatelské jméno platné, a `false` v opačném případě.
 */
function isValidUsername($element)
{
    $regex = '/^[a-z0-9]{3,10}$/';
    return preg_match($regex, $element);
}


/**
 * Funkce isValidEmail() ověřuje platnost e-mailové adresy pomocí regulárního výrazu.
 *
 * @param string $element E-mailová adresa k ověření.
 *
 * @return bool Vrací `true`, pokud je e-mailová adresa platná, a `false` v opačném případě.
 */
function isValidEmail($element)
{
    $regex = '/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/';
    return preg_match($regex, $element);
}

/**
 * Funkce isValidAddress() ověřuje platnost adresy pomocí regulárního výrazu.
 *
 * @param string $element Adresa k ověření.
 *
 * @return bool Vrací `true`, pokud je adresa platná, a `false` v opačném případě.
 */
function isValidAddress($element)
{
    $regex = '/^$|^[0-9A-Za-z\s.\/-]+$/';
    return preg_match($regex, $element);
}


/**
 * Funkce isValidPostcode() ověřuje platnost poštovního směrovacího čísla (PSČ) pomocí regulárního výrazu.
 *
 * @param string $element PSČ k ověření.
 *
 * @return bool Vrací `true`, pokud je PSČ platné, a `false` v opačném případě.
 */
function isValidPostcode($element)
{
    $regex = '/^(\d{4,6})?$/';
    return preg_match($regex, $element);
}


/**
 * Funkce isValidPwd() ověřuje platnost hesla pomocí regulárního výrazu.
 *
 * @param string $element Heslo k ověření.
 *
 * @return bool Vrací `true`, pokud je heslo platné, a `false` v opačném případě.
 */
function isValidPwd($element)
{
    $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,32}$/';
    return preg_match($regex, $element);
}


/**
 * Funkce isValidProductPrice() ověřuje platnost ceny produktu pomocí regulárního výrazu.
 *
 * @param string $element Cena produktu k ověření.
 *
 * @return bool Vrací `true`, pokud je cena produktu platná, a `false` v opačném případě.
 */
function isValidProductPrice($element)
{
    $regex = '/^(\d{1,6})?$/';
    return preg_match($regex, $element);
}


/**
 * Funkce isValidCategoryName() ověřuje platnost názvu kategorie pomocí regulárního výrazu.
 *
 * @param string $element Název kategorie k ověření.
 *
 * @return bool Vrací `true`, pokud je název kategorie platný, a `false` v opačném případě.
 */
function isValidCategoryName($element)
{
    $regex = '/^[a-z]{2,8}$/';
    return preg_match($regex, $element);
}


/**
 * Funkce validateRegistration validuje data uživatelské registrace.
 *
 * @param string $name      Jméno uživatele.
 * @param string $surname   Příjmení uživatele.
 * @param string $username  Uživatelské jméno uživatele.
 * @param string $email     Emailová adresa uživatele.
 * @param string $password  Heslo uživatele.
 * @param string $password2 Potvrzení hesla uživatele.
 *
 * @return array Pole obsahující chyby validace. Prázdné pole značí, že žádné chyby nejsou.
 */
function validateRegistration($name, $surname, $username, $email, $password, $password2)
{
    $mistake = array();
    // Odstranění bílých znaků ze vstupních hodnot
    $name = trim($name);
    $surname = trim($surname);
    $username = trim($username);
    $email = trim($email);
    $password = trim($password);
    $password2 = trim($password2);

    // Validace jména
    if (!isset($name) & $name == null) {
    } elseif ($name === "") {
        $mistake['name'] = "Entity cannot be empty";
    } elseif (strlen($name) < 2) {
        $mistake['name'] = "Entity cannot be shorter than 2 characters";
    } elseif (strlen($name) > 14) {
        $mistake['name'] = "Entity cannot be longer than 14 characters";
    }

    // Validace příjmení
    if (!isset($surname) & $surname === null) {
    } elseif ($surname === "") {
        $mistake['surname'] = "Entity cannot be empty";
    } elseif (strlen($surname) < 2) {
        $mistake['surname'] = "Entity cannot be shorter than 2 characters";
    } elseif (strlen($surname) > 14) {
        $mistake['surname'] = "Entity cannot be longer than 14 characters";
    }

    // Validace uživatelského jména
    if (!isset($username) & $username === null) {
    } elseif ($username === "") {
        $mistake['username'] = "Entity cannot be empty";
    } elseif (strlen($username) < 2) {
        $mistake['username'] = "Entity cannot be shorter than 3 characters";
    } elseif (strlen($username) > 14) {
        $mistake['username'] = "Entity cannot be longer than 10 characters";
    } elseif (!isValidUsername($username)) {
        $mistake['username'] = "Entity cannot be longer than 10 characters";
    }

    // Validace emailu
    if (!isset($email) & $email === null) {
    } elseif ($email === "") {
        $mistake['email'] = "Entity cannot be empty";
    } elseif (!isValidEmail($email)) {
        $mistake['email'] = "Incorrectly entered data";
    }

    // Validace hesla
    if (!isset($password) & $password === null) {
    } elseif ($password === "") {
        $mistake['password'] = "Entity cannot be empty";
    } elseif (!isValidPwd($password)) {
        $mistake['password'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
    }

    // Validace potvrzení hesla
    if (!isset($password2) & $password2 === null) {
    } elseif ($password2 !== $password) {
        $mistake['password2'] = "Passwords don't match";
    } elseif ($password2 === "") {
        $mistake['password2'] = "Entity cannot be empty";
    } elseif (!isValidPwd($password2)) {
        $mistake['password2'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
    }

    return $mistake;
}

/**
 * Funkce validateLogin validuje data pro přihlášení uživatele.
 *
 * @param string $username Uživatelské jméno pro přihlášení.
 * @param string $password Heslo pro přihlášení.
 *
 * @return array Pole obsahující chyby validace. Prázdné pole značí, že žádné chyby nejsou.
 */
function validateLogin($username, $password)
{
    $mistake = array();
    $username = trim($username);
    $password = trim($password);

    // Validace uživatelského jména
    if (!isset($username) & $username === null) {
    } elseif ($username === "") {
        $mistake['username'] = "Entity cannot be empty";
    } elseif (strlen($username) < 2) {
        $mistake['username'] = "Entity cannot be shorter than 3 characters";
    } elseif (strlen($username) > 14) {
        $mistake['username'] = "Entity cannot be longer than 10 characters";
    } elseif (!isValidUsername($username)) {
        $mistake['username'] = "Entity cannot be longer than 10 characters";
    }


    // Validace hesla
    if (!isset($password) & $password === null) {
    } elseif ($password === "") {
        $mistake['password'] = "Entity cannot be empty";
    } elseif (!isValidPwd($password)) {
        $mistake['password'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
    }

    return $mistake;
}

/**
 * Funkce validateProfile validuje data uživatelského profilu.
 *
 * @param string $name      Jméno uživatele.
 * @param string $surname   Příjmení uživatele.
 * @param string $username  Uživatelské jméno uživatele.
 * @param string $email     Emailová adresa uživatele.
 * @param string $address   Adresa uživatele.
 * @param string $city      Město uživatele.
 * @param string $postcode  PSČ uživatele.
 * @param string $country   Země uživatele.
 *
 * @return array Pole obsahující chyby validace. Prázdné pole značí, že žádné chyby nejsou.
 */
function validateProfile($name, $surname, $username, $email, $address, $city, $postcode, $country)
{
    $mistake = array();

    $name = trim($name);
    $surname = trim($surname);
    $username = trim($username);
    $email = trim($email);
    $address = trim($address);
    $city = trim($city);
    $postcode = trim($postcode);
    $country = trim($country);

    // Validace jména
    if (!isset($name) & $name == null) {
    } elseif ($name === "") {
        $mistake['name'] = "Entity cannot be empty";
    } elseif (strlen($name) < 2) {
        $mistake['name'] = "Entity cannot be shorter than 2 characters";
    } elseif (strlen($name) > 14) {
        $mistake['name'] = "Entity cannot be longer than 14 characters";
    }

    // Validace příjmení
    if (!isset($surname) & $surname === null) {
    } elseif ($surname === "") {
        $mistake['surname'] = "Entity cannot be empty";
    } elseif (strlen($surname) < 2) {
        $mistake['surname'] = "Entity cannot be shorter than 2 characters";
    } elseif (strlen($surname) > 14) {
        $mistake['surname'] = "Entity cannot be longer than 14 characters";
    }

    // Validace uživatelského jména
    if (!isset($username) & $username === null) {
    } elseif ($username === "") {
        $mistake['username'] = "Entity cannot be empty";
    } elseif (strlen($username) < 2) {
        $mistake['username'] = "Entity cannot be shorter than 3 characters";
    } elseif (strlen($username) > 14) {
        $mistake['username'] = "Entity cannot be longer than 10 characters";
    } elseif (!isValidUsername($username)) {
        $mistake['username'] = "Entity cannot be longer than 10 characters";
    }

    // Validace emailu
    if (!isset($email) & $email === null) {
    } elseif ($email === "") {
        $mistake['email'] = "Entity cannot be empty";
    } elseif (!isValidEmail($email)) {
        $mistake['email'] = "Incorrectly entered data";
    }

    // Validace adresy
    if (!isset($address) & $address === null) {
    } elseif (!isValidAddress($address)) {
        $mistake['address'] = "Incorrectly entered address";
    }

    // Validace města
    if (!isset($city) & $city === null) {
    } elseif (!isValidAddress($city)) {
        $mistake['address'] = "Incorrectly entered address";
    }

    // Validace PSČ
    if (!isset($postcode) & $postcode === null) {
    } elseif (!isValidPostcode($postcode)) {
        $mistake['address'] = "Incorrectly entered address";
    }

    // Validace země
    if (!isset($country) & $country === null) {
    } elseif (!isValidAddress($country)) {
        $mistake['address'] = "Incorrectly entered address";
    }

    return $mistake;
}

/**
 * Funkce validatePassword validuje data hesla.
 *
 * @param string $password  Heslo uživatele.
 * @param string $password2 Potvrzení hesla uživatele.
 *
 * @return array Pole obsahující chyby validace. Prázdné pole značí, že žádné chyby nejsou.
 */
function validatePassword($password, $password2)
{
    $mistake = array();

    $password = trim($password);
    $password2 = trim($password2);

    // Validace hesla
    if (!isset($password) & $password === null) {
    } elseif ($password === "") {
        $mistake['password'] = "Entity cannot be empty";
    } elseif (!isValidPwd($password)) {
        $mistake['password'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
    }

    // Validace potvrzení hesla
    if (!isset($password2) & $password2 === null) {
    } elseif ($password && !isset($password2)) {
        exit;
    } elseif ($password2 !== $password) {
        $mistake['password2'] = "Passwords don't match";
    } elseif ($password2 === "") {
        $mistake['password2'] = "Entity cannot be empty";
    } elseif (!isValidPwd($password2)) {
        $mistake['password2'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
    }
    return $mistake;
}

/**
 * Funkce validateProduct validuje data produktu.
 *
 * @param string $productName      Název produktu.
 * @param string $productImgUrl     URL obrázku produktu.
 * @param string $productDiscription Popis produktu.
 * @param string $productPrice      Cena produktu.
 * @param string $productCategory   Kategorie produktu.
 *
 * @return array Pole obsahující chyby validace. Prázdné pole značí, že žádné chyby nejsou.
 */
function validateProduct($productName, $productImgUrl, $productDiscription, $productPrice, $productCategory)
{
    $mistake = array();

    $productName = trim($productName);
    $productPrice = trim($productPrice);
    $productCategory = trim($productCategory);

    // Validace názvu produktu
    if ($productName === "") {
        $mistake['productName'] = "Entity cannot be empty";
    } elseif (strlen($productName) < 2) {
        $mistake['productName'] = "Entity cannot be shorter than 2 characters";
    } elseif (strlen($productName) > 30) {
        $mistake['productName'] = "Entity cannot be longer than 30 characters";
    }

    // Validace URL obrázku produktu
    if ($productImgUrl === "") {
        $mistake['productName'] = "Entity cannot be empty";
    }

    // Validace popisu produktu
    if (strlen($productDiscription) < 15) {
        $mistake['productDiscription'] = "Entity cannot be shorter than 15 characters";
    } elseif (strlen($productDiscription) > 250) {
        $mistake['productDiscription'] = "Entity cannot be longer than 180 characters";
    }

    // Validace ceny produktu
    if (!isValidProductPrice($productPrice)) {
        $mistake['productPrice'] = "Incorrectly entered price";
    }

    // Validace kategorie produktu
    include_once BASE_DIR . 'php_logic/get_data.php';
    $categories = getCategories();
    if ($categories) {

        if (!in_array($productCategory, array_column($categories, 'id_category'))) {
            $mistake['productCategory'] = "Category is not valid";
        }
    }

    return $mistake;
}


/**
 * Funkce validateCategory validuje data kategorie.
 *
 * @param string $categoryName Název kategorie.
 *
 * @return array Pole obsahující chyby validace. Prázdné pole značí, že žádné chyby nejsou.
 */
function validateCategory($categoryName)
{
    $mistake = array();

    $categoryName = trim($categoryName);

    // Validace názvu kategorie
    if ($categoryName === "") {
        $mistake['categoryName'] = "Entity cannot be empty";
    } elseif (strlen($categoryName) < 2) {
        $mistake['categoryName'] = "Entity cannot be shorter than 2 characters";
    } elseif (strlen($categoryName) > 8) {
        $mistake['categoryName'] = "Entity cannot be longer than 8 characters";
    } elseif (!isValidCategoryName($categoryName)) {
        $mistake['categoryName'] = "Use only letters";
    }
    return $mistake;
}
