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

let editbutton = document.getElementById("find-edit");
let editform = document.querySelector("#edit-form");

editbutton.addEventListener("click", findbook);

function findbook() {
    let bookId = document.getElementById("find-input").value;

    fetch(`http://localhost/app/controllers/book_controller.php?action=showBookDetails&id=${bookId}`)
  .then(response => {
    if (!response.ok) {
      throw new Error('Book not found');
    }
    return response.json();
  })
  .then(data => {
    // Populate the edit form with the book details
    document.getElementById("edit-title").value = data.title;
    document.getElementById("edit-author").value = data.author;
    document.getElementById("edit-isbn").value = data.isbn;

    // Show the edit form
    editform.style.display = "flex";
  })
  .catch(error => {
    console.error('Error fetching book:', error);
  });
}

let AddSubmitB = document.querySelector(".Add-content .form-button[type='submit']");
let DeleteSubmitB = document.getElementById("find-delete");

