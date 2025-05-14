let home = document.querySelector(".SideButton#home");
let edit = document.querySelector(".SideButton#edit");
let add = document.querySelector(".SideButton#add");
let remove = document.querySelector(".SideButton#delete");

let homeContent = document.querySelector(".Home-content");
let editContent = document.querySelector(".Edit-content");
let AddContent = document.querySelector(".Add-content");
let RemoveContent = document.querySelector(".Delete-content");

// Adding event listeners
home.addEventListener("click", () => showSection(homeContent));
edit.addEventListener("click", () => showSection(editContent));
add.addEventListener("click", () => showSection(AddContent));
remove.addEventListener("click", () => showSection(RemoveContent));

function showSection(sectionToShow) {
    // Hide all sections
    const allSections = [homeContent, editContent, AddContent, RemoveContent];
    allSections.forEach(section => section.style.display = "none");

    // Show the selected section
    sectionToShow.style.display = "flex";
}

let editbutton = document.getElementById("find-edit");
let editform = document.querySelector("#edit-form");

editbutton.addEventListener("click", findbook);

function findbook() {
    editform.style.display = "flex";
}
