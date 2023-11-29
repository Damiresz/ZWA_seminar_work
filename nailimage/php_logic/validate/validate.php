<?php 

function isValidUsername($element) {
  $regex = '/^[a-z0-9]{3,10}$/';
  return preg_match($regex, $element);
}

function isValidEmail($element) {
  $regex = '/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/';
  return preg_match($regex, $element);
}

function isValidAddress($element) {
  $regex = '/^$|^[0-9A-Za-z\s.\/-]+$/';
  return preg_match($regex, $element);
}

function isValidPostcode($element) {
  $regex = '/^(\d{4,6})?$/';
  return preg_match($regex, $element);
}

function isValidPwd($element) {
  $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,32}$/';
  return preg_match($regex, $element);
}


// Registration
function validateRegistration ($name, $surname, $username, $email, $password, $password2) {
  $mistake = array();

  $name = trim($name);
  $surname = trim ($surname);
  $username = trim ($username);
  $email = trim ($email);
  $password = trim ($password);
  $password2 = trim ($password2);

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

  // Pwd
  if (!isset($password) & $password === null ) {
      
  }
  elseif ($password === "") {
      $mistake['password'] = "Entity cannot be empty";
  }

  elseif (!isValidPwd($password)) {
      $mistake['password'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
  }

  // Pwd2
  if (!isset($password2) & $password2 === null ) {
      
  }

  elseif ($password2 !== $password) {
              $mistake['password2'] = "Passwords don't match";
      
  } elseif ($password2 === "") {
      $mistake['password2'] = "Entity cannot be empty";
  }
  
  elseif (!isValidPwd($password2)) {
      $mistake['password2'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
  }

  return $mistake;
}

// Login 
function validateLogin ($username, $password) {
  $mistake = array();
  $username = trim ($username);
  $password = trim ($password);

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

  
  // Pwd
  if (!isset($password) & $password === null ) {
      
  }
  elseif ($password === "") {
      $mistake['password'] = "Entity cannot be empty";
  }

  elseif (!isValidPwd($password)) {
      $mistake['password'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
  }

  return $mistake;
}

// Profile
function validateProfile ($name, $surname, $username, $email, $address, $city, $postcode, $country) {
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

//Password
function validatePassword ($password, $password2) {
  $mistake = array();

  $password = trim ($password);
  $password2 = trim ($password2);

  // Pwd
  if (!isset($password) & $password === null ) {
      
  }
  elseif ($password === "") {
      $mistake['password'] = "Entity cannot be empty";
  }

  elseif (!isValidPwd($password)) {
      $mistake['password'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
  }

  // Pwd2
  if (!isset($password2) & $password2 === null ) {
      
  }
  elseif ($password && !isset($password2)) {
    exit;
  }
  elseif ($password2 !== $password) {
              $mistake['password2'] = "Passwords don't match";
      
  } elseif ($password2 === "") {
      $mistake['password2'] = "Entity cannot be empty";
  }
  
  elseif (!isValidPwd($password2)) {
      $mistake['password2'] = "The password must be at least 8 characters and contain A-Z a-z 0-9";
  }

  return $mistake;
}
