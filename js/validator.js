window.addEventListener('load', load)


function load (e) {
  
  const form = document.getElementById("user__form");
  if (form == null) {
    return;
  }


  const name = document.getElementById("name")
  const surname = document.getElementById("surname")
  const username = document.getElementById("username")
  const email = document.getElementById("email")
  const address = document.getElementById("address")
  const city = document.getElementById("city")
  const postcode = document.getElementById("postcode")
  const country = document.getElementById("country")
  const pwd = document.getElementById("password")
  const pwd2 = document.getElementById("password2")

  form.addEventListener("submit", e => {
  if (!validateInputs()) {
  e.preventDefault();
  }
});



// Фугкция для установки класса ошибки и вывода сообщения
const setError = (element, message) => {
  const InputControl = element.parentElement;
  const errorDisplay = InputControl.querySelector('.error_local');

  errorDisplay.innerText = message;
  InputControl.classList.add("error");
  InputControl.classList.remove("success");
}

// Функция корректных данных 
const setSuccess = (element) => {
  const InputControl = element.parentElement;
  const errorDisplay = InputControl.querySelector('.error_local');

  errorDisplay.innerText = "";
  InputControl.classList.remove("error");
}

// Функция для проверки Имени Фамилии 
const isValidName = (element) => {
  const regex = /(^[A-Z]{1}[a-z]{1,14}$)|(^[А-Я]{1}[а-я]{1,14}$)/;
  return regex.test(String(element));
}
// Фенкция для проверки Username
const isValidUsername = (element) => {
  const regex = /^[a-z0-9]{3,10}$/;
  return regex.test(String(element));
}

// Функция для проверки Email
const isValidMail = (element) => {
  const regex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
  return regex.test(String(element));
}

const isValidAddress = (element) => {
  const regex = /^$|^[0-9A-Za-z\s./-]+$/;
  return regex.test(String(element));
}

const isValidPostcode = (element) => {
  const regex = /^(\d{4,6})?$/;
  return regex.test(String(element));
}


const isValidPwd = (element) => {
  const regex =/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,32}$/;
  return regex.test(String(element));
}


