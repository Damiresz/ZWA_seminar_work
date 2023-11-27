<?php include 'php_logic/user_data.php' ?>
<?php include 'php_logic/errors.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/main.css">
  <script src="js/validator.js"></script>
  <title>Registration</title>
</head>

<body>
  <div class="background">
    <div class="registration">
      <h1 class="registration__title">Create account</h1>

      <h4 class="error_main"><?php
                                      if (empty($main_error)) {
                                      } else {
                                        echo htmlspecialchars($main_error['connect_error']);
                                      }
                                      ?></h4>

      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="user__form" class="registration__form">
        <div class="registration__items">
          <div class="registration__item user_form_item">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php
                                                            if (isset($_POST['name'])) {
                                                              echo htmlspecialchars($_POST['name']);
                                                            }
                                                            ?>">
            <spam class="error_local"><?php
                                      if (empty($local_error['name'])) {
                                      } elseif ($local_error['name']) {
                                        echo htmlspecialchars($local_error['name']);
                                      }
                                      ?></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="name">Surname</label>
            <input type="text" name="surname" id="surname" value="<?php
                                                                  if (isset($_POST['surname'])) {
                                                                    echo htmlspecialchars($_POST['surname']);
                                                                  }
                                                                  ?>">
            <spam class="error_local"><?php
                                      if (empty($local_error['surname'])) {
                                      } elseif ($local_error['surname']) {
                                        echo htmlspecialchars($local_error['surname']);
                                      }
                                      ?></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php
                                                                    if (isset($_POST['username'])) {
                                                                      echo htmlspecialchars($_POST['username']);
                                                                    }
                                                                    ?>">
            <spam class="error_local"><?php
                                      if (empty($local_error['username'])) {
                                      } elseif ($local_error['username']) {
                                        echo htmlspecialchars($local_error['username']);
                                      }
                                      ?></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php
                                                              if (isset($_POST['email'])) {
                                                                echo htmlspecialchars($_POST['email']);
                                                              }
                                                              ?>">
            <spam class="error_local"><?php
                                      if (empty($local_error['email'])) {
                                      } elseif ($local_error['email']) {
                                        echo htmlspecialchars($local_error['email']);
                                      }
                                      ?></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="<?php
                                                                        if (isset($_POST['password'])) {
                                                                          echo htmlspecialchars($_POST['password']);
                                                                        }
                                                                        ?>">
            <spam class="error_local"><?php
                                      if (empty($local_error['password'])) {
                                      } elseif ($local_error['password']) {
                                        echo htmlspecialchars($local_error['password']);
                                      }
                                      ?></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="password2">Password again</label>
            <input type="password" name="password2" id="password2" value="<?php
                                                                          if (isset($_POST['password2'])) {
                                                                            echo htmlspecialchars($_POST['password2']);
                                                                          }
                                                                          ?>">
            <spam class="error_local"><?php
                                      if (empty($local_error['password2'])) {
                                      } elseif ($local_error['password2']) {
                                        echo htmlspecialchars($local_error['password2']);
                                      }
                                      ?></spam>
          </div>
        </div>
        <button type="submit" name="registration_user" class="form_button">Create Account</button>
      </form>

      <div class="registration__footer">
        <a href="login.php">If you have account? Login</a>
      </div>
    </div>
  </div>
</body>

</html>