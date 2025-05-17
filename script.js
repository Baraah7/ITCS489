let user = document.querySelector(".input#username");
let password = document.querySelector(".input#password");

let loginButton = document.querySelector(".loginButton");
let errorMessage = document.querySelector(".errorMessage");

loginButton.addEventListener("click", Login);

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