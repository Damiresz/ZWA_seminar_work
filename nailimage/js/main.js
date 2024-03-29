

document.addEventListener('DOMContentLoaded', function () {



  // Blok pro zapomenuté heslo
  if (document.title == 'Authorization') {
    const forgot_block = document.querySelector(".forgot-pass__block");
    const forgot_btn = document.querySelector(".forgot_pwd");
    const forgot_close = document.querySelector(".close");

    // Obsluha tlačítka pro zapomenuté heslo
    forgot_btn.onclick = () => {
      forgot_block.classList.add("active");
    };
    forgot_close.onclick = () => {
      forgot_block.classList.remove("active");
    };
  }




  // Navigační menu na úvodní stránce
  if (document.title == 'NailImage | Eshop') {
    const nav_category = document.querySelector(".categoty");
    const nav_btn = document.querySelector(".nav-btn");
    const body = document.body;

    // Obsluha tlačítka pro zobrazení/skrytí navigačního menu
    nav_btn.addEventListener('click', function () {
      nav_btn.classList.toggle("nav-btn--close");
      nav_category.classList.toggle("category--active");
      const overflowStyle = body.style.overflowY;
      body.style.overflow = overflowStyle === 'hidden' ? '' : 'hidden';
    })

    // Obsluha tlačítka "Add to Basket" na stránce s produkty
    const products = document.getElementById('products')
    products.addEventListener('click', function (event) {
      if (event.target.classList.contains('product-card__button')) {
        const ProductId = event.target.getAttribute('id');
        addToBasket('product-card_form' + ProductId);

      }
    })

    // Obsluha vyhledávacího pole na stránce s produkty
    const search = document.getElementById('search_input');

    search.addEventListener('input', function () {
      var searchValue = search.value || '';
      performSearch(searchValue);
      if (search.value.trim() === '') {
        location.reload();
      }
    })

    window.onload = function () {
      // Automatické zaměření na vyhledávací pole po načtení stránky
      search.focus();
    };
  }







  // Stránka pro úpravu produktu
  if (document.title == 'Product Processing') {
    var selectedCategoryId = document.getElementById('selectedCategoryId') || null;
    if (selectedCategoryId !== null) {
      selectedCategoryId = selectedCategoryId.value;
      loadCategories(selectedCategoryId);
    } else {
      loadCategories(selectedCategoryId);
    }

    var productImg = document.getElementById('productImg');
    productImg.addEventListener('change', uploadFile)
  }







  // Stránka s nastavením produktů
  if (document.title == 'Products Settings') {
    document.getElementById('productCategory').addEventListener('change', function () {
      var selectedValue = this.options[this.selectedIndex].textContent;
      if (selectedValue !== 'All') {
        window.location.href = 'settings_products/category/' + selectedValue;
      } else {
        window.location.href = 'settings_products/';
      }

    });

    // Obsluha vyhledávacího pole na stránce s produkty správce
    const search = document.getElementById('search_input');
    
    search.addEventListener('input', function () {
      var searchValue = search.value || '';
      adminSearch(searchValue);
      document.getElementById('searchDropdown').addEventListener('click', function (event) {
        if (event.target.tagName === 'A') {
          document.getElementById('search_input').value = event.target.textContent;
          document.getElementById('searchDropdown').style.display = 'none';
          document.getElementById('search_admin').click();
        }
      });
    })
    search.addEventListener('blur', function () {
      setTimeout(function () {
        document.getElementById('searchDropdown').style.display = 'none';
      }, 200);
    })
  }







  // Uživatelský profil
  if (document.title === 'Profile') {
    var changeUserDataBtn = document.getElementById("change_user_data");
    var changeUserPasswordBtn = document.getElementById("change_user_password");
    var basketItems = document.getElementById('basket__items')

    // Obsluha tlačítka pro odstranění produktu z košíku
    basketItems.addEventListener('click', function (event) {
      if (event.target.classList.contains('delete_from_basket')) {
        const BasketItemId = event.target.getAttribute('id');
        DeleteFromBasket('basket-card_form' + BasketItemId);
      }
    })
    // Obsluha tlačítka pro změnu osobních údajů uživatele
    changeUserDataBtn.addEventListener('click', function (event) {
      ChangeUserData(event, changeUserDataBtn);
    });

    // Obsluha tlačítka pro změnu hesla uživatele
    changeUserPasswordBtn.addEventListener('click', function (event) {
      ChangeUserPassword(event, changeUserPasswordBtn);
    });




  }

}
)








