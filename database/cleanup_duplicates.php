<?php
require_once __DIR__ . '/../app/core/database.php';

try {
    $db = Database::connect();
    
    // Start transaction
    $db->beginTransaction();

    // Step 1: Create a temporary table to store unique books
    $db->query("CREATE TEMPORARY TABLE unique_books AS
                SELECT MIN(id) as id, title, author, description, price, rating, stock, cover_image, category_id
                FROM books
                GROUP BY title, author");

    // Step 2: Delete all books
    $db->query("DELETE FROM books");

    // Step 3: Reinsert only unique books
    $db->query("INSERT INTO books (id, title, author, description, price, rating, stock, cover_image, category_id)
                SELECT id, title, author, description, price, rating, stock, cover_image, category_id
                FROM unique_books");

    // Step 4: Add unique constraint
    $db->query("ALTER TABLE books ADD CONSTRAINT unique_book UNIQUE (title, author)");

    // Commit transaction
    $db->commit();
    
    echo "Successfully removed duplicate books!\n";
    
} catch (Exception $e) {
    // Rollback transaction on error
    if (isset($db)) {
        $db->rollBack();
    }
    echo "Error: " . $e->getMessage() . "\n";
}
?>
