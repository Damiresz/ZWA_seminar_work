<?php session_start();
if (isset($_SESSION['id'])) {
  $auth_user = $_SESSION['id'];
 } else {
  $auth_user = false;
 }
 