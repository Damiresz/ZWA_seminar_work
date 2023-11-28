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

