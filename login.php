<?php include 'php_logic/user_data.php' ?>
<?php include 'php_logic/errors.php' ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="js/validator.js"></script>
    <script src="js/login.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <title>Authorization</title>
  </head>
  <body>
    <div class="background">
      <div class="registration">
        <h1 class="registration__title">Login</h1>
        <h4 class="error_main"><?php
                                      
                                      ?></h4>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="user__form" class="registration__form">
          <div class="registration__items login">
            <div class="registration__item user_form_item login">
              <label for="username">Username</label>
              <input type="text" name="username" id="username" value="<?php
                                                                    if (isset($_POST['username'])) {
                                                                      echo htmlspecialchars($_POST['username']);
                                                                    }
                                                                    ?>">
              <spam class="error_local"><?php
                                      if (empty($local_error['name'])) {
                                      } elseif ($local_error['name']) {
                                        echo htmlspecialchars($local_error['name']);
                                      }
                                      ?></spam>
            </div>
            <div class="registration__item user_form_item login">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" value="<?php
                                                                    if (isset($_POST['password'])) {
                                                                      echo htmlspecialchars($_POST['password']);
                                                                    }
                                                                    ?>">
              <spam class="error_local"><?php
                                      if (empty($local_error['name'])) {
                                      } elseif ($local_error['name']) {
                                        echo htmlspecialchars($local_error['name']);
                                      }
                                      ?></spam>
            </div>
            
          </div>
          <a href="#!" class="forgot_pwd">forgot password?</a>
          <button type="submit" name="authorization_user" class="form_button">Log in</button>
        </form>
        <div class="registration__footer">
          <a href="registration.php"
            >Don't you have an account?<br />
            Registration</a
          >
        </div>
      </div>

      <div class="forgot-pass__block">
        <div class="forgot-pass__message">
          <div id="close" class="close">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M18 6L6 18"
                stroke="#1D084B"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
              <path
                d="M6 6L18 18"
                stroke="#1D084B"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
          </div>
          <p>
            If you forgot your password, please write to the administrator
            admin@nailimage.com . Important! The request to change the password
            must be sent from the email to which it is linked to the account
            where the password was forgotten
          </p>
        </div>
      </div>
    </div>
  </body>
</html>
