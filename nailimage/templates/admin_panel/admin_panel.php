<?php 
/**
 * Soubor obsahující stránku administrace s funkcionalitou pro správu kategorií, produktů a uživatelů.
 *
 * Tento soubor zahrnuje inicializaci relace, načítání potřebných souborů a zpracování
 * příchozích GET a POST požadavků podle definovaných tras. Zobrazuje administrativní rozhraní,
 * kde administrátoři mohou spravovat kategorie, produkty a uživatelské účty.
 *
 */
// Kontrola administratora. Pokud uživatel není administratorem, přesměruje na stránku s chybou 404.
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
  Not_Found();
}
// Vložení potřebných souborů pro šablonu a vygenerování hlavičky stránky s názvem "Admin Panel".
include BASE_DIR.'templates/templates.php';
echo generateHeader('Admin Panel');
?>

<body>
  <?php
  // Vygenerování navigačního menu.
  echo generateNavigation();
  ?>
    <div>
      <div class="container">
        <div class="profil-basket">
          <div class="profil">
            <h1 class="profil__title admin_title">Admin Panel</h1>
            <div class="user_buttons">
            <a href="<?= PRODUCT_SETTINGS_URL ?>" class="admin_submit">Products Settings</a>
            <a href="<?= CATEGORY_SETTINGS_URL ?>" class="admin_submit">Category Settings</a>
            <a href="<?= USERS_SETTINGS_URL ?>" class="admin_submit">User Settings</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
