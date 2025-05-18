let user = document.querySelector("#username");
let password = document.querySelector("#password");

let Button = document.getElementById("loginButton");
let errorMessage = document.querySelector("#errorMessage");

Button.addEventListener("click", Login);

function Login() {
  let userValue = user.value.trim();
  let passwordValue = password.value.trim();

  if (userValue === "" || passwordValue === "") {
    errorMessage.textContent = "Please enter both username and password.";
    errorMessage.style.color = "red";
    return;
  }

  fetch("../../app/controllers/user_controller.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      username: userValue,
      password: passwordValue,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        if (data.role === "admin") {
          window.location.href = "../views/Admin.html";
        } else {
          window.location.href = "../views/mainPage.php";
        }
      } else {
        errorMessage.textContent = data.message || "Login failed.";
        errorMessage.style.color = "red";
      }
    })
    .catch((error) => {
      console.error("Login error:", error);
      errorMessage.textContent = "An error occurred. Please try again.";
      errorMessage.style.color = "red";
    });
}
