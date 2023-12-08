<?php if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  Not_Found();
}
include BASE_DIR.'templates/templates.php';
echo generateHeader('Admin Panel');
?>

<body>
  <?php
  echo generateNavigation();
  ?>
    <!-- Profil and basket -->
    <div>
      <div class="container">
        <div class="profil-basket">
          <div class="profil">
            <h1 class="profil__title admin_title">Admin Panel</h1>
            <div class="user_buttons">
            <a href="<?= PRODUCT_SETTINGS_URL ?>" class="admin_submit">Products Settings</a>
            <a href="<?= CATEGORY_SETTINGS_URL ?>" class="admin_submit">Category Settings</a>
            <a href="<?= USERS_SETTINGS_URL ?>" class="admin_submit">User Settings</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
