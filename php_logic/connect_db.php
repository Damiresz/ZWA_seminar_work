<?php

$localhost = "localhost";
$username_db = "abduldam";
$password_db = "Derevo1602";
$db = "abduldam";

$connect = new mysqli($localhost, $username_db, $password_db, $db);
if($connect->connect_error) {
    header('Location: error.php');
}


?>