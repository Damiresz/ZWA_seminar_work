

document.addEventListener('DOMContentLoaded', function() {

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
  const fileproductImg = document.getElementById('productImg');
  const file = fileproductImg.files[0];
  const formData = new FormData();
  formData.append('productImg', file);

  fetch('nailimage/php_logic/api/upload.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      document.getElementById('success_local_upload').innerText = data.message;
      document.getElementById('productImgUrl').setAttribute('value',data.file_url);
    }
    if (data.status === 'error') {
      document.getElementById('error_local_upload').innerText = data.message;
    }
  })
  .catch(error => {
    document.getElementById('error_main').innerText = error;
  });
}
