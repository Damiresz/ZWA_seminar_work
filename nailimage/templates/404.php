<?php
/**
 * Soubor pro zobrazení stránky s chybou 404 (Nenalezeno).
 *
 * Tento soubor zahrnuje načtení potřebných šablon, včetně hlavičky s názvem "404 Not Found",
 * a zobrazení chybové stránky s informací o chybě 404 a odkazem na navigační menu.
 */
include BASE_DIR . 'templates/templates.php';
// Vložení potřebných souborů pro šablonu a vygenerování hlavičky stránky s názvem "404 Not Found".
echo generateHeader('404 Not Found');
?>

<body>
  <?php
  echo generateNavigation();
  ?>
  <h1 class="not_found">404</h1>
  <p class="not_found_text">NOT FOUND</p>
</body>
</html>