// Funkce pro vyhledávání produktů
function performSearch(searchValue) {
  var encodedSearchValue = encodeURIComponent(searchValue);

  try {
    fetch(`nailimage/php_logic/api/search.php?search=${encodedSearchValue}`)
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(products => {
        var Products = document.querySelector('.products');
        var Pagination = document.querySelector('.paginations__items');
        Products.innerHTML = '';
        Pagination.innerHTML = '';
        if (products.length === 0) {
          var productCardHTML = `
            <li>
            No product avalable
          </li>
        `;
          Products.insertAdjacentHTML('beforeend', productCardHTML);
          return
        }
        products.forEach(product => {
          var productCardHTML = `
            <li class="product-card">
            <form id="product-card_form${product.id}" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <input type="hidden" name="productId" value="${product.id}">
              <img src="${product.photo_path}" class="product-card__img" alt="${product.name}">
              <div class="product-card__items">
                <h2 class="product-card__title">${product.name}</h2>
                <p class="product-card__price">${product.price} Kč</p>
                <p class="product-card__discription">${product.discription}</p>
              </div>
              <div class="product-card__to-basket">
               <button type="button" class="product-card__button" id='${product.id}'>Add to Basket</button>
              </div>
            </form>
          </li>
        `;
          Products.insertAdjacentHTML('beforeend', productCardHTML);
        });
      })
      .catch(error => {
        var NotificationItems = document.getElementById('notification_items');
        var NotificationItemsChild = document.createElement('p');
        NotificationItemsChild.classList.add('notification_text_error');
        NotificationItemsChild.innerText = error.message;
        NotificationItems.appendChild(NotificationItemsChild);
        setTimeout(function () {
          NotificationItems.removeChild(NotificationItemsChild);
        }, 2000);
      });
  } catch (error) {
    var NotificationItems = document.getElementById('notification_items');
    var NotificationItemsChild = document.createElement('p');
    NotificationItemsChild.classList.add('notification_text_error');
    NotificationItemsChild.innerText = error.message;
    NotificationItems.appendChild(NotificationItemsChild);
    setTimeout(function () {
      NotificationItems.removeChild(NotificationItemsChild);
    }, 2000);
  }
}

// Funkce pro vyhledávání produktů na strance správce
function adminSearch(searchValue) {
  var encodedSearchValue = encodeURIComponent(searchValue);

  try {
    fetch(`nailimage/php_logic/api/search.php?search=${encodedSearchValue}`)
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(products => {
        var Products = document.querySelector('.searchDropdown');
        Products.style.display = 'flex';
        Products.innerHTML = '';
        if (products.length === 0) {
          var Product = document.createElement('p');
          Product.classList.add('searchDropdown_a');
          Product.innerText = 'Nothing';
          Products.appendChild(Product);
          return
        }
        products.forEach(product => {
          var productCardHTML = `
            <a class="searchDropdown_a">${product.name}</a>
        `;
          Products.insertAdjacentHTML('beforeend', productCardHTML);
        });
      })
      .catch(error => {
        var NotificationItems = document.getElementById('notification_items');
        var NotificationItemsChild = document.createElement('p');
        NotificationItemsChild.classList.add('notification_text_error');
        NotificationItemsChild.innerText = error.message;
        NotificationItems.appendChild(NotificationItemsChild);
        setTimeout(function () {
          NotificationItems.removeChild(NotificationItemsChild);
        }, 2000);
      });
  } catch (error) {
    var NotificationItems = document.getElementById('notification_items');
    var NotificationItemsChild = document.createElement('p');
    NotificationItemsChild.classList.add('notification_text_error');
    NotificationItemsChild.innerText = error.message;
    NotificationItems.appendChild(NotificationItemsChild);
    setTimeout(function () {
      NotificationItems.removeChild(NotificationItemsChild);
    }, 2000);
  }
}


