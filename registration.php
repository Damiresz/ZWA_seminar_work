<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/main.css" />
  <script src="js/validator.js"></script>
  <title>Registration</title>
</head>

<body>
  <div class="background">
    <div class="registration">
      <h1 class="registration__title">Create account</h1>
      <div class="eroor"></div>
<?php include_once "php_logic/form_validate.php" ?>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="user__form" class="registration__form">
        <div class="registration__items">
          <div class="registration__item user_form_item">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php
                                                            if (isset($_POST['name'])) {
                                                              echo htmlspecialchars($_POST['name']);
                                                            }
                                                            ?>">
            <spam class="error_local"></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="name">Surname</label>
            <input type="text" name="surname" id="surname" value="<?php
                                                                  if (isset($_POST['surname'])) {
                                                                    echo htmlspecialchars($_POST['surname']);
                                                                  }
                                                                  ?>">
            <spam class="error_local"></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php
                                                                    if (isset($_POST['username'])) {
                                                                      echo htmlspecialchars($_POST['username']);
                                                                    }
                                                                    ?>">
            <spam class="error_local"></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php
                                                              if (isset($_POST['email'])) {
                                                                echo htmlspecialchars($_POST['email']);
                                                              }
                                                              ?>">
            <spam class="error_local"></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="<?php
                                                                        if (isset($_POST['password'])) {
                                                                          echo htmlspecialchars($_POST['password']);
                                                                        }
                                                                        ?>">
            <spam class="error_local"></spam>
          </div>
          <div class="registration__item user_form_item">
            <label for="password2">Password again</label>
            <input type="password" name="password2" id="password2" value="<?php
                                                                          if (isset($_POST['password2'])) {
                                                                            echo htmlspecialchars($_POST['password2']);
                                                                          }
                                                                          ?>">
            <spam class="error_local"></spam>
          </div>
        </div>
        <button type="submit" class="form_button">Create Account</button>
      </form>

      <div class="registration__footer">
        <a href="login.html">If you have account? Login</a>
      </div>
    </div>
  </div>
</body>

</html>