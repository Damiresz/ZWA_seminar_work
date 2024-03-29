<?php

/**
 * Soubor obsahující stránku administrace pro úpravu konkrétního uživatelského účtu.
 *
 * Tento soubor zahrnuje inicializaci relace, načítání potřebných souborů a zpracování
 * příchozích GET a POST požadavků podle definovaných tras. Zobrazuje administrativní rozhraní,
 * kde administrátoři mohou provádět změnu uživatelského hesla.
 */
// Kontrola administratora. Pokud uživatel není administratorem, přesměruje na stránku s chybou 404.
if (!isset($_SESSION[$_SESSION['secret_key'] . 'isAdmin']) || $_SESSION[$_SESSION['secret_key'] . 'isAdmin'] != 1) {
  Not_Found();
}

// Vložení potřebných souborů pro šablonu a vygenerování hlavičky stránky s názvem "Users Settings".
include BASE_DIR . 'templates/templates.php';
echo generateHeader('Users Settings');
// Vygenerování crsf tokenu.
$crsf_token = generateCSRFToken();

?>

<body>
  <?php
  // Vygenerování navigačního menu.
  echo generateNavigation();
  ?>
  <div class="user_settings_block">
    <div class="user_settings">
      <h1 class="profil__title">User Settings</h1>
      <p class="error_main"><?php
                            if (isset($_SESSION['main_error'])) {
                              foreach ($_SESSION['main_error'] as $key => $value) {
                                echo htmlspecialchars($value);
                              }
                            }
                            ?></p>
      <p class="success_main"><?php
                              if (isset($_SESSION['main_success'])) {
                                foreach ($_SESSION['main_success'] as $key => $value) {
                                  echo htmlspecialchars($value);
                                }
                              }
                              ?></p>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="user__form" class="profil__form">
        <input type="hidden" name="csrf_token" value="<?= $crsf_token ?>">
        <div class="user_settings_items">
          <div class="profile__item user_form_item add__item">
            <label class='requared' for="username">Username</label>
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
            <label class='requared' for="password">New password</label>
            <input type="password" name="password" id="password">
            <span class="error_local"></span>
          </div>
          <div class="profile__item user_form_item add__item">
            <label class='requared' for="password2">New password again</label>
            <input type="password" name="password2" id="password2">
            <span class="error_local"></span>
          </div>
        </div>
        <button type="submit" class="profil_submit" id="users_settings" name="users_settings">Change</button>
      </form>
    </div>
  </div>
  <?php
  // Vložení souboru s funkcemi a odstranění session chyb
  require_once BASE_DIR . 'php_logic/func.php';
  removeErrorSession(); ?>
</body>
</html>