<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../public/css/Admin.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

    <header>
        <div class="Sidebar">
            <p>Bagdad</p>
            <button class="SideButton" id="home"><img class="side-icon" src="../../public/Images/home_icon.png"></button>
            <button class="SideButton" id="edit"><img class="side-icon" src="../../public/Images/edit_icon.png"></button>
            <button class="SideButton" id="add"><img class="side-icon" src="../../public/Images/add_icon.png"></button>
            <button class="SideButton" id="delete"><img class="side-icon" src="../../public/Images/delete_icon.png"></button>
        </div>
        <h1>Dashboard</h1>
    </header>

    <main>
        <div class="Home-content">
            <p class="table-name">Recent Sales:</p>
            <table>
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Sold</th>
                        <th>Profit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($books) && is_array($books)): ?>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td data-label="Book ID"><?php echo htmlspecialchars($book['id']); ?></td>
                                <td data-label="Title"><?php echo htmlspecialchars($book['title']); ?></td>
                                <td data-label="Sold"><?php echo htmlspecialchars($book['sold']); ?></td>
                                <td data-label="Profit"><?php echo htmlspecialchars($book['profit']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No sales data available.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="Edit-content">
            <form id="input-form" class="form-container">
                <div class="form-group">
                    <label for="find">Book ID</label>
                    <input type="text" id="find-input" placeholder="Enter book id to Show">
                    <div id="form-container">
                        <button id="find-edit" type="button" class="form-button">Show</button>
                        <button type="reset" class="form-button">Cancel</button>
                    </div>
                </div>
            </form>

            <form class="form-container" id="edit-form">
                <label>Edit book information:</label> <br>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="edit-title" placeholder="Enter book title">
                </div>

                <div class="form-group">
                    <label for="author">Author</label>
                    <input type="text" id="edit-author" placeholder="Enter author's name">
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="edit-price" placeholder="Enter price" step="0.01">
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" id="edit-stock" placeholder="Enter stock quantity">
                </div>

                <div class="form-group">
                    <button type="submit" class="form-button">Submit</button>
                    <button type="reset" class="form-button">Cancel</button>
                </div>
            </form>
        </div>

        <div class="Add-content">
            <label>Add new book:</label> <br>
            <form class="form-container">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="add-title" placeholder="Enter book title">
                </div>

                <div class="form-group">
                    <label for="author">Author</label>
                    <input type="text" id="add-author" placeholder="Enter author's name">
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="add-price" placeholder="Enter price" step="0.01">
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" id="add-stock" placeholder="Enter stock quantity">
                </div>

                <div class="form-group">
                    <button type="submit" class="form-button">Submit</button>
                    <button type="reset" class="form-button">Cancel</button>
                </div>
            </form>
        </div>
        <div class="Delete-content">
            <form class="form-container">
                <div class="form-group">
                    <label for="find">Enter ID</label>
                    <input type="text" id="find" placeholder="Enter book ID to delete">
                </div>
                
                <div class="form-group">
                    <button id="find-delete" class="form-button">Delete</button>
                    <button type="reset" class="form-button">Cancel</button>
                </div>
            </form>
        </div>
    </main>

    <script src="../../public/js/Admin.js"></script>

</body>
</html>