<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/main.css" />
    <script src="js/validator.js"></script>
    <title>Profil</title>
  </head>

  <body>
  <?php
            include 'nav.php';
?>
    <!-- Profil and basket -->
    <div>
      <div class="container">
        <div class="profil-basket">
          <div class="profil">
            <h1 class="profil__title">Profil</h1>
            <form
              action="http://zwa.toad.cz/~xklima/vypisform.php"
              method="POST"
              id="user__form"
              class="profil__form"
            >
              <div class="profil__items">
                <div class="profile__item user_form_item">
                  <label for="name">Name</label>
                  <input type="text" name="name" id="name" />
                  <spam class="error_local"></spam>
                </div>
                <div class="profile__item user_form_item">
                  <label for="surname">Surname</label>
                  <input type="text" name="surname" id="surname" />
                  <spam class="error_local"></spam>
                </div>
                <div class="profile__item user_form_item">
                  <label for="username">Username</label>
                  <input type="text" name="username" id="username" />
                  <spam class="error_local"></spam>
                </div>
                <div class="profile__item user_form_item">
                  <label for="email">Email</label>
                  <input type="text" name="email" id="email" />
                  <spam class="error_local"></spam>
                </div>
                <div class="profile__item user_form_item">
                  <label for="address">Adress</label>
                  <input type="text" name="address" id="address" />
                  <spam class="error_local"></spam>
                </div>
                <div class="profile__item user_form_item">
                  <label for="city">City</label>
                  <input type="text" name="city" id="city" />
                  <spam class="error_local"></spam>
                </div>
                <div class="profile__item user_form_item">
                  <label for="postcode">PostCode</label>
                  <input type="text" name="postcode" id="postcode" />
                  <spam class="error_local"></spam>
                </div>
                <div class="profile__item user_form_item">
                  <label for="country">Country</label>
                  <input type="text" name="country" id="country" />
                  <spam class="error_local"></spam>
                </div>
                <div class="profile__item user_form_item">
                  <label for="password">Password</label>
                  <input type="password" name="password" id="password" />
                  <spam class="error_local"></spam>
                </div>
                <div class="profile__item user_form_item">
                  <label for="password2">Password again</label>
                  <input type="password" name="password2" id="password2" />
                  <spam class="error_local"></spam>
                </div>
              </div>
              <button class="profil_submit" type="submit">Save</button>
            </form>
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
                  <svg
                    width="24"
                    height="25"
                    viewBox="0 0 24 25"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M3 6.25H5H21"
                      stroke="#1D084B"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      d="M19 6.24998V20.8333C19 21.3858 18.7893 21.9158 18.4142 22.3065C18.0391 22.6972 17.5304 22.9166 17 22.9166H7C6.46957 22.9166 5.96086 22.6972 5.58579 22.3065C5.21071 21.9158 5 21.3858 5 20.8333V6.24998M8 6.24998V4.16665C8 3.61411 8.21071 3.08421 8.58579 2.69351C8.96086 2.30281 9.46957 2.08331 10 2.08331H14C14.5304 2.08331 15.0391 2.30281 15.4142 2.69351C15.7893 3.08421 16 3.61411 16 4.16665V6.24998"
                      stroke="#1D084B"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      d="M10 11.4583V17.7083"
                      stroke="#1D084B"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      d="M14 11.4583V17.7083"
                      stroke="#1D084B"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
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
                  <svg
                    width="24"
                    height="25"
                    viewBox="0 0 24 25"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M3 6.25H5H21"
                      stroke="#1D084B"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      d="M19 6.24998V20.8333C19 21.3858 18.7893 21.9158 18.4142 22.3065C18.0391 22.6972 17.5304 22.9166 17 22.9166H7C6.46957 22.9166 5.96086 22.6972 5.58579 22.3065C5.21071 21.9158 5 21.3858 5 20.8333V6.24998M8 6.24998V4.16665C8 3.61411 8.21071 3.08421 8.58579 2.69351C8.96086 2.30281 9.46957 2.08331 10 2.08331H14C14.5304 2.08331 15.0391 2.30281 15.4142 2.69351C15.7893 3.08421 16 3.61411 16 4.16665V6.24998"
                      stroke="#1D084B"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      d="M10 11.4583V17.7083"
                      stroke="#1D084B"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                    <path
                      d="M14 11.4583V17.7083"
                      stroke="#1D084B"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
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
  </body>
</html>