
// Funkce pro validace ceny produktu
const isValidProductPrice = (element) => {
  const regex = /^(\d{1,6})?$/;
  return regex.test(String(element));
}

// Funkce pro validace názvu kategorie
const isValidCategoryName = (element) => {
  const regex = /^[a-z]{2,8}$/;
  return regex.test(String(element));
}



// Funkce pro validaci vstupních polí produktu
const validateInputsProduct = (form) => {
  const productName = form.querySelector("#productName");
  const productImgUrl = form.querySelector("#productImgUrl");
  const productDiscription = form.querySelector("#productDiscription");
  const productPrice = form.querySelector("#productPrice");
  const categoryName = form.querySelector("#categoryName");


  const productNameValue = productName instanceof HTMLInputElement ? productName.value.trim() : null;
  const productImgUrlValue = productImgUrl instanceof HTMLInputElement ? productImgUrl.value.trim() : null;
  const productDiscriptionValue = productDiscription instanceof HTMLTextAreaElement ? productDiscription.value.trim() : null;
  const productPriceValue = productPrice instanceof HTMLInputElement ? productPrice.value.trim() : null;
  const categoryNameValue = categoryName instanceof HTMLInputElement ? categoryName.value.trim() : null;

  var productNameIsValid = false;
  var productImgUrlValid = false;
  var productDiscriptionIsValid = false;
  var productPriceIsValid = false;
  var categoryNameIsValid = false;

  // Validace názvu produktu
  if (productNameValue === null) {
    productNameIsValid = true;
  } else if (productNameValue === "") {
    setError(productName, 'Entity cannot be empty');
    productNameIsValid;
  } else if (productNameValue.length < 2) {
    setError(productName, 'Entity cannot be shorter than 2 characters');
    productNameIsValid;
  } else if (productNameValue.length > 30) {
    setError(productName, 'Entity cannot be longer than 30 characters');
    productNameIsValid;
  } else {
    setSuccess(productName);
    productNameIsValid = true;
  }

  // Validace URL obrázku produktu
  if (productImgUrlValue === null) {
    productImgUrlValid = true;
  } else if (productImgUrlValue === "") {
    setError(productImgUrl, 'Entity cannot be empty');
    productImgUrlValid;
  } else {
    setSuccess(productImgUrl);
    productImgUrlValid = true;
  }
  // Validace popisu produktu
  if (productDiscriptionValue === null) {
    productDiscriptionIsValid = true;
  } else if (productDiscriptionValue === "") {
    setError(productDiscription, 'Entity cannot be empty');
    productDiscriptionIsValid;
  } else if (productDiscriptionValue.length < 15) {
    setError(productDiscription, 'Entity cannot be shorter than 15 characters');
    productDiscriptionIsValid;
  } else if (productDiscriptionValue.length > 250) {
    setError(productDiscription, 'Entity cannot be longer than 250 characters');
    productDiscriptionIsValid;
  } else {
    setSuccess(productDiscription);
    productDiscriptionIsValid = true;
  }
  // Validace ceny produktu
  if (productPriceValue === null) {
    productPriceIsValid = true;
  } else if (productPriceValue === "") {
    setError(productPrice, 'Entity cannot be empty');
    productPriceIsValid;
  } else if (!isValidProductPrice(productPriceValue)) {
    setError(productPrice, 'Incorrectly entered price');
    productPriceIsValid;
  } else {
    setSuccess(productPrice);
    productPriceIsValid = true;
  }

  // Validace názvu kategorie
  if (categoryNameValue === null) {
    categoryNameIsValid = true;
  } else if (categoryNameValue === "") {
    setError(categoryName, 'Entity cannot be empty');
    categoryNameIsValid;
  } else if (categoryNameValue.length < 2) {
    setError(categoryName, 'Entity cannot be shorter than 2 characters');
    categoryNameIsValid;
  } else if (categoryNameValue.length > 8) {
    setError(categoryName, 'Entity cannot be longer than 8 characters');
    categoryNameIsValid;
  } else if (!isValidCategoryName(categoryNameValue)) {
    setError(categoryName, 'Use only letters');
    categoryNameIsValid;
  } else {
    setSuccess(categoryName);
    categoryNameIsValid = true;
  }

  // Vrátíme výsledek validace
  if (productNameIsValid & productImgUrlValid & productDiscriptionIsValid & productPriceIsValid & categoryNameIsValid) {
    return true;
  } else {
    return false;
  }

}

// Událost DOMContentLoaded pro formulář produktu
document.addEventListener('DOMContentLoaded', function () {
  const ProductForm = document.getElementById('product_form')



  if (ProductForm === null) {
    // Formulář nenalezen
  } else {
    ProductForm.addEventListener("submit", product_event => {
      if (!validateInputsProduct(ProductForm)) {
        // Pokud validace neproběhla úspěšně, zrušíme odeslání formuláře
        product_event.preventDefault();
      } else {
        // Validace byla úspěšná, můžeme zpracovat formulář
      }
    });
  }

})

