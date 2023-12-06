<?php
include BASE_DIR . 'templates/templates.php';
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