const forgot_block = document.querySelector(".forgot-pass__block");
const forgot_btn = document.querySelector("#forgot_password");
const forgot_close = document.querySelector(".close")

forgot_btn.onclick = () => {
  forgot_block.classList.toggle("active");
};

forgot_close.onclick = () => {
  forgot_block.classList.remove("active");
};