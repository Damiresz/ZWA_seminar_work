<?php

/**
 * Soubor obsahující stránku administrace pro úpravu konkrétního produktu.
 *
 * Tento soubor zahrnuje inicializaci relace, načítání potřebných souborů a zpracování
 * příchozích GET a POST požadavků podle definovaných tras. Zobrazuje administrativní rozhraní,
 * kde administrátoři mohou provádět úpravy.
 */
// Kontrola administratora. Pokud uživatel není administratorem, přesměruje na stránku s chybou 404.
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  Not_Found();
}
// Vložení potřebných souborů pro šablonu a vygenerování hlavičky stránky s názvem "Product Processing".
include BASE_DIR . 'php_logic/get_data.php';
include BASE_DIR . 'templates/templates.php';
echo generateHeader('Product Processing');
?>

<body>
  <?php
  // Vygenerování navigačního menu.
  echo generateNavigation();
  if (isset($_GET['get_product'])) {
    $product = getProductById($_GET['get_product']);
  }
  ?>
  <div>
    <div class="container">
      <div class="profil-basket add_products">
        <div class="profil">
          <?php
          if (isset($_GET['get_product'])) { ?>
            <h1 class="add__title">Modify product</h1>
          <?php } else { ?>
            <h1 class="add__title">Add product</h1>
          <?php }
          ?>

          <p id='error_main' class="error_main"><?php
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
            <input type="hidden" name="productId" id="productId" value="<?php
                                                                        if (isset($product['id'])) {
                                                                          echo htmlspecialchars($product['id']);
                                                                        }
                                                                        ?>">
            <div class="add_products_items">
              <div class="profile__item user_form_item add__item">
                <label class='requared' for="productName">Product name</label>
                <input type="text" name="productName" id="productName" value="<?php
                                                                              if (isset($_SESSION['postData'])) {
                                                                                echo htmlspecialchars($_SESSION['postData']['productName']);
                                                                              } elseif (isset($product['name'])) {
                                                                                echo htmlspecialchars($product['name']);
                                                                              }
                                                                              ?>">
                <span class="error_local"></span>
              </div>
              <div class="profile__item user_form_item add__item">
                <label class='requared' for="productImg">Photo</label>
                <?php
                if (isset($_GET['get_product'])) { ?>
                  <label class="productImg" for="productImg">change image</label>
                <?php } else { ?>
                  <label class="productImg" for="productImg">add image</label>
                <?php }
                ?>
                <input type="file" accept="image/jpeg, image/png, image/webp, image/jpg" name="productImg" id="productImg">
                <input type="hidden" name="productImgUrl" id="productImgUrl" value="<?php
                                                                                    if (isset($product['photo_path'])) {
                                                                                      echo htmlspecialchars($product['photo_path']);
                                                                                    }
                                                                                    ?>">
                <span id="error_local_upload" class="error_local"></span>
                <span id="success_local_upload" class="success_local"></span>
                <span id="noutification_local_upload" class="noutification_local_upload"></span>
              </div>
              <div class="profile__item user_form_item add__item">
                <label class='requared' for="productDiscription">Discription</label>
                <textarea id="productDiscription" name="productDiscription" rows="10" cols="1"><?php
                                                                                                if (isset($_SESSION['postData'])) {
                                                                                                  echo htmlspecialchars($_SESSION['postData']['productDiscription']);
                                                                                                } elseif (isset($product['discription'])) {
                                                                                                  echo htmlspecialchars($product['discription']);
                                                                                                }

                                                                                                ?></textarea>
                <span class="error_local"></span>
              </div>
              <div class="profile__item user_form_item add__item">
                <label class='requared' for="productPrice">Price</label>
                <input type="number" name="productPrice" id="productPrice" value="<?php
                                                                                  if (isset($_SESSION['postData'])) {
                                                                                    echo htmlspecialchars($_SESSION['postData']['productPrice']);
                                                                                  } elseif (isset($product['price'])) {
                                                                                    echo htmlspecialchars($product['price']);
                                                                                  }
                                                                                  ?>">
                <span class="error_local"></span>
              </div>
              <?php
              if (isset($product['category_id'])) { ?>
                <input id="selectedCategoryId" type="hidden" value="<?php
                                                                    echo json_encode($product['category_id']);
                                                                    ?>">
              <?php } ?>
              <div class="profile__item user_form_item add__item">
                <label class='requared' for="productCategory">Category</label>
                <select id="productCategory" name="productCategory">
                </select>
                <span class="error_local"></span>
              </div>

            </div>
            <?php
            if (isset($_GET['get_product'])) { ?>
              <button class="profil_submit" name="modify_product" type="submit">Modify product</button>
            <?php } else { ?>
              <button class="profil_submit" name="add_product" type="submit">add to database</button>
            <?php }
            ?>
          </form>

        </div>
      </div>
    </div>
  </div>
  <?php
  // Vložení souboru s funkcemi a odstranění session chyb
  require_once BASE_DIR . 'php_logic/func.php';
  removeErrorSession();
  // Smazaní nepoužitych obrazovek
  checkAndDeleteFiles(); ?>
</body>

</html>