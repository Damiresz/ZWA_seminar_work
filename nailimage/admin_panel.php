<?php if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  http_response_code(404);
  include_once BASE_DIR.'404.php';
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="<?= BASE_DIR .'image/icons/favicon.png'?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= BASE_DIR .'css/main.css'?>">
    <title>Admin Panel</title>
  </head>

  <body>
   <?php include BASE_DIR .'nav.php';?>

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
