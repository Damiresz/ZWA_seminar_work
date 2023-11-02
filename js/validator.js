window.addEventListener('load', load)


function load (e) {
  
  const form = document.getElementById("registration__form");
  if (form == null) {
    return;
  }


  const name = document.getElementById("name")
  const surname = document.getElementById("surname")
  const username = document.getElementById("username")
  const email = document.getElementById("email")
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

const isValidPwd = (element) => {
  const regex =/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,32}$/;
  return regex.test(String(element));
}


const validateInputs = () => {
  const nameValue = name ? name.value.trim() : null;
  const surnameValue = surname ? surname.value.trim() : null;
  const usernameValue = username ? username.value.trim() : null;
  const emailValue = email ? email.value.trim() : null;
  const pwdValue = pwd ? pwd.value.trim() : null;
  const pwd2Value = pwd2 ? pwd2.value.trim() : null;

  let NameIsValid = true;
  let SurnameIsValid = true;
  let UsernameIsValid = true;
  let EmailIsValid = true;
  let PwdIsValid = true;
  let Pwd2IsValid = true;

  if (nameValue === null ) {
    NameIsValid = true;
  } else if (nameValue === "") {
    setError(name, 'Поле не может быть пустым');
    NameIsValid = false;
  } else if (nameValue.length < 2) {
    setError(name, 'Поле не может быть короче 2 символов');
    NameIsValid = false;
  } else if (nameValue.length > 14) {
    setError(name, 'Поле не может быть длиньше 14 символов');
    NameIsValid = false;
  } else if (!isValidName(nameValue)) {
    setError(name, 'Неккоректные данные');
    NameIsValid = false;
  } else {
    setSuccess(name);
    NameIsValid = true;
  }
  
  if (surnameValue === null) {
    SurnameIsValid = true;
  } else if (surnameValue === "") {
      setError(surname, 'Поле не может быть пустым');
      SurnameIsValid = false;
  } else if (surnameValue.length < 2) {
      setError(surname, 'Поле не может быть короче 2 символов');
      SurnameIsValid = false;
  } else if (surnameValue.length > 14) {
      setError(surname, 'Поле не может быть длиньше 14 символов');
      SurnameIsValid = false;
  } else if (!isValidName(surnameValue)) {
      setError(surname, 'Неккоректные данные');
      SurnameIsValid = false;
  } else {
      setSuccess(surname);
      SurnameIsValid = true;
  }

  if (usernameValue === null) {
    UsernameIsValid = true;
  } else if (usernameValue === "") {
    setError(username, 'Поле не может быть пустым');
    UsernameIsValid = false;
  } else if (usernameValue.length < 3) {
    setError(username, 'Поле не может быть короче 3 символов');
    UsernameIsValid = false;
  } else if (usernameValue.length > 10  ) {
    setError(username, 'Поле не может быть длиньше 10 символов');
    UsernameIsValid = false;
  } else if (!isValidUsername(usernameValue)) {
    setError(username, 'Недопустимые символы');
    UsernameIsValid = false;
  } else {
    setSuccess(username);
    UsernameIsValid = true;
  }

  if (emailValue === null) {
    EmailIsValid = true;
  } else if (emailValue === "") {
    setError(email, 'Поле не может быть пустым');
    EmailIsValid = false;
  } else if (!isValidMail(emailValue)) {
    setError(email, 'Не корректно заданные данные');
    EmailIsValid = false;
  } else {
    setSuccess(email);
    EmailIsValid = true;
  }

  if (pwdValue === null) {
    PwdIsValid = true;
  } else if (pwdValue === "") {
    setError(pwd, "Поле не может быть пустым");
    PwdIsValid = false;
  } else if (!isValidPwd(pwdValue)) {
    setError(pwd, "Пароль должен быть минимум 8 символов и содержать A-Z a-z 0-9");
    PwdIsValid = false;
  } else {
    setSuccess(pwd);
    PwdIsValid = true;
  }

  if (pwd2Value === null) {
    Pwd2IsValid = true;
  } else if (pwd2Value === "") {
    setError(pwd2, "Поле не может быть пустым");
    Pwd2IsValid = false;
  } else if (!isValidPwd(pwd2Value)) {
    setError(pwd, "Пароль должен быть минимум 8 символов и содержать A-Z a-z 0-9");
    Pwd2IsValid = false;
  } else if (pwdValue !== pwd2Value) {
    setError(pwd2, "Пароли не совпадают");
    Pwd2IsValid = false;
  } else {
    setSuccess(pwd2);
    Pwd2IsValid = true;
  }

  if (NameIsValid & SurnameIsValid & UsernameIsValid & EmailIsValid & PwdIsValid & Pwd2IsValid) {
    return true;
  } else {
    return false;
  }
  
}
}
