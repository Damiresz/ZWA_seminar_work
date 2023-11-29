<?php if (!isset($_SESSION['id'])) {
  header('Location: index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?php echo $BASE_DIR .'css/main.css'?>">
  <script src="<?php echo $BASE_DIR .'js/validator.js'?>"></script>
  <script src="<?php echo $BASE_DIR .'js/profil_basket.js'?>"></script>
  <title>Profil</title>
</head>

<body>
  <?php
           include $BASE_DIR .'nav.php';
  ?>
  <!-- Profil and basket -->
  <div>
    <div class="container">
      <div class="profil-basket">
        <div class="profil">
          <div class="profil_data">
          <h1 class="profil__title">Profil</h1>
          <h4 class="error_main"><?php
                                      if (isset($_SESSION['main_error'])) {
                                        foreach ($_SESSION['main_error'] as $key => $value){
                                          if ($key != 'error_change_password')
                                            echo htmlspecialchars($value);
                                        }
                                      }
                                      ?></h4>
          <h4 class="success_main"><?php
                                      if (isset($_SESSION['main_success'])) {
                                        foreach ($_SESSION['main_success'] as $key => $value){
                                          if ($key != 'success_change_password')
                                            echo htmlspecialchars($value);
                                        }
                                      }
                                      ?></h4>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="user__form__data" class="profil__form">
            <div class="profil__items">
              <div class="profile__item user_form_item">
                <label for="name">Name</label>
                <input readonly class="read_only" autocomplete="off" type="text" name="name" id="name" value="<?php
                                                                      echo isset($_SESSION['name']) ? 
                                                                      htmlspecialchars($_SESSION['name']) : ''; 
                                                                      ?>">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item user_form_item">
                <label for="surname">Surname</label>
                <input readonly class="read_only" autocomplete="off" type="text" name="surname" id="surname" value="<?php
                                                                      echo isset($_SESSION['surname']) ? 
                                                                      htmlspecialchars($_SESSION['surname']) : ''; 
                                                                      ?>" autocomplete="off">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item user_form_item">
                <label for="username">Username</label>
                <input readonly class="read_only" autocomplete="off" type="text" name="username" id="username" value="<?php
                                                                      echo isset($_SESSION['username']) ? 
                                                                      htmlspecialchars($_SESSION['username']) : ''; 
                                                                      ?>">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item user_form_item">
                <label for="email">Email</label>
                <input readonly class="read_only" autocomplete="off" type="text" name="email" id="email" value="<?php
                                                                      echo isset($_SESSION['email']) ? 
                                                                      htmlspecialchars($_SESSION['email']) : ''; 
                                                                      ?>">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item user_form_item">
                <label for="address">Adress</label>
                <input readonly class="read_only" autocomplete="off" type="text" name="address" id="address" value="<?php
                                                                      echo isset($_SESSION['address']) ? 
                                                                      htmlspecialchars($_SESSION['address']) : ''; 
                                                                      ?>">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item user_form_item">
                <label for="city">City</label>
                <input readonly class="read_only" autocomplete="off" type="text" name="city" id="city" value="<?php
                                                                      echo isset($_SESSION['city']) ? 
                                                                      htmlspecialchars($_SESSION['city']) : ''; 
                                                                      ?>">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item user_form_item">
                <label for="postcode">PostCode</label>
                <input readonly class="read_only" autocomplete="off" type="text" name="postcode" id="postcode" value="<?php
                                                                      echo isset($_SESSION['postcode']) ? 
                                                                      htmlspecialchars($_SESSION['postcode']) : ''; 
                                                                      ?>">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item user_form_item">
                <label for="country">Country</label>
                <input readonly class="read_only" autocomplete="off" type="text" name="country" id="country" value="<?php
                                                                      echo isset($_SESSION['country']) ? 
                                                                      htmlspecialchars($_SESSION['country']) : ''; 
                                                                      ?>">
                <spam class="error_local"></spam>
              </div>
            </div>
            <button type="submit" class="profil_submit" onclick="return ChangeUserData();" name="update_user_data">Change</button>
          </form>
          </div>

          
          <div class="profil_data">
          <h1 class="profil__title2">Change password</h1>
          <h4 class="error_main"><?php
                                    if (isset($_SESSION['main_error'])) {
                                      foreach ($_SESSION['main_error'] as $key => $value) {
                                        if ($key == 'error_change_password') {
                                          echo htmlspecialchars($value);
                                        }
                                      }
                                    }
                                      ?></h4>
          <h4 class="success_main"><?php
                                      if (isset($_SESSION['main_success'])) {
                                        foreach ($_SESSION['main_success'] as $key => $value){
                                          if ($key == 'success_change_password')
                                             echo htmlspecialchars($value);
                                        }
                                      }
                                      ?></h4>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="user__form__password" class="profil__form">
            <div class="profil__items profil__items_hidden">
              <div class="profile__item user_form_item">
                <label for="password">New password</label>
                <input type="password" name="password" id="password">
                <spam class="error_local"></spam>
              </div>
              <div class="profile__item user_form_item">
                <label for="password2">New password again</label>
                <input type="password" name="password2" id="password2">
                <spam class="error_local"></spam>
              </div>
            </div>
            <button class="profil_submit" onclick="return ChangeUserPassword();" name="update_user_password">Change</button>
          </form>
          </div>
        </div>

        <div class="basket">
          <h1 class="basket__title">Basket</h1>
          <div class="basket__items">
            <div class="basket__item">
              <div class="busket__item-first">
                <h2 class="product-name">Gel-Lak №11</h2>
                <p>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  Autem impedit dolorem
                </p>
              </div>
              <div class="busket__item-second">
                <input value="1" min="1" type="number" />
                <p>239 Kč</p>
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M3 6.25H5H21" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M19 6.24998V20.8333C19 21.3858 18.7893 21.9158 18.4142 22.3065C18.0391 22.6972 17.5304 22.9166 17 22.9166H7C6.46957 22.9166 5.96086 22.6972 5.58579 22.3065C5.21071 21.9158 5 21.3858 5 20.8333V6.24998M8 6.24998V4.16665C8 3.61411 8.21071 3.08421 8.58579 2.69351C8.96086 2.30281 9.46957 2.08331 10 2.08331H14C14.5304 2.08331 15.0391 2.30281 15.4142 2.69351C15.7893 3.08421 16 3.61411 16 4.16665V6.24998" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M10 11.4583V17.7083" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M14 11.4583V17.7083" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </div>
            </div>

            <div class="basket__item">
              <div class="busket__item-first">
                <h2 class="product-name">Gel-Lak №11</h2>
                <p>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  Autem impedit dolorem
                </p>
              </div>
              <div class="busket__item-second">
                <input value="1" min="1" type="number" />
                <p>239 Kč</p>
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M3 6.25H5H21" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M19 6.24998V20.8333C19 21.3858 18.7893 21.9158 18.4142 22.3065C18.0391 22.6972 17.5304 22.9166 17 22.9166H7C6.46957 22.9166 5.96086 22.6972 5.58579 22.3065C5.21071 21.9158 5 21.3858 5 20.8333V6.24998M8 6.24998V4.16665C8 3.61411 8.21071 3.08421 8.58579 2.69351C8.96086 2.30281 9.46957 2.08331 10 2.08331H14C14.5304 2.08331 15.0391 2.30281 15.4142 2.69351C15.7893 3.08421 16 3.61411 16 4.16665V6.24998" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M10 11.4583V17.7083" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M14 11.4583V17.7083" stroke="#1D084B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </div>
            </div>
          </div>
          <div class="basket__total">
            <p>Total</p>
            <p>239 Kč</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php removeErrorSession(); ?>
</body>

</html>