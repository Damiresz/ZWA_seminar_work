<?php

$localhost = "localhost";
$username_db = "abduldam";
$password_db = "webove aplikace";
$db = "abduldam";

$connect = new mysqli($localhost, $username_db, $password_db, $db);
if($connect->connect_error) {
    die("Error: " . $connect->connect_error);
}


?>