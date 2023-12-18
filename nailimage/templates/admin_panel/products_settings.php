<?php

/**
 * Soubor obsahující stránku administrace se seznamem produktů a funkcionalitou pro jejich úpravu a odstranění.
 *
 * Tento soubor zahrnuje inicializaci relace, načítání potřebných souborů a zpracování
 * příchozích GET a POST požadavků podle definovaných tras. Zobrazuje administrativní rozhraní,
 * kde administrátoři mohou prohlížet, upravovat a odstraňovat produkty z katalogu.
 */
// Kontrola administratora. Pokud uživatel není administratorem, přesměruje na stránku s chybou 404.
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  Not_Found();
}

// Vložení potřebných souborů pro šablonu a vygenerování hlavičky stránky s názvem "Products Settings".
include BASE_DIR . 'templates/templates.php';
echo generateHeader('Products Settings');
// Vygenerování crsf tokenu.
$crsf_token = generateCSRFToken();
?>

<body>
  <?php
  // Vygenerování navigačního menu.
  echo generateNavigation();
  ?>
  <p class="success_main"><?php
                          if (isset($_SESSION['main_success'])) {
                            foreach ($_SESSION['main_success'] as $key => $value) {
                              echo htmlspecialchars($value);
                            }
                          }
                          ?></p>
  <p class="error_main"><?php
                        if (isset($_SESSION['main_error'])) {
                          foreach ($_SESSION['main_error'] as $key => $value) {

                            echo htmlspecialchars($value);
                          }
                        }
                        ?></p>
  <div class="table_content">
    <table>
      <thead>
        <tr>
          <th>Product</th>
          <th class="device_none">Price</th>
          <th class="device_none">Date update</th>
          <th class="device_none"><select id="productCategory" name="productCategory">
              <?php
              // Pokud jsou kategorie k dispozici, zobrazení seznamu.
              include_once BASE_DIR . 'php_logic/get_data.php';
              $perPage = PER_PAGE_ADMIN;
              $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
              $currentCategoryPage = isset($_GET['get_category']) ? $_GET['get_category'] : null;
              $categories = getCategories();
              if ($categories) {
              ?>
                <option value="">All</option>
                <?php
                foreach ($categories as $category) {
                  $selected = ($category['name_category'] === $currentCategoryPage) ? "selected" : '';
                ?>
                  <option value="<?= $category['id_category'] ?>" <?= $selected ?>><?= $category['name_category'] ?></option>
                <?php
                }
              } else {
                ?>
                <option value="-1">Not Categories</option>
              <?php
              }
              ?>
            </select></th>
          <th>Change</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Pokud jsou producty k dispozici, zobrazení seznamu.
        $products = getProducts($currentPage, $perPage, $currentCategoryPage);

        if ($products) {
          foreach ($products as $product) {
        ?>
            <tr>
              <td><?= $product["name"] ?></td>
              <td class="device_none"><?= $product["price"] ?> Kč</td>
              <td class="device_none"><?= format_datetime($product["date_update"]) ?></td>
              <td class="device_none"><?= $product["name_category"] ?></td>
              <td class='add_button'>
                <a href="<?= PROCESSING_PRODUCT_URL . '?product=' . urlencode($product['id']) ?>" class="admin_submit_small">Change</a>
              </td>
              <td class='add_button'>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="hidden" name="csrf_token" value="<?= $crsf_token ?>">
                  <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                  <button type="submit" name="delete_product" class="admin_submit_small">Delete</button>
                </form>
              </td>
            </tr>
        <?php
          }
        } else {
          echo "<p>No Products Available</p>";
        }
        ?>
        <tr>
          <td class='add_button' colspan="6">
            <a href="<?= PROCESSING_PRODUCT_URL ?>" class="admin_submit_small">Add products</a>
          </td>
        </tr>
      </tbody>

    </table>
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
  <?php
  // Vložení souboru s funkcemi a odstranění session chyb
  require_once BASE_DIR . 'php_logic/func.php';
  removeErrorSession(); ?>
</body>
</html>