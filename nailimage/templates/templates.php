  <?php
  // Header
  function generateHeader($title_page)
  {
    ob_start(); // Включаем буферизацию вывода
  ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <base href="<?= BASE_DIR_URL ?>">
      <link rel="icon" href="<?= BASE_DIR ?>image/icons/favicon.png" type="image/x-icon">
      <link rel="stylesheet" href="<?= BASE_DIR ?>css/main.css">
      <script src="<?= BASE_DIR ?>js/validator.js"></script>
      <script defer src="<?= BASE_DIR ?>js/main.js"></script>
      <title><?= $title_page ?></title>
    </head>
  <?php
    $output = ob_get_clean(); // Получаем содержимое буфера и отключаем буферизацию вывода
    return $output;
  }
  ?>


  <?php
  function generateNavigation($nav_btn = false)
  {
    ob_start(); // Включаем буферизацию вывода
  ?>

    <!-- Navigation -->
    <div class="nav-bg">
      <div class="container">
        <nav class="nav">

          <!-- Logo -->
          <div class="nav-logo">
            <?php
            if (isset($nav_btn) && $nav_btn === true) {
            ?>
              <button id="nav-btn" class="nav-btn">
                <span></span>
                <span></span>
                <span></span>
              </button>
            <?php } ?>
            <a href="<?= BASE_DIR_URL ?>">
              <svg class="logo_desktop" width="177" height="40" viewBox="0 0 177 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.59186 5.83648C5.56744 13.6855 5.61628 14.6164 6.10465 15.5723C7.05698 17.5094 8.44884 18.3648 10.5733 18.3648C12.1849 18.3648 13.5279 17.6101 14.5291 16.1509L15.2616 15.044L15.3349 8.5283L15.4081 2.01257H10.5244H5.61628L5.59186 5.83648ZM7.69186 7.06918C7.69186 10.1132 7.64302 10.6918 7.32558 10.6918C7.03256 10.6918 6.9593 10.1132 6.88605 7.32076C6.81279 3.74843 6.88605 3.16981 7.39884 3.34591C7.61861 3.42138 7.69186 4.37736 7.69186 7.06918Z" fill="#F6D9E2" />
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.76047 10.5912C2.02675 13.1321 2.07559 12.6793 2.00233 25.9623L1.92908 37.9874H2.66164H3.41861V25.9623V13.9371L4.0535 12.6289C4.46861 11.7736 4.63954 11.044 4.59071 10.4151L4.51745 9.48428L3.76047 10.5912Z" fill="#F6D9E2" />
                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.1163 10.2641C16.1163 10.717 16.4093 11.673 16.8 12.4025L17.4593 13.7107L17.5326 25.8616L17.6058 37.9874H18.1919H18.8023V26.0377C18.8023 14.4906 18.7779 14.0629 18.2895 12.6792C17.9965 11.8742 17.386 10.8428 16.9465 10.3396L16.1407 9.43396L16.1163 10.2641Z" fill="#F6D9E2" />
                <path d="M42.416 13.2H43.52V30.288H43.4L30.08 17.16H29.984V30H28.88V12.912H29L42.32 26.04H42.416V13.2ZM58.6066 25.056H50.3266L48.2146 30H47.1106L54.2146 13.2H55.4146L63.2386 30H60.9106L58.6066 25.056ZM58.1026 23.976L54.3346 15.888H54.2386L50.7826 23.976H58.1026ZM67.8088 13.2H69.9928V30H67.8088V13.2ZM76.7159 30V13.2H78.8999V28.68H87.5639V30H76.7159ZM92.1134 13.2H94.2974V30H92.1134V13.2ZM102.653 13.2L110.357 27.624H110.453L118.229 13.2H119.885V30H117.701V16.392H117.605L110.021 30.288H109.589L102.173 16.296H102.077V30H101.021V13.2H102.653ZM134.989 25.056H126.709L124.597 30H123.493L130.597 13.2H131.797L139.621 30H137.293L134.989 25.056ZM134.485 23.976L130.717 15.888H130.621L127.165 23.976H134.485ZM158.52 22.512V30H156.456V29.016C155.848 29.336 155.08 29.632 154.152 29.904C153.224 30.16 152.16 30.288 150.96 30.288C149.36 30.288 147.984 30.04 146.832 29.544C145.68 29.032 144.728 28.36 143.976 27.528C143.24 26.68 142.688 25.728 142.32 24.672C141.968 23.6 141.792 22.496 141.792 21.36C141.792 20.032 142.024 18.848 142.488 17.808C142.952 16.752 143.6 15.864 144.432 15.144C145.264 14.424 146.248 13.872 147.384 13.488C148.536 13.104 149.792 12.912 151.152 12.912C152.336 12.912 153.36 13.048 154.224 13.32C155.104 13.576 155.84 13.896 156.432 14.28C157.024 14.664 157.488 15.08 157.824 15.528C158.176 15.96 158.424 16.352 158.568 16.704H156.84C156.744 16.368 156.528 16.04 156.192 15.72C155.872 15.384 155.456 15.088 154.944 14.832C154.432 14.576 153.848 14.368 153.192 14.208C152.536 14.048 151.832 13.968 151.08 13.968C149.944 13.968 148.944 14.152 148.08 14.52C147.232 14.888 146.512 15.408 145.92 16.08C145.328 16.752 144.88 17.552 144.576 18.48C144.288 19.408 144.144 20.424 144.144 21.528C144.144 22.648 144.296 23.68 144.6 24.624C144.92 25.552 145.392 26.36 146.016 27.048C146.64 27.72 147.424 28.248 148.368 28.632C149.312 29.016 150.416 29.208 151.68 29.208C152.64 29.208 153.496 29.096 154.248 28.872C155 28.648 155.736 28.304 156.456 27.84V23.496H153.768V22.512H158.52ZM162.849 13.2H173.697V14.52H165.033V20.544H172.473V21.648H165.033V28.68H173.697V30H162.849V13.2Z" fill="#F6D9E2" />
              </svg>
            </a>
            <a href="<?= BASE_DIR_URL ?>">
              <svg class="logo_devices" width="20" height="40" viewBox="0 0 20 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.59186 5.83648C5.56744 13.6855 5.61628 14.6164 6.10465 15.5723C7.05698 17.5094 8.44884 18.3648 10.5733 18.3648C12.1849 18.3648 13.5279 17.6101 14.5291 16.1509L15.2616 15.044L15.3349 8.5283L15.4081 2.01257H10.5244H5.61628L5.59186 5.83648ZM7.69186 7.06918C7.69186 10.1132 7.64302 10.6918 7.32558 10.6918C7.03256 10.6918 6.9593 10.1132 6.88605 7.32076C6.81279 3.74843 6.88605 3.16981 7.39884 3.34591C7.61861 3.42138 7.69186 4.37736 7.69186 7.06918Z" fill="#F6D9E2" />
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.76047 10.5912C2.02675 13.1321 2.07559 12.6793 2.00233 25.9623L1.92908 37.9874H2.66164H3.41861V25.9623V13.9371L4.0535 12.6289C4.46861 11.7736 4.63954 11.044 4.59071 10.4151L4.51745 9.48428L3.76047 10.5912Z" fill="#F6D9E2" />
                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.1163 10.2641C16.1163 10.717 16.4093 11.673 16.8 12.4025L17.4593 13.7107L17.5326 25.8616L17.6058 37.9874H18.1919H18.8023V26.0377C18.8023 14.4906 18.7779 14.0629 18.2895 12.6792C17.9965 11.8742 17.386 10.8428 16.9465 10.3396L16.1407 9.43396L16.1163 10.2641Z" fill="#F6D9E2" />
              </svg>
            </a>
          </div>
          <!-- Buttons -->
          <div class="nav-buttons">
            <?php if (isset($_SESSION['id'])) : ?>
              <?php if ($_SESSION['isAdmin'] == 1) : ?>
                <!-- Кнопка для администратора -->
                <a href="<?= ADMIN_PANEL_URL ?>" class="nav-search__link">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_53_275)">
                      <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#F6D9E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      <path d="M19.4 15C19.2669 15.3016 19.2272 15.6362 19.286 15.9606C19.3448 16.285 19.4995 16.5843 19.73 16.82L19.79 16.88C19.976 17.0657 20.1235 17.2863 20.2241 17.5291C20.3248 17.7719 20.3766 18.0322 20.3766 18.295C20.3766 18.5578 20.3248 18.8181 20.2241 19.0609C20.1235 19.3037 19.976 19.5243 19.79 19.71C19.6043 19.896 19.3837 20.0435 19.1409 20.1441C18.8981 20.2448 18.6378 20.2966 18.375 20.2966C18.1122 20.2966 17.8519 20.2448 17.6091 20.1441C17.3663 20.0435 17.1457 19.896 16.96 19.71L16.9 19.65C16.6643 19.4195 16.365 19.2648 16.0406 19.206C15.7162 19.1472 15.3816 19.1869 15.08 19.32C14.7842 19.4468 14.532 19.6572 14.3543 19.9255C14.1766 20.1938 14.0813 20.5082 14.08 20.83V21C14.08 21.5304 13.8693 22.0391 13.4942 22.4142C13.1191 22.7893 12.6104 23 12.08 23C11.5496 23 11.0409 22.7893 10.6658 22.4142C10.2907 22.0391 10.08 21.5304 10.08 21V20.91C10.0723 20.579 9.96512 20.258 9.77251 19.9887C9.5799 19.7194 9.31074 19.5143 9 19.4C8.69838 19.2669 8.36381 19.2272 8.03941 19.286C7.71502 19.3448 7.41568 19.4995 7.18 19.73L7.12 19.79C6.93425 19.976 6.71368 20.1235 6.47088 20.2241C6.22808 20.3248 5.96783 20.3766 5.705 20.3766C5.44217 20.3766 5.18192 20.3248 4.93912 20.2241C4.69632 20.1235 4.47575 19.976 4.29 19.79C4.10405 19.6043 3.95653 19.3837 3.85588 19.1409C3.75523 18.8981 3.70343 18.6378 3.70343 18.375C3.70343 18.1122 3.75523 17.8519 3.85588 17.6091C3.95653 17.3663 4.10405 17.1457 4.29 16.96L4.35 16.9C4.58054 16.6643 4.73519 16.365 4.794 16.0406C4.85282 15.7162 4.81312 15.3816 4.68 15.08C4.55324 14.7842 4.34276 14.532 4.07447 14.3543C3.80618 14.1766 3.49179 14.0813 3.17 14.08H3C2.46957 14.08 1.96086 13.8693 1.58579 13.4942C1.21071 13.1191 1 12.6104 1 12.08C1 11.5496 1.21071 11.0409 1.58579 10.6658C1.96086 10.2907 2.46957 10.08 3 10.08H3.09C3.42099 10.0723 3.742 9.96512 4.0113 9.77251C4.28059 9.5799 4.48572 9.31074 4.6 9C4.73312 8.69838 4.77282 8.36381 4.714 8.03941C4.65519 7.71502 4.50054 7.41568 4.27 7.18L4.21 7.12C4.02405 6.93425 3.87653 6.71368 3.77588 6.47088C3.67523 6.22808 3.62343 5.96783 3.62343 5.705C3.62343 5.44217 3.67523 5.18192 3.77588 4.93912C3.87653 4.69632 4.02405 4.47575 4.21 4.29C4.39575 4.10405 4.61632 3.95653 4.85912 3.85588C5.10192 3.75523 5.36217 3.70343 5.625 3.70343C5.88783 3.70343 6.14808 3.75523 6.39088 3.85588C6.63368 3.95653 6.85425 4.10405 7.04 4.29L7.1 4.35C7.33568 4.58054 7.63502 4.73519 7.95941 4.794C8.28381 4.85282 8.61838 4.81312 8.92 4.68H9C9.29577 4.55324 9.54802 4.34276 9.72569 4.07447C9.90337 3.80618 9.99872 3.49179 10 3.17V3C10 2.46957 10.2107 1.96086 10.5858 1.58579C10.9609 1.21071 11.4696 1 12 1C12.5304 1 13.0391 1.21071 13.4142 1.58579C13.7893 1.96086 14 2.46957 14 3V3.09C14.0013 3.41179 14.0966 3.72618 14.2743 3.99447C14.452 4.26276 14.7042 4.47324 15 4.6C15.3016 4.73312 15.6362 4.77282 15.9606 4.714C16.285 4.65519 16.5843 4.50054 16.82 4.27L16.88 4.21C17.0657 4.02405 17.2863 3.87653 17.5291 3.77588C17.7719 3.67523 18.0322 3.62343 18.295 3.62343C18.5578 3.62343 18.8181 3.67523 19.0609 3.77588C19.3037 3.87653 19.5243 4.02405 19.71 4.21C19.896 4.39575 20.0435 4.61632 20.1441 4.85912C20.2448 5.10192 20.2966 5.36217 20.2966 5.625C20.2966 5.88783 20.2448 6.14808 20.1441 6.39088C20.0435 6.63368 19.896 6.85425 19.71 7.04L19.65 7.1C19.4195 7.33568 19.2648 7.63502 19.206 7.95941C19.1472 8.28381 19.1869 8.61838 19.32 8.92V9C19.4468 9.29577 19.6572 9.54802 19.9255 9.72569C20.1938 9.90337 20.5082 9.99872 20.83 10H21C21.5304 10 22.0391 10.2107 22.4142 10.5858C22.7893 10.9609 23 11.4696 23 12C23 12.5304 22.7893 13.0391 22.4142 13.4142C22.0391 13.7893 21.5304 14 21 14H20.91C20.5882 14.0013 20.2738 14.0966 20.0055 14.2743C19.7372 14.452 19.5268 14.7042 19.4 15Z" stroke="#F6D9E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                    <defs>
                      <clipPath id="clip0_53_275">
                        <rect width="24" height="24" fill="white" />
                      </clipPath>
                    </defs>
                  </svg>
                </a>
              <?php endif; ?>
              <!-- Кнопки для авторизованных пользователей -->
              <a href="<?= PROFILE_URL ?>" class="nav-search__link">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#F6D9E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#F6D9E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </a>
              <a href="<?= PROFILE_URL ?>" class="nav-search__link">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z" stroke="#F6D9E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z" stroke="#F6D9E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="#F6D9E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg></a>
              </a>
              <a href="<?= LOGOUT_URL ?>" class="nav-search__link">Logout</a>
            <?php else : ?>
              <!-- Кнопки для неавторизованных пользователей -->
              <a href="<?= REGISTRATION_URL ?>" class="nav-search__link">Registration</a>
              <a href="<?= LOGIN_URL ?>" class="nav-search__link">Log in</a>
            <?php endif; ?>
          </div>
        </nav>
      </div>
    </div>

  <?php
    $output = ob_get_clean(); // Получаем содержимое буфера и отключаем буферизацию вывода
    return $output;
  }
  ?>