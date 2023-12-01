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
        <aside class="asside">
          <h1 class="asside__title">Nail | Eshop</h1>
          <ul class="asside__items">
            <?php
            include_once BASE_DIR . 'php_logic/get_data.php';
            $categories = getCategories();
            if ($categories) {
              foreach ($categories as $category) {
            ?>
                <li class="asside__item">
                  <a href='#!' class='asside__link'><?= $category['name'] ?></a>
                </li>
              <?php
              }
            } else {
              ?>
              <li class="asside__item">Not Categories</li>
            <?php
            }
            ?>
          </ul>
        </aside>


        <!-- Main_content -->
        <div class="main-content">
          <!-- Header -->
          <header class="header">
            <img src="<?php echo BASE_DIR . 'image/header/header-photo.webp' ?>" alt="hp">
            <div class="header_print">
              <h1 class="header_print_title">Katalog</h1>
              <p class="header_print_description">A palette of more than 1000 colors</p>
            </div>
          </header>
          <!-- Products -->
          <ul class="products">
            <!-- Product-card -->
            <?php
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $products = getProducts($currentPage,$perPage);

            if ($products) {
              foreach ($products as $product) {
            ?>
                <li class="product-card">
                  <form method="POST" action="#">
                    <img src="<?= $product["photo_path"] ?>" class="product-card__img" alt="<?= $product["name"] ?>">
                    <div class="product-card__items">
                      <h2 class="product-card__title"><?= $product["name"] ?></h2>
                      <p class="product-card__price"><?= $product["price"] ?> Kč</p>
                      <p class="product-card__description"><?= $product["discription"] ?></p>
                    </div>
                    <div class="product-card__to-basket">
                      <input type="submit" class="product-card__button" value="Add to Basket">
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
                  // Получаем общее число страниц
                  $totalPages = getTotalPages($perPage);

                  // Добавление ссылок на страницы (пагинация)
                  for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<a class="pagination__item" href="' . PRODUCTS_URL . '/page/' . $i . '">' . $i . '</a>';
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