<?php if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  Not_Found();
}


include BASE_DIR . 'templates/templates.php';
$crsf_token = generateCSRFToken();
echo generateHeader('Products Settings');
?>

<body>
  <?php
  echo generateNavigation();
  ?>
   <h4 class="success_main"><?php
                            if (isset($_SESSION['main_success'])) {
                              foreach ($_SESSION['main_success'] as $key => $value) {
                                  echo htmlspecialchars($value);
                              }
                            }
                            ?></h4>
  <h4 class="error_main"><?php
                          if (isset($_SESSION['main_error'])) {
                            foreach ($_SESSION['main_error'] as $key => $value) {

                              echo htmlspecialchars($value);
                            }
                          }
                          ?></h4>
  <div class="table_content">
    <table>
      <thead>
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Date creation</th>
          <th><select id="productCategory" name="productCategory">
              <?php
              include_once BASE_DIR . 'php_logic/get_data.php';
              $perPage = PER_PAGE_ADMIN;
              $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
              $currentCategoryPage = isset($_GET['category_page']) ? $_GET['category_page'] : null;
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

        $products = getProducts($currentPage, $perPage, $currentCategoryPage);

        if ($products) {
          foreach ($products as $product) {
        ?>
            <tr>
              <td><?= $product["name"] ?></td>
              <td><?= $product["price"] ?> Kč</td>
              <td><?= $product["date_creation"] ?></td>
              <td><?= $product["name_category"] ?></td>
              <td class='add_button'>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                  <button type="submit" class="admin_submit_small">Change</button>
                </form>
              </td>
              <td class='add_button'>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="hidden" name="csrf_token" value="<?= $crsf_token ?>">
                  <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                  <button type="submit" name="delete_product" class="admin_submit_small" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                </form>
              </td>
            </tr>
        <?php
          }
        } else {
          echo "<p>No Products Available</p>";
        }
        ?>
        <td class='add_button'><a href="<?= ADD_PRODUCT ?>" class="admin_submit_small">Add products</a></td>
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
    require_once BASE_DIR . 'php_logic/func.php';
    removeErrorSession(); ?>
</body>