// Funkce pro načtení kategorií
function loadCategories(selectedCategoryId) {
  try {
    fetch('nailimage/php_logic/api/get_category.php')
      .then(response => response.json())
      .then(categories => {
        const select = document.getElementById('productCategory');
        categories.forEach(category => {
          const option = document.createElement('option');
          option.value = category.id_category;
          option.textContent = category.name_category;
          if (category.id_category == selectedCategoryId) {
            option.selected = true;
          };
          select.appendChild(option);
        });
      })
      .catch(error => console.error('error', error));
  } catch (error) {
    console.error('Error:', error);
  }

}


// Funkce pro přidání produktu do košíku
function addToBasket(formId) {
  try {
    var form = document.getElementById(formId);
    if (!form || !(form instanceof HTMLFormElement)) {
      throw new Error('Invalid form');
    }
    var formData = new FormData(form);

    fetch('nailimage/php_logic/api/add_to_basket.php', {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        if (data.status === 'success') {
          var NotificationItems = document.getElementById('notification_items');
          var NotificationItemsChild = document.createElement('p');
          NotificationItemsChild.classList.add('notification_text_success');
          NotificationItemsChild.innerText = data.message;
          NotificationItems.appendChild(NotificationItemsChild);
          setTimeout(function () {
            NotificationItems.removeChild(NotificationItemsChild);
          }, 2000);
        } else if (data.status === 'error') {
          var NotificationItems = document.getElementById('notification_items');
          var NotificationItemsChild = document.createElement('p');
          NotificationItemsChild.classList.add('notification_text_error');
          NotificationItemsChild.innerText = data.message;
          NotificationItems.appendChild(NotificationItemsChild);
          setTimeout(function () {
            NotificationItems.removeChild(NotificationItemsChild);
          }, 2000);
        } else if (data.status === 'not_login') {
          window.location.href = 'login';
        } else {
          throw new Error('Unexpected response status');
        }
      })
      .catch(error => {
        var NotificationItems = document.getElementById('notification_items');
        var NotificationItemsChild = document.createElement('p');
        NotificationItemsChild.classList.add('notification_text_error');
        NotificationItemsChild.innerText = error;
        NotificationItems.appendChild(NotificationItemsChild);
        setTimeout(function () {
          NotificationItems.removeChild(NotificationItemsChild);
        }, 2000);
      });
  } catch (error) {
    var NotificationItems = document.getElementById('notification_items');
    var NotificationItemsChild = document.createElement('p');
    NotificationItemsChild.classList.add('notification_text_error');
    NotificationItemsChild.innerText = error.message;
    NotificationItems.appendChild(NotificationItemsChild);
    setTimeout(function () {
      NotificationItems.removeChild(NotificationItemsChild);
    }, 2000);
  }
}

// Funkce pro odstranění produktu z košíku
function DeleteFromBasket(formId) {
  try {
    var form = document.getElementById(formId);
    if (!form || !(form instanceof HTMLFormElement)) {
      throw new Error('Invalid form');
    }
    var formData = new FormData(form);
    fetch('nailimage/php_logic/api/delete_from_basket.php', {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        if (data.status === 'success') {
          if (form) {
            var productPrice = parseFloat(form.querySelector('.ProductPrice').textContent);
            var totalPriceElement = document.getElementById('TotalPrice');
            var quantityElement = form.querySelector('.quantity').value;
            var totalPrice = parseFloat(totalPriceElement.textContent);

            var newTotalPrice = totalPrice - (productPrice * quantityElement);

            totalPriceElement.innerText = newTotalPrice.toFixed() + ' Kč';
            form.remove();
            // Проверяем, остался ли только один элемент
            var remainingElements = document.querySelectorAll('.basket__item');

            if (remainingElements.length === 0) {
              var elementToRemove1 = document.getElementById('total');
              var elementToRemove2 = document.getElementById('order_btn');
              if (elementToRemove1 && elementToRemove2) {
                elementToRemove1.remove();
                elementToRemove2.remove();
                var BasketItems = document.getElementById('basket__items');
                var BasketItemsChild = document.createElement('p');
                BasketItemsChild.classList.add('basket_not_available');
                BasketItemsChild.innerText = "No Products Available";
                BasketItems.appendChild(BasketItemsChild);
              }
            }
          }
        } else if (data.status === 'error') {
          var NotificationItems = document.getElementById('notification_items');
          var NotificationItemsChild = document.createElement('p');
          NotificationItemsChild.classList.add('notification_text_error');
          NotificationItemsChild.innerText = data.message;
          NotificationItems.appendChild(NotificationItemsChild);
          setTimeout(function () {
            NotificationItems.removeChild(NotificationItemsChild);
          }, 2000);
        } else {
          throw new Error('Unexpected response status');
        }
      })
      .catch(error => {
        var NotificationItems = document.getElementById('notification_items');
        var NotificationItemsChild = document.createElement('p');
        NotificationItemsChild.classList.add('notification_text_error');
        NotificationItemsChild.innerText = error;
        NotificationItems.appendChild(NotificationItemsChild);
        setTimeout(function () {
          NotificationItems.removeChild(NotificationItemsChild);
        }, 2000);
      });
  } catch (error) {
    var NotificationItems = document.getElementById('notification_items');
    var NotificationItemsChild = document.createElement('p');
    NotificationItemsChild.classList.add('notification_text_error');
    NotificationItemsChild.innerText = error.message;
    NotificationItems.appendChild(NotificationItemsChild);
    setTimeout(function () {
      NotificationItems.removeChild(NotificationItemsChild);
    }, 2000);
  }
}




