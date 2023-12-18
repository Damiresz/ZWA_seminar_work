// Funkce pro nastavení chybové zprávy
const setError = (element, message) => {
  const InputControl = element.parentElement;
  const errorDisplay = InputControl.querySelector('.error_local');

  errorDisplay.innerText = message;
  InputControl.classList.add("error");
  InputControl.classList.remove("success");
}

// Funkce pro nastavení úspěšné zprávy
const setSuccess = (element) => {
  const InputControl = element.parentElement;
  const errorDisplay = InputControl.querySelector('.error_local');

  errorDisplay.innerText = "";
  InputControl.classList.remove("error");
}

// Funkce pro validace jména 
const isValidName = (element) => {
  const regex = /(^[A-Z]{1}[a-z]{1,14}$)|(^[А-Я]{1}[а-я]{1,14}$)/;
  return regex.test(String(element));
}

// Funkce pro validace uživatelského jména
const isValidUsername = (element) => {
  const regex = /^[a-z0-9]{3,10}$/;
  return regex.test(String(element));
}

// Funkce pro validace emailu
const isValidMail = (element) => {
  const regex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
  return regex.test(String(element));
}
// Funkce pro validace adresy
const isValidAddress = (element) => {
  const regex = /^$|^[0-9A-Za-z\s./-]+$/;
  return regex.test(String(element));
}
// Funkce pro validace PSČ
const isValidPostcode = (element) => {
  const regex = /^(\d{4,6})?$/;
  return regex.test(String(element));
}

// Funkce pro validace hesla
const isValidPwd = (element) => {
  const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,32}$/;
  return regex.test(String(element));
}


