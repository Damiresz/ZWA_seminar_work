<?php if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  Not_Found();
}


include BASE_DIR . 'templates/templates.php';
$crsf_token = generateCSRFToken();
echo generateHeader('Category Settings');
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
          <th>Category</th>
          <th>Change</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include_once BASE_DIR . 'php_logic/get_data.php';
        $categories = getCategories();

        if ($categories) {
          foreach ($categories as $category) {
        ?>
            <tr>
              <td><?= $category["name_category"] ?></td>
              <td class='add_button'>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="hidden" name="category_id" value="<?= $category['id_category'] ?>">
                  <button type="submit" class="admin_submit_small">Change</button>
                </form>
              </td>
              <td class='add_button'>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="hidden" name="csrf_token" value="<?= $crsf_token ?>">
                  <input type="hidden" name="category_id" value="<?= $category['id_category'] ?>">
                  <button type="submit" name="delete_category" class="admin_submit_small" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                </form>
              </td>
            </tr>
        <?php
          }
        } else {
          echo "<p>No Categories Available</p>";
        }
        ?>
        <td class='add_button'><a href="<?= ADD_CATEGORY ?>" class="admin_submit_small">Add category</a></td>
      </tbody>

    </table>

  </div>
  </div>
  <?php
    require_once BASE_DIR . 'php_logic/func.php';
    removeErrorSession(); ?>


</body>