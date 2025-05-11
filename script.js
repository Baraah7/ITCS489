let home = document.querySelector(".SideButton#home");
let homeContent = document.getElementsByClassName("home-content");

let showHome = home.addEventListener(onclick);

function showHome() {
    console.log("Home button clicked");
  if (homeContent.style.display === "none") {
        homeContent.style.display = "flex";
    } else {
        homeContent.style.display = "none";
    }
}