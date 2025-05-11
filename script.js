let home = document.querySelector(".SideButton#home");
let edit = document.querySelector(".SideButton#edit");
let add = document.querySelector(".SideButton#add");
let remove = document.querySelector(".SideButton#delete");
let homeContent = document.querySelector(".Home-content");
let editContent = document.querySelector(".Edit-content");
let AddContent = document.querySelector(".Add-content");
let RemoveContent = document.querySelector(".Delete-content");

home.addEventListener("click", showHome);
edit.addEventListener("click", showEdit);
add.addEventListener("click", showAdd);
remove.addEventListener("click", showRemove);

function showHome() {
    homeContent.style.display ="flex";
    editContent.style.display = "none";
    AddContent.style.display = "none";
    RemoveContent.style.display = "none";
}

function showEdit() {
    homeContent.style.display ="none";
    editContent.style.display = "flex";
    AddContent.style.display = "none";
    RemoveContent.style.display = "none";
}

function showAdd() {
    homeContent.style.display ="none";
    editContent.style.display = "none";
    AddContent.style.display = "flex";
    RemoveContent.style.display = "none";
}

function showRemove() {
    homeContent.style.display ="none";
    editContent.style.display = "none";
    AddContent.style.display = "none";
    RemoveContent.style.display = "flex";
}
