<?php
include BASE_DIR . 'templates/templates.php';
echo generateHeader('NailImage | Eshop');
?>

<body>
  <?php
  $nav_btn = true;
  echo generateNavigation($nav_btn);
  ?>
  <div id="notification_items" class="notification_items">
  </div>
      
  <!-- Main -->
  <div>
    <div class="container">
      <div class="main-page">
        <!-- Aside -->
        <div class="categoty">
          <h1 class="categoty__title">Nail | Eshop</h1>
          <ul class="categoty__items">

            <?php
            include_once BASE_DIR . 'php_logic/get_data.php';
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $currentCategoryPage = isset($_GET['get_category']) ? $_GET['get_category'] : null;
            $products = getProducts($currentPage, $perPage, $currentCategoryPage);
            $categories = getCategories();
            if ($categories) {
            ?>
              <li class="categoty__item">
                <?php
                if ($currentCategoryPage == null) {
                ?>
                  <p class="categoty__link">All</p>
                <?php } else { ?>
                  <a href="<?= BASE_DIR_URL ?>" class="categoty__link">All</a>
                <?php } ?>
              </li>

              </li>
              <?php
              foreach ($categories as $category) {
                $categoryLink = BASE_DIR_URL . 'category/' . urlencode($category['name_category']);
                if (substr($categoryLink, -1) !== '/') {
                  $categoryLink .= '/';
                }

              ?>
                <li class="categoty__item">
                  <?php
                  if ($currentCategoryPage == $category['name_category']) {
                    
                  ?>
                    <p class="categoty__link"><?= $category['name_category'] ?></p>
                  <?php } else { ?>
                    <a href="<?= $categoryLink ?>" class="categoty__link"><?= $category['name_category'] ?></a>
                  <?php } ?>
                </li>
              <?php
              }
            } else {
              ?>
              <li class="categoty__item">Not Categories</li>
            <?php
            }
            ?>
          </ul>
        </div>



        <!-- Main_content -->
        <div class="main-content">
          <!-- Header -->
          <header class="header">
            <img src="<?php echo BASE_DIR . 'image/header/header-photo.webp' ?>" alt="hp">
            <div class="header_print">
              <h1 class="header_print_title">Katalog</h1>
              <p class="header_print_discription">A palette of more than 1000 colors</p>
            </div>
          </header>
          <!-- Products -->
          <ul class="products">
            <!-- Product-card -->
            <?php


            if ($products) {
              foreach ($products as $product) {
            ?>
                <li class="product-card">
                  <form id="product-card_form<?= $product['id'] ?>" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" id="productId" name="productId" value="<?= $product["id"] ?>">
                    <img src="<?= $product["photo_path"] ?>" class="product-card__img" alt="<?= $product["name"] ?>">
                    <div class="product-card__items">
                      <h2 class="product-card__title"><?= $product["name"] ?></h2>
                      <p class="product-card__price"><?= $product["price"] ?> Kč</p>
                      <p class="product-card__discription"><?= $product["discription"] ?></p>
                    </div>
                    <div class="product-card__to-basket">

                      <button type="button" onclick="addToBasket('product-card_form<?= $product['id'] ?>');" class="product-card__button" id='add_to_basket<?= $product['id'] ?>'>Add to Basket</button>
                      <!-- <input type="submit" class="product-card__button" value="Add to Basket" id ='add_to_basket' name="add_to_basket"> -->
                    </div>
                  </form>
                </li>
            <?php
              }
            } else {
              echo "<p>No Products Available</p>";
            }
            ?>
          </ul>
          <!-- Paginations -->
          <div class="paginations">
            <div class="paginations__items">
              <?php
              $paginationArray = showPagination($uri, $perPage, $currentPage, $currentCategoryPage);

              foreach ($paginationArray as $item) {
                switch ($item['type']) {
                  case 'prev':
                    echo '<a class="pagination__item" href="' . $item['url'] . '">&lt;</a>';
                    break;
                  case 'current':
                    echo '<p class="pagination__item">' . $item['value'] . '</p>';
                    break;
                  case 'link':
                    echo '<a class="pagination__item" href="' . $item['url'] . '">' . $item['value'] . '</a>';
                    break;
                  case 'next':
                    echo '<a class="pagination__item" href="' . $item['url'] . '">&gt;</a>';
                    break;
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <p class="footer_text">NailImage | 2023</p>
  </footer>
</body>

</html>