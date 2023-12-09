<?php
// if (!isset($_SESSION['id'])) {
//   Not_Found();
// }
include BASE_DIR . 'templates/templates.php';
echo generateHeader('Profile');
$crsf_token = generateCSRFToken();
?>

<body>
  <?php
  echo generateNavigation();
  ?>
  <div id="notification_items" class="notification_items">
  </div>
  <!-- Profil and basket -->
  <div>
    <div class="container">

      <div class="profil-basket">
        <div class="profil">
          <div class="profil_data">
            <h1 class="profil__title">Profil</h1>
            <p class="error_main"><?php
                                  if (isset($_SESSION['main_error'])) {
                                    foreach ($_SESSION['main_error'] as $key => $value) {
                                      if ($key != 'error_change_password')
                                        echo htmlspecialchars($value);
                                    }
                                  }
                                  ?></p>
            <p class="success_main"><?php
                                    if (isset($_SESSION['main_success'])) {
                                      foreach ($_SESSION['main_success'] as $key => $value) {
                                        if ($key != 'success_change_password')
                                          echo htmlspecialchars($value);
                                      }
                                    }
                                    ?></p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="user__form__data" class="profil__form">
              <input type="hidden" name="csrf_token" value="<?= $crsf_token ?>">
              <div class="profil__items">
                <div class="profile__item user_form_item">
                  <label for="name">Name</label>
                  <input readonly class="read_only" autocomplete="off" type="text" name="name" id="name" value="<?php
                                                                                                                echo isset($_SESSION['name']) ?
                                                                                                                  htmlspecialchars($_SESSION['name']) : '';
                                                                                                                ?>">
                  <span class="error_local"></span>
                </div>
                <div class="profile__item user_form_item">
                  <label for="surname">Surname</label>
                  <input readonly class="read_only" autocomplete="off" type="text" name="surname" id="surname" value="<?php
                                                                                                                      echo isset($_SESSION['surname']) ?
                                                                                                                        htmlspecialchars($_SESSION['surname']) : '';
                                                                                                                      ?>">
                  <span class="error_local"></span>
                </div>
                <div class="profile__item user_form_item">
                  <label for="username">Username</label>
                  <input readonly class="read_only" autocomplete="off" type="text" name="username" id="username" value="<?php
                                                                                                                        echo isset($_SESSION['username']) ?
                                                                                                                          htmlspecialchars($_SESSION['username']) : '';
                                                                                                                        ?>">
                  <span class="error_local"></span>
                </div>
                <div class="profile__item user_form_item">
                  <label for="email">Email</label>
                  <input readonly class="read_only" autocomplete="off" type="text" name="email" id="email" value="<?php
                                                                                                                  echo isset($_SESSION['email']) ?
                                                                                                                    htmlspecialchars($_SESSION['email']) : '';
                                                                                                                  ?>">
                  <span class="error_local"></span>
                </div>
                <div class="profile__item user_form_item">
                  <label for="address">Adress</label>
                  <input readonly class="read_only" autocomplete="off" type="text" name="address" id="address" value="<?php
                                                                                                                      echo isset($_SESSION['address']) ?
                                                                                                                        htmlspecialchars($_SESSION['address']) : '';
                                                                                                                      ?>">
                  <span class="error_local"></span>
                </div>
                <div class="profile__item user_form_item">
                  <label for="city">City</label>
                  <input readonly class="read_only" autocomplete="off" type="text" name="city" id="city" value="<?php
                                                                                                                echo isset($_SESSION['city']) ?
                                                                                                                  htmlspecialchars($_SESSION['city']) : '';
                                                                                                                ?>">
                  <span class="error_local"></span>
                </div>
                <div class="profile__item user_form_item">
                  <label for="postcode">PostCode</label>
                  <input readonly class="read_only" autocomplete="off" type="text" name="postcode" id="postcode" value="<?php
                                                                                                                        echo isset($_SESSION['postcode']) ?
                                                                                                                          htmlspecialchars($_SESSION['postcode']) : '';
                                                                                                                        ?>">
                  <span class="error_local"></span>
                </div>
                <div class="profile__item user_form_item">
                  <label for="country">Country</label>
                  <input readonly class="read_only" autocomplete="off" type="text" name="country" id="country" value="<?php
                                                                                                                      echo isset($_SESSION['country']) ?
                                                                                                                        htmlspecialchars($_SESSION['country']) : '';
                                                                                                                      ?>">
                  <span class="error_local"></span>
                </div>
              </div>
              <button type="submit" class="profil_submit" onclick="return ChangeUserData();" name="update_user_data">Change</button>
            </form>
          </div>


          <div class="profil_data">
            <h1 class="profil__title2">Change password</h1>
            <p class="error_main"><?php
                                  if (isset($_SESSION['main_error'])) {
                                    foreach ($_SESSION['main_error'] as $key => $value) {
                                      if ($key == 'error_change_password') {
                                        echo htmlspecialchars($value);
                                      }
                                    }
                                  }
                                  ?></p>
            <p class="success_main"><?php
                                    if (isset($_SESSION['main_success'])) {
                                      foreach ($_SESSION['main_success'] as $key => $value) {
                                        if ($key == 'success_change_password')
                                          echo htmlspecialchars($value);
                                      }
                                    }
                                    ?></p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="user__form__password" class="profil__form">
              <input type="hidden" name="csrf_token" value="<?= $crsf_token ?>">
              <div class="profil__items profil__items_hidden">
                <div class="profile__item user_form_item">
                  <label for="password">New password</label>
                  <input type="password" name="password" id="password">
                  <span class="error_local"></span>
                </div>
                <div class="profile__item user_form_item">
                  <label for="password2">New password again</label>
                  <input type="password" name="password2" id="password2">
                  <span class="error_local"></span>
                </div>
              </div>
              <button class="profil_submit" onclick="return ChangeUserPassword();" name="update_user_password">Change</button>
            </form>
          </div>
        </div>

        <div class="basket">
          <h1 class="basket__title">Basket</h1>
          <div id="basket__items" class="basket__items">

            <?php
            include_once BASE_DIR . 'php_logic/get_data.php';
            $totalPrice = 0;
            $busket_items = getBasketItems();
            if (isset($busket_items) && is_array($busket_items) && !empty($busket_items)) {
              foreach ($busket_items as $busket_item) {
            ?>

                <form id="basket-card_form<?= $busket_item['id']; ?>" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="basket__item">
                  <input type="hidden" name="productId" value="<?= $busket_item['id']; ?>">
                  <input type="hidden" name="orderId" value="<?= $busket_item['order_id']; ?>">
                  <div class="busket__item-first">
                    <h2 class="product-name"><?= $busket_item['name']; ?></h2>
                    <p><?= $busket_item['discription']; ?></p>
                  </div>


                  <div class="busket__item-second">
                    <input class="quantity" readonly value="<?= $busket_item['quantity']; ?>" type="number" />
                    <p class="ProductPrice"><?= $busket_item['price']; ?> Kč</p>
                    <button type="button" onclick="DeleteFromBasket('basket-card_form<?= $busket_item['id']; ?>');" id='delete_from_basket<?= $busket_item['id']; ?>'>
                      <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 6.25H5H21" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M19 6.24998V20.8333C19 21.3858 18.7893 21.9158 18.4142 22.3065C18.0391 22.6972 17.5304 22.9166 17 22.9166H7C6.46957 22.9166 5.96086 22.6972 5.58579 22.3065C5.21071 21.9158 5 21.3858 5 20.8333V6.24998M8 6.24998V4.16665C8 3.61411 8.21071 3.08421 8.58579 2.69351C8.96086 2.30281 9.46957 2.08331 10 2.08331H14C14.5304 2.08331 15.0391 2.30281 15.4142 2.69351C15.7893 3.08421 16 3.61411 16 4.16665V6.24998" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M10 11.4583V17.7083" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M14 11.4583V17.7083" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </button>
                  </div>

                </form>

            <?php
                $totalPrice += $busket_item['price'] * $busket_item['quantity'];
              }
            } else {
              echo "<p class='basket_not_available'>No Products Available</p>";
            }
            0
            ?>


            <?php

            if (isset($busket_items) && is_array($busket_items) && !empty($busket_items)) {
            ?>
          </div>
          <div id="total" class="basket__total">
            <p>Total</p>
            <p id="TotalPrice"><?= $totalPrice ?> Kč</p>
          </div>
          <button id="order_btn" class="basket__order">Order and pay</button>
        <?php
            } else {
            }
        ?>
        </div>
      </div>
    </div>
  </div>
  </div>
  <?php
  require_once BASE_DIR . 'php_logic/func.php';
  removeErrorSession(); ?>
</body>

</html>