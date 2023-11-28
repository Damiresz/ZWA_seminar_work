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