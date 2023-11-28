<?php include 'php_logic/user_data.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo $BASE_DIR .'css/main.css'?>">
  <script src="<?php echo $BASE_DIR .'js/validator.js'?>"></script>
  <title>Registration</title>
</head>

<body>
  <div class="background">
    <div class="registration">
      <h1 class="registration__title">Create account</h1>

      <h4 class="error_main"><?php
                                    if (isset($_SESSION['main_error'])) {
                                      foreach ($_SESSION['main_error'] as $key => $value){
                                        
                                          echo htmlspecialchars($value);
                                      }
                                    }?></h4>

      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="user__form" class="registration__form">
        <div class="registration__items">
          <div class="registration__item user_form_item">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php
                                                            if (isset($_SESSION['postData'])) {
                                                              foreach ($_SESSION['postData'] as $key => $value){
                                                                if ($key == 'name') {
                                                                  echo htmlspecialchars($value);
                                                                }
                                                              }
                                                            }
                                                            ?>">
            <spam class="error_local"><?php
                                      if (isset($_SESSION['local_error'])) {
                                        foreach ($_SESSION['local_error'] as $key => $value){
                                          if ($key == 'name') {
                                            echo htmlspecialchars($value);
                                          }
                                        }
                                      }
                                      ?></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="name">Surname</label>
            <input type="text" name="surname" id="surname" value="<?php
                                                                  if (isset($_SESSION['postData'])) {
                                                                    foreach ($_SESSION['postData'] as $key => $value){
                                                                      if ($key == 'surname') {
                                                                        echo htmlspecialchars($value);
                                                                      }
                                                                    }
                                                                  }
                                                                  ?>">
            <spam class="error_local"><?php
                                      if (isset($_SESSION['local_error'])) {
                                        foreach ($_SESSION['local_error'] as $key => $value){
                                          if ($key == 'surname') {
                                            echo htmlspecialchars($value);
                                          }
                                        }
                                      }
                                      ?></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php
                                                                    if (isset($_SESSION['postData'])) {
                                                                      foreach ($_SESSION['postData'] as $key => $value){
                                                                        if ($key == 'username') {
                                                                          echo htmlspecialchars($value);
                                                                        }
                                                                      }
                                                                    }
                                                                    ?>">
            <spam class="error_local"><?php
                                      if (isset($_SESSION['local_error'])) {
                                        foreach ($_SESSION['local_error'] as $key => $value){
                                          if ($key == 'username') {
                                            echo htmlspecialchars($value);
                                          }
                                        }
                                      }
                                      ?></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php
                                                              if (isset($_SESSION['postData'])) {
                                                                foreach ($_SESSION['postData'] as $key => $value){
                                                                  if ($key == 'email') {
                                                                    echo htmlspecialchars($value);
                                                                  }
                                                                }
                                                              }
                                                              ?>">
            <spam class="error_local"><?php
                                      if (isset($_SESSION['local_error'])) {
                                        foreach ($_SESSION['local_error'] as $key => $value){
                                          if ($key == 'email') {
                                            echo htmlspecialchars($value);
                                          }
                                        }
                                      }
                                      ?></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="<?php
                                                                        if (isset($_SESSION['postData'])) {
                                                                          foreach ($_SESSION['postData'] as $key => $value){
                                                                            if ($key == 'password') {
                                                                              echo htmlspecialchars($value);
                                                                            }
                                                                          }
                                                                        }
                                                                        ?>">
            <spam class="error_local"><?php
                                      if (isset($_SESSION['local_error'])) {
                                        foreach ($_SESSION['local_error'] as $key => $value){
                                          if ($key == 'password') {
                                            echo htmlspecialchars($value);
                                          }
                                        }
                                      }
                                      ?></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="password2">Password again</label>
            <input type="password" name="password2" id="password2" value="<?php
                                                                          if (isset($_SESSION['postData'])) {
                                                                            foreach ($_SESSION['postData'] as $key => $value){
                                                                              if ($key == 'password2') {
                                                                                echo htmlspecialchars($value);
                                                                              }
                                                                            }
                                                                          }
                                                                          ?>">
            <spam class="error_local"><?php
                                      if (isset($_SESSION['local_error'])) {
                                        foreach ($_SESSION['local_error'] as $key => $value){
                                          if ($key == 'password2') {
                                            echo htmlspecialchars($value);
                                          }
                                        }
                                      }
                                      ?></spam>
          </div>
        </div>
        <button type="submit" name="registration_user" class="form_button">Create Account</button>
      </form>

      <div class="registration__footer">
        <a href="<?= $LOGIN_URL ?>">If you have account? Login</a>
      </div>
    </div>
  </div>
  <?php removeErrorSession (); ?>
</body>

</html>