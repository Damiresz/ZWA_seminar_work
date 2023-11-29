

document.addEventListener('DOMContentLoaded', function() {
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
