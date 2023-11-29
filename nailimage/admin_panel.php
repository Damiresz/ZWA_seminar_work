<?php if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  Not_Found();
}
include BASE_DIR.'templates.php';
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
            <a href="<?= ADD_PRODUCT ?>" class="admin_submit">Add product</a>
            <a href="<?= ADD_PRODUCT ?>" class="admin_submit">Add category</a>
            <a href="<?= ADD_PRODUCT ?>" class="admin_submit">Change user password</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
