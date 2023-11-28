<?php
$sql_user = "SELECT * FROM Users WHERE `username` = ?";
$stmt = $connect->prepare($sql_user);
$stmt->bind_param("s", $username);
$stmt->execute();
$userData = $stmt->get_result();

   if ($userData && $userData->num_rows > 0) {
      $userData = $userData->fetch_assoc();
      if (password_verify($password, $userData['password'])) {
         setSessionSuccess($userData);
         header('Location:'.$INDEX_URL);
         exit();
      } else {
         $userData = array();
         $main_error['login_main_error'] = 'Incorrect password';
         setErrorSession($local_error, $main_error);
         header('Location:'.$LOGIN_URL);
         exit;
      }
   } else {
      $userData = array();
      $main_error['login_main_error'] = 'User is not registrated';
      setErrorSession($local_error, $main_error);
      header('Location:'.$LOGIN_URL);
      exit;
   }



