<?php if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  Not_Found();
}


include BASE_DIR . 'templates/templates.php';
echo generateHeader('Products Settings');
?>

<body>
  <?php
  echo generateNavigation();
  ?>
  <div class="table_content">
    <table>
      <thead>
        <tr>
          <th>Название</th>
          <th>Цена</th>
          <th><select id="productCategory" name="productCategory">
              <?php
              include_once BASE_DIR . 'php_logic/get_data.php';
              $perPage = PER_PAGE_ADMIN;
              $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
              $currentCategoryPage = isset($_GET['category_page']) ? $_GET['category_page'] : null;
              $categories = getCategories();
              if ($categories) {
              ?>
                <option value="0">All</option>
                <?php
                foreach ($categories as $category) {
                  $selected = ($category['category_name'] === $currentCategoryPage) ? "selected" : '';
                ?>
                  <option value="<?= $category['id']?>" <?= $selected?> ><?= $category['category_name'] ?></option>
                <?php
                }
              } else {
                ?>
                <option value="-1">Not Categories</option>
              <?php
              }
              ?>
            </select></th>
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
              <td><?= $product["category_name"] ?></td>
              <td>Change</td>
              <td>Delete</td>
            </tr>
        <?php
          }
        } else {
          echo "<p>No Products Available</p>";
        }
        ?>

      </tbody>
      <a href="<?= ADD_PRODUCT ?>" class="admin_submit">Add products</a>
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

  <script>

  </script>

</body>