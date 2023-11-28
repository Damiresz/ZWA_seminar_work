<?php
session_start();

$sql_user = "SELECT * FROM Users WHERE `username` = ?";
$stmt = $connect->prepare($sql_user);
$stmt->bind_param("s", $username);
$stmt->execute();
$userData = $stmt->get_result();

   if ($userData && $userData->num_rows > 0) {
      $userData = $userData->fetch_assoc();
      if (password_verify($password, $userData['password'])) {
         $_SESSION['id'] = $userData['id'];
         $_SESSION['name'] = $userData['name'];
         $_SESSION['surname'] = $userData['surname'];
         $_SESSION['username'] = $userData['username'];
         $_SESSION['email'] = $userData['email'];
         $_SESSION['address'] = $userData['address'];
         $_SESSION['city'] = $userData['city'];
         $_SESSION['postcode'] = $userData['postcode'];
         $_SESSION['country'] = $userData['country'];
         $_SESSION['isAdmin'] = $userData['isAdmin'];
         $_SESSION['password'] = $userData['password'];
         header('Location: index.php');
         exit();
      } else {
         $userData = array();
         $main_error['login_main_error'] = 'Incorrect password';
      }
   } else {
   $main_error['login_main_error'] = 'User is not registrated';
   $connect->close();
   }