// Funkce pro stažení souboru
function uploadFile() {
  document.getElementById('success_local_upload').innerText = '';
  document.getElementById('error_local_upload').innerText = '';
  document.getElementById('noutification_local_upload').innerText = '';

  const fileproductImg = document.getElementById('productImg');
  const productImgInput = document.querySelector('.add__item > .productImg');

  // Check if any file is selected
  if (!fileproductImg || fileproductImg.files.length === 0) {
    productImgInput.innerText = 'add image';
    document.getElementById('error_local_upload').innerText = 'Image is not selected';
    return;
  }
  // Check if any file size
  if (fileproductImg.files[0].size > 2 * 1024 *1024) {
    productImgInput.innerText = 'add image';
    document.getElementById('error_local_upload').innerText = 'Image more 2MB';
    return;
  }
  const file = fileproductImg.files[0];
  const formData = new FormData();
  formData.append('productImg', file);


  if (productImgInput) {
    productImgInput.innerText = file.name;
    document.getElementById('noutification_local_upload').innerText = 'Wait for the download to the server';
  }


  fetch('nailimage/php_logic/api/upload.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        document.getElementById('noutification_local_upload').innerText = '';
        document.getElementById('success_local_upload').innerText = data.message;
        document.getElementById('productImgUrl').setAttribute('value', data.file_url);
      }
      if (data.status === 'error') {
        document.getElementById('noutification_local_upload').innerText = '';
        document.getElementById('error_local_upload').innerText = data.message;
        productImgInput.innerText = 'add image';
      }
    })
    .catch(error => {
      document.getElementById('noutification_local_upload').innerText = '';
      document.getElementById('error_main').innerText = 'Loading error: ' + error.message;
      productImgInput.innerText = 'add image';
    });
}

// Funkce pro otevření změny uživatelských dat
function ChangeUserData(event, changeUserDataBtn) {
  event.preventDefault();

  var UserDataForm = document.getElementById('user__form__data');
  UserDataForm.setAttribute('method', 'post');

  var inputElements = UserDataForm.querySelectorAll('input');


  inputElements.forEach(function (input) {
    input.removeAttribute('readonly');
    if (input.classList.contains('read_only')) {
      input.classList.remove('read_only');
    }
  });

  var UpdateButton = document.getElementById('update_user_data');

  changeUserDataBtn.setAttribute('type', 'hidden');
  UpdateButton.setAttribute('type', 'submit');
}

// Funkce pro otevření změny uživatelských hesel
function ChangeUserPassword(event, changeUserPasswordBtn) {
  event.preventDefault();

  var UserFormChangePassword = document.getElementById('user__form__password');
  UserFormChangePassword.setAttribute('method', 'post');

  var Elements = UserFormChangePassword.querySelector('.profil__items');


  if (Elements) {
    Elements.classList.remove('profil__items_hidden');
  }


  var UpdateButton = document.getElementById('update_user_password');

  changeUserPasswordBtn.setAttribute('type', 'hidden');
  UpdateButton.setAttribute('type', 'submit');
}
