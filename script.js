let home = document.querySelector(".SideButton#home");
let homeContent = document.querySelector(".Home-content");

home.addEventListener("click", showHome);

function showHome() {
    console.log("Home button clicked");

    if (homeContent) {
        const currentDisplay = getComputedStyle(homeContent).display;

        homeContent.style.display = (currentDisplay === "none") ? "flex" : "none";
    }
}