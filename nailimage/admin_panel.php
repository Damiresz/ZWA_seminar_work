<?php if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  header('Location:'.$INDEX_URL);
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= $BASE_DIR .'css/main.css'?>">
    <title>Admin Panel</title>
  </head>

  <body>
   <?php include $BASE_DIR .'nav.php';?>

    <!-- Profil and basket -->
    <div>
      <div class="container">
        <div class="profil-basket">
          <div class="profil">
            <h1 class="profil__title admin_title">Admin Panel</h1>
            <div class="user_buttons">
            <button class="profil_submit">Add product</button>
            <button class="profil_submit">Add category</button>
            <button class="profil_submit">Change user password</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
