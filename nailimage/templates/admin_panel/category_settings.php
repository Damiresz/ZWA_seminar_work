<?php

/**
 * Soubor obsahující stránku administrace se seznamem kategorií a funkcionalitou pro jejich úpravu a odstranění.
 *
 * Tento soubor zahrnuje inicializaci relace, načítání potřebných souborů a zpracování
 * příchozích GET a POST požadavků podle definovaných tras. Zobrazuje administrativní rozhraní,
 * kde administrátoři mohou prohlížet, upravovat a odstraňovat kategorie produktů.
 */
// Kontrola administratora. Pokud uživatel není administratorem, přesměruje na stránku s chybou 404.
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  Not_Found();
}

// Vložení potřebných souborů pro šablonu a vygenerování hlavičky stránky s názvem "Category Settings".
include BASE_DIR . 'templates/templates.php';
echo generateHeader('Category Settings');
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
                <a href="<?= PROCESSING_CATEGORY_URL . "category/" . urlencode($category['name_category']) ?>" class="admin_submit_small">Change</a>
              </td>
              <td class='add_button'>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="hidden" name="csrf_token" value="<?= $crsf_token ?>">
                  <input type="hidden" name="category_id" value="<?= $category['id_category'] ?>">
                  <button type="submit" name="delete_category" class="admin_submit_small">Delete</button>
                </form>
              </td>
            </tr>
        <?php
          }
        } else {
          echo "<p>No Categories Available</p>";
        }
        ?>
        <tr>
          <td class='add_button' colspan="3">
            <a href="<?= PROCESSING_CATEGORY_URL ?>" class="admin_submit_small">Add category</a>
          </td>
        </tr>
      </tbody>

    </table>

  </div>

  <?php
   // Vložení souboru s funkcemi a odstranění session chyb
  require_once BASE_DIR . 'php_logic/func.php';
  removeErrorSession(); ?>
</body>
</html>