let user = document.querySelector("#username");
let password = document.querySelector("#password");

let Button = document.getElementById("loginButton");
let errorMessage = document.querySelector(".errorMessage");

Button.addEventListener("click", Login);

function Login() {
  let userValue = user.value;
  let passwordValue = password.value;

  if (userValue === "admin" && passwordValue === "admin") {
    window.location.href = "home.html";
  } else {
    errorMessage.innerHTML = "Invalid username or password";
    errorMessage.style.color = "red";
  }
}