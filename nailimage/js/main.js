

document.addEventListener('DOMContentLoaded', function () {

  if (document.title == 'Authorization') {
    const forgot_block = document.querySelector(".forgot-pass__block");
    const forgot_btn = document.querySelector(".forgot_pwd");
    const forgot_close = document.querySelector(".close");

    forgot_btn.onclick = () => {
      forgot_block.classList.add("active");
    };

    forgot_close.onclick = () => {
      forgot_block.classList.remove("active");
    };
  }



  if (document.title == 'NailImage | Eshop') {
    const nav_category = document.querySelector(".categoty");
    const nav_btn = document.querySelector(".nav-btn");
    const body = document.body;

    nav_btn.addEventListener('click', function () {
      nav_btn.classList.toggle("nav-btn--close");
      nav_category.classList.toggle("category--active");
      const overflowStyle = body.style.overflowY;
      body.style.overflow = overflowStyle === 'hidden' ? '' : 'hidden';
    })

  }



  if (document.title == 'Product Processing') {
    if (typeof selectedCategoryId !== 'undefined' && !isNaN(selectedCategoryId)) {
      loadCategories(selectedCategoryId);
    } else {
      loadCategories(null);
    }


  }

  if (document.title == 'Products Settings') {
    document.getElementById('productCategory').addEventListener('change', function () {
      var selectedValue = this.options[this.selectedIndex].textContent;
      if (selectedValue !== 'All') {
        window.location.href = 'settings_products/category/' + selectedValue;
      } else {
        window.location.href = 'settings_products/';
      }

    });
  }

}
)



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
          }
          select.appendChild(option);
        });
      })
      .catch(error => console.error('Ошибка при загрузке категорий:', error));
  } catch (error) {
    console.error('Общая ошибка:', error);
  }

}



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


function DeleteFromBasket(formId) {
  try {
    var form = document.getElementById(formId);
    if (!form || !(form instanceof HTMLFormElement)) {
      throw new Error('Invalid form');
    }
    var formData = new FormData(form);

    for (var pair of formData.entries()) {
      console.log(pair[0] + ': ' + pair[1]);
    }

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
            var productPrice = document.getElementById('ProductPrice').textContent;
            var totalPriceElement = document.getElementById('TotalPrice');
            var totalPrice = parseFloat(totalPriceElement.textContent);

            var newTotalPrice = totalPrice - parseFloat(productPrice);

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





function uploadFile() {
  document.getElementById('success_local_upload').innerText = '';
  document.getElementById('error_local_upload').innerText = '';
  document.getElementById('noutification_local_upload').innerText = '';

  const fileproductImg = document.getElementById('productImg');
  if (fileproductImg.files.length === null) {
    document.getElementById('error_local_upload').innerText = 'Image is not selected';
    return;
  }
  const file = fileproductImg.files[0];
  const formData = new FormData();
  formData.append('productImg', file);


  const productImgInput = document.querySelector('.add__item > .productImg');
  if (productImgInput) {
    productImgInput.innerText = fileproductImg.files[0].name;
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


function ChangeUserData() {

  var UserDataForm = document.getElementById('user__form__data');
  UserDataForm.setAttribute('method', 'post');

  var inputElements = UserDataForm.querySelectorAll('input');


  inputElements.forEach(function (input) {
    input.removeAttribute('readonly');
    input.removeAttribute('class');
  });

  var ChangeButton = UserDataForm.querySelector('.profil_submit');

  ChangeButton.setAttribute('type', 'submit');
  ChangeButton.textContent = 'Save';
  ChangeButton.removeAttribute('onclick');
  return false;
}


function ChangeUserPassword() {

  var UserFormChangePassword = document.getElementById('user__form__password');
  UserFormChangePassword.setAttribute('method', 'post');

  var Elements = UserFormChangePassword.querySelector('.profil__items');


  if (Elements) {
    Elements.classList.remove('profil__items_hidden');
  }

  var ChangeButton = UserFormChangePassword.querySelector('.profil_submit');

  ChangeButton.setAttribute('type', 'submit');
  ChangeButton.textContent = 'Save';
  ChangeButton.removeAttribute('onclick');
  return false;
}


