

document.addEventListener('DOMContentLoaded', function () {

  if (document.title == 'Add Product')
    loadCategories();
})


function loadCategories() {
  try {
    fetch('nailimage/php_logic/api/get_category.php')
      .then(response => response.json())
      .then(categories => {
        const select = document.getElementById('productCategory');
        categories.forEach(category => {
          const option = document.createElement('option');
          option.value = category.id;
          option.textContent = category.name;
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
