<?php 
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  Not_Found();
}


include BASE_DIR . 'templates/templates.php';
echo generateHeader('Category Processing');
?>

<body>
  <?php
  echo generateNavigation();
  ?>
  <!-- Add Categoty -->
  <div>
    <div class="container">
      <div class="profil-basket add_products">
        <div class="profil">
          <?php
          if (isset($_GET['get_category'])) { ?>
            <h1 class="add__title">Change category</h1>
          <?php } else { ?>
            <h1 class="add__title">Add category</h1>
          <?php }
          ?>
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


          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="product_form" class="profil__form" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken(); ?>">
            <input type="hidden" name="categoryName_old" value="<?php
                                                                if (isset($_GET['get_category'])) {
                                                                  echo htmlspecialchars($_GET['get_category']);
                                                                }
                                                                ?>">
            <div class="add_products_items">
              <div class="profile__item  add__item">
                <label class='requared' for="categoryName">Category name</label>
                <input type="text" name="categoryName" id="categoryName" value="<?php
                                                                                if (isset($_SESSION['postData'])) {
                                                                                  echo htmlspecialchars($_SESSION['postData']['categoryName']);
                                                                                } elseif (isset($_GET['get_category'])) {
                                                                                  echo htmlspecialchars($_GET['get_category']);
                                                                                }
                                                                                ?>">
                <span class="error_local"></span>
              </div>
            </div>
            <?php
            if (isset($_GET['get_category'])) { ?>
              <button class="profil_submit" name="change_category" type="submit">Change category</button>
            <?php } else { ?>
              <button class="profil_submit" name="add_category" type="submit">add to database</button>
            <?php }
            ?>
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