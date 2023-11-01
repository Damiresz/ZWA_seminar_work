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
  e.preventDefault();

  validateInputs();
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
  return regex.test(String(element))
}
// Фенкция для проверки Username
const isValidUsername = (element) => {
  const regex = /^[a-z0-9]{3,10}$/;
  return regex.test(String(element))
}

// Функция для проверки Email
const isValidMail = (element) => {
  const regex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/
  return regex.test(String(element))
}
const validateInputs = () => {
  const nameValue = name.value.trim();
  const surnameValue = surname.value.trim();
  const usernameValue = username.value.trim();
  const emailValue = email.value.trim();
  const pwdValue = pwd.value.trim();
  const pwdValue2 = pwd2.value.trim();

  if (nameValue === "") {
    setError(name, 'Поле не может быть пустым');
  } else if (nameValue.length < 2) {
      setError(name, 'Поле не может быть короче 2 символов');
  } else if (nameValue.length > 14) {
      setError(name, 'Поле не может быть длиньше 14 символов');
  } else if (!isValidName(nameValue)) {
    setError(name, 'Неккоректные данные');
  } else {
    setSuccess(name)
  }
  

  if (surnameValue === "") {
    setError(surname, 'Поле не может быть пустым');
  } else if (surnameValue.length < 2) {
      setError(surname, 'Поле не может быть короче 2 символов');
  } else if (surnameValue.length > 14) {
      setError(surname, 'Поле не может быть длиньше 14 символов');
  } else if (!isValidName(surnameValue)) {
    setError(surname, 'Неккоректные данные');
  } else {
    setSuccess(surname)
  }


  if (usernameValue === "") {
    setError(username, 'Поле не может быть пустым');
  } else if (usernameValue.length < 3) {
  setError(username, 'Поле не может быть короче 3 символов');
  } else if (usernameValue.length > 10  ) {
    setError(username, 'Поле не может быть длиньше 10 символов');
  } else if (!isValidUsername(usernameValue)) {
    setError(username, 'Недопустимые символы');
  } else {
    setSuccess(username)
  }

  if (emailValue === "") {
    setError(email, 'Поле не может быть пустым');
  } else if (!isValidMail(emailValue)) {
  setError(email, 'Не корректно заданные данные');
  } else {
    setSuccess(email)
  }
}
}
