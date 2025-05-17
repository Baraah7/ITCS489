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

    document.getElementById("edit-title").value = data.title;
    document.getElementById("edit-author").value = data.author;
    document.getElementById("edit-isbn").value = data.isbn;

    editform.style.display = "flex";
  })
  .catch(error => {
    console.error('Error fetching book:', error);
  });
}

let AddSubmitB = document.querySelector(".Add-content .form-button[type='submit']");

AddSubmitB.addEventListener("click", function(event) {
    event.preventDefault(); // Prevent the default form submission

    let title = document.getElementById("add-title").value;
    let author = document.getElementById("add-author  ").value;
    let stock = document.getElementById("add-stock").value;
    let price = document.getElementById("add-price").value;

    let formData = new FormData();
    formData.append("title", title);
    formData.append("author", author);
    formData.append("stock", stock);
    formData.append("price", price);
    formData.append("action", "addBook");
    fetch("http://localhost/app/controllers/book_controller.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        return response.json();
    })
    .then(data => {
        console.log("Book added:", data);
        // Optionally, you can reset the form or show a success message
        document.getElementById("add-form").reset();
    })
    .catch(error => {
        console.error("Error adding book:", error);
    });
})   

let DeleteSubmitB = document.getElementById("find-delete");
DeleteSubmitB.addEventListener("click", function(event) {
  event.preventDefault(); // Prevent the default form submission

  let bookId = document.getElementById("find-delete-input").value;

  fetch(`http://localhost/app/controllers/book_controller.php?action=deleteBook&id=${bookId}`, {
    method: 'DELETE'
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Book not found');
    }
      return response.json();
    })
    .then(data => {
      console.log('Book deleted:', data);
    })
    .catch(error => {
      console.error('Error deleting book:', error);
    });
});