const validateInputs = () => {
  const nameValue = name ? name.value.trim() : null;
  const surnameValue = surname ? surname.value.trim() : null;
  const usernameValue = username ? username.value.trim() : null;
  const emailValue = email ? email.value.trim() : null;
  const addressValue = address ? address.value.trim() : null;
  const cityValue = city ? city.value.trim() : null;
  const postcodeValue = postcode ? postcode.value.trim() : null;
  const countryValue = country ? country.value.trim() : null;
  const pwdValue = pwd ? pwd.value.trim() : null;
  const pwd2Value = pwd2 ? pwd2.value.trim() : null;

  let NameIsValid = false;
  let SurnameIsValid = false;
  let UsernameIsValid = false;
  let EmailIsValid = false;
  let AddressIsValid =  false;
  let CityIsValid = false;
  let PostcodeIsValid = false;
  let CountryIsValid = false;
  let PwdIsValid = false;
  let Pwd2IsValid = false;

  if (nameValue === null ) {
    NameIsValid = true;
  } else if (nameValue === "") {
    setError(name, 'Entity cannot be empty');
    NameIsValid;
  } else if (nameValue.length < 2) {
    setError(name, 'Entity cannot be shorter than 2 characters');
    NameIsValid;
  } else if (nameValue.length > 14) {
    setError(name, 'Entity cannot be longer than 14 characters');
    NameIsValid;
  } else if (!isValidName(nameValue)) {
    setError(name, 'Incorrect data');
    NameIsValid;
  } else {
    setSuccess(name);
    NameIsValid = true;
  }
  
  if (surnameValue === null) {
      SurnameIsValid = true;
  } else if (surnameValue === "") {
      setError(surname, 'Entity cannot be empty');
      SurnameIsValid = false;
  } else if (surnameValue.length < 2) {
      setError(surname, 'Entity cannot be shorter than 2 characters');
      SurnameIsValid = false;
  } else if (surnameValue.length > 14) {
      setError(surname, 'Entity cannot be longer than 14 characters');
      SurnameIsValid = false;
  } else if (!isValidName(surnameValue)) {
      setError(surname, 'Incorrect data');
      SurnameIsValid = false;
  } else {
      setSuccess(surname);
      SurnameIsValid = true;
  }

  if (usernameValue === null) {
    UsernameIsValid = true;
  } else if (usernameValue === "") {
    setError(username, 'Entity cannot be empty');
    UsernameIsValid = false;
  } else if (usernameValue.length < 3) {
    setError(username, 'Entity cannot be shorter than 3 characters');
    UsernameIsValid = false;
  } else if (usernameValue.length > 10  ) {
    setError(username, 'Entity cannot be longer than 10 characters');
    UsernameIsValid = false;
  } else if (!isValidUsername(usernameValue)) {
    setError(username, 'Invalid characters');
    UsernameIsValid = false;
  } else {
    setSuccess(username);
    UsernameIsValid = true;
  }

  if (emailValue === null) {
    EmailIsValid = true;
  } else if (emailValue === "") {
    setError(email, 'Entity cannot be empty');
    EmailIsValid = false;
  } else if (!isValidMail(emailValue)) {
    setError(email, 'Incorrectly entered data');
    EmailIsValid = false;
  } else {
    setSuccess(email);
    EmailIsValid = true;
  }

  if (addressValue === null) {
    AddressIsValid = true;
  } else if (!isValidAddress(addressValue)) {
    setError(address, 'Incorrectly entered address');
    AddressIsValid;
  } else {
    setSuccess(address);
    AddressIsValid = true;
  }

  if (cityValue === null) {
    CityIsValid = true;
  } else if (!isValidAddress(cityValue)) {
    setError(city, 'Incorrectly set city');
    CityIsValid;
  } else {
    setSuccess(city);
    CityIsValid = true;
  }

  if (postcodeValue === null) {
    PostcodeIsValid = true;
  } else if (!isValidPostcode(postcodeValue)) {
    setError(postcode, 'The postal code is set incorrectly');
    PostcodeIsValid;
  } else {
    setSuccess(postcode);
    PostcodeIsValid = true;
  }

  if (countryValue === null) {
    CountryIsValid = true;
  } else if (!isValidAddress(countryValue)) {
    setError(country, 'The country is set incorrectly');
    CountryIsValid;
  } else {
    setSuccess(country);
    CountryIsValid = true;
  }

  if (pwdValue === null) {
    PwdIsValid = true;
  } else if (pwdValue === "") {
    setError(pwd, "Entity cannot be empty");
    PwdIsValid = false;
  } else if (!isValidPwd(pwdValue)) {
    setError(pwd, "The password must be at least 8 characters and contain A-Z a-z 0-9");
    PwdIsValid = false;
  } else {
    setSuccess(pwd);
    PwdIsValid = true;
  }

  if (pwd2Value === null) {
    Pwd2IsValid = true;
  } else if (pwd2Value === "") {
    setError(pwd2, "Entity cannot be empty");
    Pwd2IsValid = false;
  } else if (!isValidPwd(pwd2Value)) {
    setError(pwd, "The password must be at least 8 characters and contain A-Z a-z 0-9");
    Pwd2IsValid = false;
  } else if (pwdValue !== pwd2Value) {
    setError(pwd2, "Passwords don't match");
    Pwd2IsValid = false;
  } else {
    setSuccess(pwd2);
    Pwd2IsValid = true;
  }

  if (NameIsValid & SurnameIsValid & UsernameIsValid & EmailIsValid & AddressIsValid & CityIsValid & PostcodeIsValid & CityIsValid & PwdIsValid & Pwd2IsValid) {
    return true;
  } else {
    return false;
  }
  
}
}
