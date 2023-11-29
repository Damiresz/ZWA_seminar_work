<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= $BASE_DIR .'css/main.css'?>">
  <title>NailImage | Eshop</title>
</head>

<body>
<?php
            include $BASE_DIR .'nav.php';
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
            include $BASE_DIR.'php_logic/connect_db.php';
            $sql_categoties = "SELECT * FROM Category";
            if($categories = $connect->query($sql_categoties)){
              foreach($categories as $category){
                echo "<li><a href='#!' class='aside__link'>" . $category['name'] . "</a></li>";
                }
                } else {
                echo "Chyba: " . $connect->error;
                }
                $connect->close();
                ?>
          </ul>
          </div>
        </aside>
          <!-- Main_content -->
        <div class="main-content">
          <!-- Header -->
          <header class="header">
            <img src="<?php echo $BASE_DIR.'image/header/header-photo.webp'?>" alt="hp">
          </header>
          <!-- Products -->
          <ul class="products">
            <!-- Product-card -->
            <?php
            include $BASE_DIR.'php_logic/connect_db.php';
            $sql_products = "SELECT * FROM Products";
            if($products = $connect->query($sql_products)){
              foreach($products as $product){
                echo '
                <li class="product-card">
                <form method="POST" action="">
                  <img src="'.$product["photo_path"].'" class="product-card__img">
                  <div class="product-card__items">
                <h2 class="product-card__title">'.$product["name"].'</h2>
                <p class="product-card__price">'.$product["price"].' Kč</p>
                <p>'.$product["discription"].'</p>
                </div>
                <div class="product-card__to-basket">
                <input type="submit" class="product-card__button" value="+add to busket">
                </div>
                </form>
                </li>
                ';
                }
                } else {
                echo "Error: " . $connect->error;
                }
                $connect->close();
                ?>
              </ul>
          <!-- Paginations -->
          <div class="paginations">
              <div class="paginations__items">
                <a class="pagination__item" href="#!"><</a>
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