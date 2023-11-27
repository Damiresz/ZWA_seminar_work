<?php

if (isset($_POST['registration_user'])) {

  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];

  include 'validate/registration_form_validate.php';

  $mistakes = validate(
      $name,
      $surname,
      $username,
      $email,
      $password,
      $password2
  );

  if (empty($mistakes)) {
      $local_error = array();
      $main_error = array();
      include 'connect_db.php';

    //   
      $check_query = $connect->prepare("SELECT `username`, `email` FROM Users WHERE username=? OR email=?");
      $check_query->bind_param("ss", $username, $email);
      $check_query->execute();
      $check_query->store_result();

      $check_query->bind_result($existingUsername, $existingEmail);
      while ($check_query->fetch()) {
          if ($existingUsername == $username) {
              $local_error['username'] = "Such username already exists";
          }
          if ($existingEmail == $email) {
              $local_error['email'] = "Such email already exists";
          }
      }
  
      if (empty($local_error)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $create_user_query = $connect->prepare("INSERT INTO `Users` (`name`, `surname`, `username`, `email`, `password`) VALUES (?, ?, ?, ?, ?)");
        $create_user_query->bind_param("sssss", $name, $surname, $username, $email, $hashed_password);

        if ($create_user_query->execute()) {
            include_once 'auth_user.php';
            header('Location: index.php');
            exit();
        } else {
            $main_error['login_main_error'] = $connect->error;
        }

        $create_user_query->close();
    }

    $check_query->close();
    $connect->close();
} else {
    foreach ($mistakes as $mistake) {
        $main_error['login_main_error'] = $mistake;
    }
}
}





if (isset($_POST['authorization_user'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      include 'validate/login_form_validate.php';

      $mistakes = validate(
      $username,  
      $password,
      );
    
      if (empty($mistakes)) {
        $local_error = array();
        $main_error = array();
        include 'connect_db.php';
        include_once 'auth_user.php';
        } else {
            foreach ($mistakes as $mistake) {
                $main_error['login_main_error'] = $mistake;
            }
        } 
    }

if (isset($_POST['update_user_data'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    $country = $_POST['country'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
}

// $mistakes = validate(
//   $name,
//   $surname, 
//   $username, 
//   $email, 
//   $address, 
//   $city, 
//   $postcode, 
//   $country, 
//   $password, 
//   $password2
// );


// $name = $_POST['name'] ?? null;
//       $surname = $_POST['surname'] ?? null;
//       $username = $_POST['username'] ?? null;
//       $email = $_POST['email'] ?? null;
//       $address = $_POST['address'] ?? null;
//       $city = $_POST['city'] ?? null;
//       $postcode = $_POST['postcode'] ?? null;
//       $country = $_POST['country'] ?? null;
//       $password = $_POST['password'] ?? null;
//       $password2 = $_POST['password2'] ?? null;
?>