<?php
include_once 'validate.php';
function validate ($name, $surname, $username, $email, $address, $city, $postcode, $country) {
    $mistake = array();

    $name = trim($name);
    $surname = trim ($surname);
    $username = trim ($username);
    $email = trim ($email);
    $address = trim ($address);
    $city = trim ($city);
    $postcode = trim ($postcode);
    $country = trim ($country);

    // Name
    if (!isset($name) & $name == null ) {
        
    }
    elseif ($name === "" ) {
        $mistake['name'] = "Entity cannot be empty"; 
    }
    elseif (strlen($name) < 2) {
        $mistake['name'] = "Entity cannot be shorter than 2 characters";
    }
    elseif (strlen($name) > 14) {
        $mistake['name'] = "Entity cannot be longer than 14 characters";
    }

    // Surname
    if (!isset($surname) & $surname === null ) {
        
    } 
    elseif ($surname === "") {
        $mistake['surname'] = "Entity cannot be empty";
    }

    elseif (strlen($surname) < 2) {
        $mistake['surname'] = "Entity cannot be shorter than 2 characters";
    }

    elseif (strlen($surname) > 14) {
        $mistake['surname'] = "Entity cannot be longer than 14 characters";
    }

    // Username
    if (!isset($username) & $username === null ) {
        
    } 
    elseif ($username === "") {
        $mistake['username'] = "Entity cannot be empty";
    }

    elseif (strlen($username) < 2) {
        $mistake['username'] = "Entity cannot be shorter than 3 characters";
    }

    elseif (strlen($username) > 14) {
        $mistake['username'] = "Entity cannot be longer than 10 characters";
    }

    elseif (!isValidUsername($username)) {
        $mistake['username'] = "Entity cannot be longer than 10 characters";
    }

    // Email
    if (!isset($email) & $email === null ) {
        
    }
    elseif ($email === "") {
        $mistake['email'] = "Entity cannot be empty";
    }

    elseif (!isValidEmail($email)) {
        $mistake['email'] = "Incorrectly entered data";
    }

    // Address
    if (!isset($address) & $address === null ) {
        
    } elseif (!isValidAddress($address)) {
        $mistake['address'] = "Incorrectly entered address";
    }

    // City
    if (!isset($city) & $city === null ) {
        
    } elseif (!isValidAddress($city)) {
        $mistake['address'] = "Incorrectly entered address";
    }

    // Postcode
    if (!isset($postcode) & $postcode === null ) {
        
    } elseif (!isValidPostcode($postcode)) {
        $mistake['address'] = "Incorrectly entered address";
    }

    // Country
    if (!isset($country) & $country === null ) {
        
    } elseif (!isValidAddress($country)) {
        $mistake['address'] = "Incorrectly entered address";
    }

    return $mistake;
}

?>