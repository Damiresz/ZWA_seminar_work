<?php if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  Not_Found();
}


include BASE_DIR . 'templates.php';
echo generateHeader('Add Product');
?>

<body>
  <?php
  echo generateNavigation();
  ?>
  <!-- Add Product -->
  <div>
    <div class="container">
      <div class="profil-basket add_products">
        <div class="profil">
          <h1 class="add__title">Add product</h1>
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


          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="product_form" class="profil__form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken(); ?>">
            <div class="add_products_items">
              <div class="profile__item  add__item">
                <label for="productName">Product name</label>
                <input type="text" name="productName" id="productName">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item  add__item">
                <label for="productImg">Photo</label>
                <label class="productImg" for="productImg">+add image</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
                <input type="file" name="productImg" id="productImg">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item  add__item">
                <label for="productDescription">Discription</label>
                <textarea id="productDescription" name="productDescription" rows="10" cols=""></textarea>
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item  add__item">
                <label for="productPrice">Price</label>
                <input type="number" name="productPrice" id="productPrice">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item  add__item">
                <label for="productCategory">Category</label>
                <select id="productCategory" name="productCategory">
                </select>
                <spam class="error_local"></spam>
              </div>

            </div>
            <button class="profil_submit" name="add_product" type="submit">add to database</button>
          </form>

        </div>
      </div>
    </div>
  </div>
  <?php
  require_once BASE_DIR . 'php_logic/func.php';
  removeErrorSession(); ?>
</body>

</html>