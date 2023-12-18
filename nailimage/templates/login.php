<?php
/**
 * Soubor obsahující stránku pro autorizaci uživatele.
 *
 * Tento soubor zahrnuje inicializaci relace, načítání potřebných souborů, zpracování
 * příchozích POST požadavků podle definovaných tras a zobrazení formuláře pro přihlášení.
 *
 * Po odeslání formuláře probíhá ověření přihlašovacích údajů a případné přesměrování na domovskou stránku.
 */
// Vložení souboru s nastavením příspěvků a závislými soubory
include BASE_DIR . 'php_logic/post_settings.php';
include BASE_DIR . 'templates/templates.php';
// Generování HTML záhlaví stránky 'Authorization'
echo generateHeader('Authorization');
?>

<body>
    <div class="background">
      <div class="registration">
        <h1 class="registration__title">Login</h1>
         <!-- Zobrazení hlavní chyby, pokud existuje -->
        <p class="error_main"><?php
                                if (isset($_SESSION['main_error'])) {
                                  foreach ($_SESSION['main_error'] as $key => $value) {

                                    echo htmlspecialchars($value);
                                  }
                                }
                                ?></p>
 <!-- Formulář pro autorizace uživatele -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="user__form" class="registration__form">
          <input type="hidden" name="csrf_token" value="<?= generateCSRFToken(); ?>">
          <div class="registration__items login">
            <div class="registration__item user_form_item login">
              <label for="username">Username</label>
              <input autocomplete="username" type="text" name="username" id="username" value="<?php
                                                                      if (isset($_SESSION['postData'])) {
                                                                        foreach ($_SESSION['postData'] as $key => $value) {
                                                                          if ($key == 'username') {
                                                                            echo htmlspecialchars($value);
                                                                          }
                                                                        }
                                                                      }
                                                                      ?>">
              <span class="error_local"><?php
                                        if (isset($_SESSION['local_error'])) {
                                          foreach ($_SESSION['local_error'] as $key => $value) {
                                            if ($key == 'username') {
                                              echo htmlspecialchars($value);
                                            }
                                          }
                                        }
                                        ?></span>
            </div>
            <div class="registration__item user_form_item login">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" autocomplete="current-password" value="<?php
                                                                          if (isset($_SESSION['postData'])) {
                                                                            foreach ($_SESSION['postData'] as $key => $value) {
                                                                              if ($key == 'password') {
                                                                                echo htmlspecialchars($value);
                                                                              }
                                                                            }
                                                                          }
                                                                          ?>">
              <span class="error_local"><?php
                                        if (isset($_SESSION['local_error'])) {
                                          foreach ($_SESSION['local_error'] as $key => $value) {
                                            if ($key == 'password') {
                                              echo htmlspecialchars($value);
                                            }
                                          }
                                        }
                                        ?></span>
            </div>
          </div>
          <button type='button' class="forgot_pwd">forgot password?</button>
          <button type="submit" formaction="<?php echo $_SERVER['PHP_SELF']; ?>" name="authorization_user" class="form_button">Log in</button>
        </form>

        <div class="registration__footer">
          <a href="<?= REGISTRATION_URL ?>">Don't you have an account?<br>
            Registration</a>
        </div>
      </div>

      <div class="forgot-pass__block">
        <div class="forgot-pass__message">
          <div id="close" class="close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18 6L6 18" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M6 6L18 18" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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
    <?php
    require_once BASE_DIR . 'php_logic/func.php';
    removeErrorSession(); ?>
  </body>
  </html>