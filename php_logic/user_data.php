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
      $user_check_query = $connect->query("SELECT `username` FROM Users WHERE username='$username' LIMIT 1");
      $email_check_query = $connect->query("SELECT `email` FROM Users WHERE email='$email' LIMIT 1");
      if ($user_check_query->num_rows > 0) {
          $local_error['username'] = "Such username already exists";
      } elseif ($email_check_query->num_rows > 0) {
          $local_error['email'] = "Such email already exists";
      } else {
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);
          $sql_create_user = "INSERT INTO `Users` (`name`, `surname`, `username`, `email`,`password`)
                              VALUES ('$name','$surname','$username','$email','$hashed_password')";
          if ($connect->query($sql_create_user) === TRUE) {
              include_once 'auth_user.php';
          } else {
              $main_error['connect_error'] = $connect->error;
          }
          $connect->close();
      }
  } else {
      foreach ($mistakes as $mistake) {
          echo $mistake . '<br>';
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
            foreach ($mistakes as $miss) {
            echo $miss;
            } } }

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