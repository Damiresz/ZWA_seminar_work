<?php

$localhost = "localhost";
$username = "abduldam";
$password = "webove aplikace";
$db = "abduldam";

$connect = new mysqli($localhost, $username, $password, $db);
if($connect->connect_error) {
    die("Chyba: " . $connect->connect_error);
}
?>