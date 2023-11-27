<?php
session_start();
 $hashed_password = password_hash($password, PASSWORD_DEFAULT);
 echo $hashed_password;
 $sql_user = "SELECT * FROM Users WHERE `username = '$username' AND password = '$hashed_password'";
 $userData = $connect->query($sql_user);
 if ($userData && $userData->num_rows > 0) {
    $userData = $userData->fetch_assoc();

    $_SESSION['id'] = $userData['id'];
    $_SESSION['name'] = $userData['name'];
    $_SESSION['surname'] = $userData['surname'];
    $_SESSION['username'] = $userData['username'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['isAdmin'] = $userData['isAdmin'];
    header('Location: index.php');
    exit();
 } else {
    $main_error['not_regisrited'] = 'User is not registrated';
 }