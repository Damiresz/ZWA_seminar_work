// forgot password
const forgot_block = document.querySelector(".forgot-pass__block");
const forgot_btn = document.querySelector(".forgot_pas");
const forgot_close = document.querySelector(".close");

forgot_btn.onclick = () => {
  forgot_block.classList.add("active");
};

forgot_close.onclick = () => {
  forgot_block.classList.remove("active");
};