// Funkce pro validaci vstupních polí uživatele
const validateInputsUser = (form) => {

  const name = form.querySelector("#name");
  const surname = form.querySelector("#surname");
  const username = form.querySelector("#username");
  const email = form.querySelector("#email");
  const address = form.querySelector("#address");
  const city = form.querySelector("#city");
  const postcode = form.querySelector("#postcode");
  const country = form.querySelector("#country");
  const pwd = form.querySelector("#password");
  const pwd2 = form.querySelector("#password2");

  const nameValue = name instanceof HTMLInputElement ? name.value.trim() : null;
  const surnameValue = surname instanceof HTMLInputElement ? surname.value.trim() : null;
  const usernameValue = username instanceof HTMLInputElement ? username.value.trim() : null;
  const emailValue = email instanceof HTMLInputElement ? email.value.trim() : null;
  const addressValue = address instanceof HTMLInputElement ? address.value.trim() : null;
  const cityValue = city instanceof HTMLInputElement ? city.value.trim() : null;
  const postcodeValue = postcode instanceof HTMLInputElement ? postcode.value.trim() : null;
  const countryValue = country instanceof HTMLInputElement ? country.value.trim() : null;
  const pwdValue = pwd instanceof HTMLInputElement ? pwd.value.trim() : null;
  const pwd2Value = pwd2 instanceof HTMLInputElement ? pwd2.value.trim() : null;

  var NameIsValid = false;
  var SurnameIsValid = false;
  var UsernameIsValid = false;
  var EmailIsValid = false;
  var AddressIsValid = false;
  var CityIsValid = false;
  var PostcodeIsValid = false;
  var CountryIsValid = false;
  var PwdIsValid = false;
  var Pwd2IsValid = false;

  // Validace jména
  if (nameValue === null) {
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

  // Validace příjmení
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

  // Validace uživatelského jména
  if (usernameValue === null) {
    UsernameIsValid = true;
  } else if (usernameValue === "") {
    setError(username, 'Entity cannot be empty');
    UsernameIsValid = false;
  } else if (usernameValue.length < 3) {
    setError(username, 'Entity cannot be shorter than 3 characters');
    UsernameIsValid = false;
  } else if (usernameValue.length > 10) {
    setError(username, 'Entity cannot be longer than 10 characters');
    UsernameIsValid = false;
  } else if (!isValidUsername(usernameValue)) {
    setError(username, 'Invalid characters');
    UsernameIsValid = false;
  } else {
    setSuccess(username);
    UsernameIsValid = true;
  }

  // Validace emailu
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

  // Validace adresy
  if (addressValue === null) {
    AddressIsValid = true;
  } else if (!isValidAddress(addressValue)) {
    setError(address, 'Incorrectly entered address');
    AddressIsValid = false;
  } else {
    setSuccess(address);
    AddressIsValid = true;
  }

  // Validace města
  if (cityValue === null) {
    CityIsValid = true;
  } else if (!isValidAddress(cityValue)) {
    setError(city, 'Incorrectly set city');
    CityIsValid = false;
  } else {
    setSuccess(city);
    CityIsValid = true;
  }
  // Validace PSČ
  if (postcodeValue === null) {
    PostcodeIsValid = true;
  } else if (!isValidPostcode(postcodeValue)) {
    setError(postcode, 'The postal code is set incorrectly');
    PostcodeIsValid = false;
  } else {
    setSuccess(postcode);
    PostcodeIsValid = true;
  }
  // Validace země
  if (countryValue === null) {
    CountryIsValid = true;
  } else if (!isValidAddress(countryValue)) {
    setError(country, 'The country is set incorrectly');
    CountryIsValid = false;
  } else {
    setSuccess(country);
    CountryIsValid = true;
  }

  // Validace hesla
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

  // Validace potvrzení hesla
  if (pwd2Value === null) {
    Pwd2IsValid = true;
  } else if (pwd2Value === "") {
    setError(pwd2, "Entity cannot be empty");
    Pwd2IsValid = false;
  } else if (!isValidPwd(pwd2Value)) {
    setError(pwd2, "The password must be at least 8 characters and contain A-Z a-z 0-9");
    Pwd2IsValid = false;
  } else if (pwdValue !== pwd2Value) {
    setError(pwd2, "Passwords don't match");
    Pwd2IsValid = false;
  } else {
    setSuccess(pwd2);
    Pwd2IsValid = true;
  }

  // Vrátíme výsledek validace
  if (NameIsValid & SurnameIsValid & UsernameIsValid & EmailIsValid & AddressIsValid & CityIsValid & PostcodeIsValid & CountryIsValid & PwdIsValid & Pwd2IsValid) {
    return true;
  } else {
    return false;
  }

}

// Událost DOMContentLoaded pro formulář uživatele
document.addEventListener('DOMContentLoaded', function () {
  const UserForm = document.getElementById("user__form");
  const UserDataChangeForm = document.getElementById("user__form__data");
  const UserPasswordChangeForm = document.getElementById("user__form__password");


  if (UserForm === null) {
    // Formulář nenalezen
  } else {
    UserForm.addEventListener("submit", user_event => {
      if (!validateInputsUser(UserForm)) {
        // Pokud validace neproběhla úspěšně, zrušíme odeslání formuláře
        user_event.preventDefault();
      } else {
        // Validace byla úspěšná, můžeme zpracovat formulář
      }
    });
  }


  if (UserDataChangeForm === null) {
    // Formulář nenalezen
  } else {
    UserDataChangeForm.addEventListener("submit", data_event => {
      if (!validateInputsUser(UserDataChangeForm)) {
        // Pokud validace neproběhla úspěšně, zrušíme odeslání formuláře
        data_event.preventDefault();
      } else {
        // Validace byla úspěšná, můžeme zpracovat formulář
      }
    });
  }


  if (UserPasswordChangeForm === null) {
    // Formulář nenalezen
  } else {
    UserPasswordChangeForm.addEventListener("submit", password_event => {
      if (!validateInputsUser(UserPasswordChangeForm)) {
        // Pokud validace neproběhla úspěšně, zrušíme odeslání formuláře
        password_event.preventDefault();
      } else {
        // Validace byla úspěšná, můžeme zpracovat formulář
      }
    });
  }

})

