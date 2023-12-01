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
          <h4 id='error_main'class="error_main"><?php
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
              <div class="profile__item user_form_item add__item">
                <label for="productName">Product name</label>
                <input type="text" name="productName" id="productName" value="<?php
                                                                              if (isset($_SESSION['postData'])) {
                                                                                echo htmlspecialchars($_SESSION['postData']['productName']);
                                                                              }
                                                                              ?>">
                <span class="error_local"></span>
              </div>
              <div class="profile__item user_form_item add__item">
                <label for="productImg">Photo</label>
                <label class="productImg" for="productImg">+add image</label>
                <input type="file" accept=".png, .webp" name="productImg" id="productImg" onchange="uploadFile()">
                <input type="hidden" name="productImgUrl" id="productImgUrl">
                <span id="error_local_upload" class="error_local"></span>
                <span id="success_local_upload" class="success_local"></span>
              </div>
              <div class="profile__item user_form_item add__item">
                <label for="productDescription">Discription</label>
                <textarea id="productDescription" name="productDescription" rows="10" cols="" value="<?php
                                                                                                      if (isset($_SESSION['postData'])) {
                                                                                                        echo htmlspecialchars($_SESSION['postData']['productDescription']);
                                                                                                      }
                                                                                                      ?>">
                                                                                                      </textarea>
                <span class="error_local"></span>
              </div>
              <div class="profile__item user_form_item add__item">
                <label for="productPrice">Price</label>
                <input type="number" name="productPrice" id="productPrice" value="<?php
                                                                                  if (isset($_SESSION['postData'])) {
                                                                                    echo htmlspecialchars($_SESSION['postData']['productPrice']);
                                                                                  }
                                                                                  ?>">
                <span class="error_local"></span>
              </div>
              <div class="profile__item user_form_item add__item">
                <label for="productCategory">Category</label>
                <select id="productCategory" name="productCategory">
                </select>
                <span class="error_local"></span>
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
  removeErrorSession();
  checkAndDeleteFiles(); ?>
</body>

</html>