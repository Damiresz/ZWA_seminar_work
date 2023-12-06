

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
    const nav_btn = document.getElementById("nav-btn");
  
    nav_btn.addEventListener('click', function() {
      nav_category.classList.toggle("category--active");
    })  
  }

  if (document.title == 'Add Product') {
    loadCategories();
  }

  if (document.title == 'Products Settings') {
    document.getElementById('productCategory').addEventListener('change', function () {
      var selectedValue = this.options[this.selectedIndex].textContent;
      window.location.href = 'products_settings/category/' + selectedValue;
    });
  }

}
)



function loadCategories() {
  try {
    fetch('nailimage/php_logic/api/get_category.php')
      .then(response => response.json())
      .then(categories => {
        const select = document.getElementById('productCategory');
        categories.forEach(category => {
          const option = document.createElement('option');
          option.value = category.id;
          option.textContent = category.category_name;
          select.appendChild(option);
        });
      })
      .catch(error => console.error('Ошибка при загрузке категорий:', error));
  } catch (error) {
    console.error('Общая ошибка:', error);
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


  inputElements.forEach(function(input) {
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









