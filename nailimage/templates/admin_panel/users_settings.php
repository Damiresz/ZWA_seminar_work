<?php if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  Not_Found();
}


include BASE_DIR . 'templates/templates.php';
$crsf_token = generateCSRFToken();
echo generateHeader('Users Settings');
?>

<body>
  <?php
  echo generateNavigation();
  ?>
  <div class="user_settings_block">
    <div class="user_settings">
      <h1 class="profil__title">User Settings</h1>
      <h4 class="error_main"><?php
                              if (isset($_SESSION['main_error'])) {
                                foreach ($_SESSION['main_error'] as $key => $value) {
                                  echo htmlspecialchars($value);
                                }
                              }
                              ?></h4>
      <h4 class="success_main"><?php
                                if (isset($_SESSION['main_success'])) {
                                  foreach ($_SESSION['main_success'] as $key => $value) {
                                    echo htmlspecialchars($value);
                                  }
                                }
                                ?></h4>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="user__form__data" class="profil__form">
        <input type="hidden" name="csrf_token" value="<?= $crsf_token ?>">
        <div class="user_settings_items">

          <div class="profile__item user_form_item add__item">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php
                                                                    if (isset($_SESSION['postData'])) {
                                                                      foreach ($_SESSION['postData'] as $key => $value) {
                                                                        if ($key == 'username') {
                                                                          echo htmlspecialchars($value);
                                                                        }
                                                                      }
                                                                    }
                                                                    ?>">
            <span class="error_local"></span>
          </div>

          <div class="profile__item user_form_item add__item">
            <label for="password">New password</label>
            <input type="password" name="password" id="password">
            <span class="error_local"></span>
          </div>

          <div class="profile__item user_form_item add__item">
            <label for="password2">New password again</label>
            <input type="password" name="password2" id="password2">
            <span class="error_local"></span>
          </div>

        </div>
        <button type="submit" class="profil_submit" id="users_settings" name="users_settings">Change</button>
      </form>



    </div>
  </div>







  <?php
  require_once BASE_DIR . 'php_logic/func.php';
  removeErrorSession(); ?>
</body>