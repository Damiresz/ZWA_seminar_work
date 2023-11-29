<?php
include BASE_DIR . 'templates.php';
echo generateHeader('NailImage | Eshop');
?>
<body>
  <?php
  echo generateNavigation();
  ?>
  <!-- Main -->
  <div>
    <div class="container">
      <div class="main-page">
        <!-- Aside -->
        <aside class="aside">
          <div class="asside_fix">
            <h1 class="aside__title">Nail | Eshop</h1>
            <ul class="aside__items">
              <?php
              include_once BASE_DIR . 'php_logic/get_data.php';
              $categories = getCategories();
              if ($categories) {
                foreach ($categories as $category) {
                  echo "<li><a href='#!' class='aside__link'>" . $category['name'] . "</a></li>";
                }
              } else {
                echo "Not Categories";
              }
              ?>
            </ul>
          </div>
        </aside>
        <!-- Main_content -->
        <div class="main-content">
          <!-- Header -->
          <header class="header">
            <img src="<?php echo BASE_DIR . 'image/header/header-photo.webp' ?>" alt="hp">
          </header>
          <!-- Products -->
          <ul class="products">
            <!-- Product-card -->
            <?php
            $products = getProducts();
            if ($products) {
              foreach ($products as $product) {
                echo '
                <li class="product-card">
                <form method="POST" action="">
                  <img src="' . $product["photo_path"] . '" class="product-card__img">
                  <div class="product-card__items">
                <h2 class="product-card__title">' . $product["name"] . '</h2>
                <p class="product-card__price">' . $product["price"] . ' Kč</p>
                <p>' . $product["discription"] . '</p>
                </div>
                <div class="product-card__to-basket">
                <input type="submit" class="product-card__button" value="+add to busket">
                </div>
                </form>
                </li>
                ';
              }
            } else {
              echo "Not Product";
            }

            ?>
          </ul>
          <!-- Paginations -->
          <div class="paginations">
            <div class="paginations__items">
              <a class="pagination__item" href="#!">
                << /a>
                  <a class="pagination__item" href="#!">1</a>
                  <a class="pagination__item" href="#!">2</a>
                  <a class="pagination__item" href="#!">...</a>
                  <a class="pagination__item" href="#!">10</a>
                  <a class="pagination__item" href="#!">></a>
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