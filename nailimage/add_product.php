<?php if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  http_response_code(404);
  include_once BASE_DIR . '404.php';
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="<?= BASE_DIR . 'image/icons/favicon.png' ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?= BASE_DIR . 'css/main.css' ?>">
  <script defer src="<?php echo BASE_DIR .'js/listen.js'?>"></script>
  <title>Add Product</title>
</head>

<body>
  <?php include BASE_DIR . 'nav.php'; ?>

  <!-- Profil and basket -->
  <div>
    <div class="container">
      <div class="profil-basket add_products">
        <div class="profil">
          <h1 class="add__title">Add product</h1>

          <form action="http://zwa.toad.cz/~xklima/vypisform.php" method="POST" id="product_form" class="profil__form">
            <div class="add_products_items">
              <div class="profile__item  add__item">
                <label for="productName">Product name</label>
                <input type="text" name="productName" id="productName">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item  add__item">
                <label for="productImg">Photo</label>
                <input type="file" name="productImg" id="productImg">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item  add__item">
                <label for="productDiscription">Discription</label>
                <textarea id="productDiscription" name="productDiscription" rows="10" cols="" required></textarea>
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item  add__item">
                <label for="productPrice">Price</label>
                <input type="number" name="productPrice" id="productPrice">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item  add__item">
                <label for="productCategory">Category</label>
                <select id="productCategory" name="productCategory" required>
                </select>
                <spam class="error_local"></spam>
              </div>

            </div>
            <button class="profil_submit" type="submit">add to database</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</body>

</html>