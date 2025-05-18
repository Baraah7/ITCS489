let home = document.querySelector(".SideButton#home");
let edit = document.querySelector(".SideButton#edit");
let add = document.querySelector(".SideButton#add");
let remove = document.querySelector(".SideButton#delete");

let homeContent = document.querySelector(".Home-content");
let editContent = document.querySelector(".Edit-content");
let AddContent = document.querySelector(".Add-content");
let RemoveContent = document.querySelector(".Delete-content");

home.addEventListener("click", () => showSection(homeContent));
edit.addEventListener("click", () => showSection(editContent));
add.addEventListener("click", () => showSection(AddContent));
remove.addEventListener("click", () => showSection(RemoveContent));

function showSection(sectionToShow) {

    const allSections = [homeContent, editContent, AddContent, RemoveContent];
    allSections.forEach(section => section.style.display = "none");

    sectionToShow.style.display = "flex";
}

document.addEventListener("DOMContentLoaded", () => {
  // ADD BOOK
  document.querySelector(".Add-content form").addEventListener("submit", function (e) {
    e.preventDefault();
    const title = document.getElementById("add-title").value;
    const author = document.getElementById("add-author").value;
    const price = document.getElementById("add-price").value;
    const stock = document.getElementById("add-stock").value;

    fetch("index.php?controller=book&action=add", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ title, author, price, stock })
    })
    .then(res => res.json())
    .then(data => alert(data.message || "Book added!"))
    .catch(err => alert("Error adding book"));
  });

  // EDIT BOOK
  document.getElementById("edit-form").addEventListener("submit", function (e) {
    e.preventDefault();
    const id = document.getElementById("find-input").value;
    const title = document.getElementById("edit-title").value;
    const author = document.getElementById("edit-author").value;
    const price = document.getElementById("edit-price").value;
    const stock = document.getElementById("edit-stock").value;

    fetch("index.php?controller=book&action=edit", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id, title, author, price, stock })
    })
    .then(res => res.json())
    .then(data => alert(data.message || "Book updated!"))
    .catch(err => alert("Error editing book"));
  });

  // DELETE BOOK
  document.getElementById("find-delete").addEventListener("click", function (e) {
    e.preventDefault();
    const id = document.getElementById("find").value;

    if (!id) {
      alert("Please enter a Book ID.");
      return;
    }

    fetch("index.php?controller=book&action=delete", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id })
    })
    .then(res => res.json())
    .then(data => alert(data.message || "Book deleted!"))
    .catch(err => alert("Error deleting book"));
  });

  // FIND BOOK FOR EDIT
  document.getElementById("find-edit").addEventListener("click", function () {
    const id = document.getElementById("find-input").value;

    if (!id) {
      alert("Enter a Book ID to look up.");
      return;
    }

    fetch(`index.php?controller=book&action=getBookById&id=${id}`)
      .then(res => res.json())
      .then(book => {
        if (book) {
          document.getElementById("edit-title").value = book.title || "";
          document.getElementById("edit-author").value = book.author || "";
          document.getElementById("edit-price").value = book.price || "";
          document.getElementById("edit-stock").value = book.stock || "";
        } else {
          alert("Book not found.");
        }
      })
      .catch(err => alert("Error fetching book data"));
  });
});


