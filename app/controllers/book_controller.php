<?php
require_once __DIR__ . '/../models/book_model.php';


class BookController {
    private $model;

    public function __construct($db) {
        $this->model = new BookModel($db);
    }

    public function showBookDetails($bookId) {
        $book = $this->model->getBookById($bookId);
        
        if (!$book) {
            // Handle book not found
            header("HTTP/1.0 404 Not Found");
            include 'views/404.php';
            exit();
        }

        // Use category_id instead of genre_id, and handle missing/null category_id
        $categoryId = isset($book['category_id']) ? $book['category_id'] : null;
        $relatedBooks = [];
        if ($categoryId !== null) {
            $relatedBooks = $this->model->getRelatedBooks($bookId, $categoryId);
        }
        
        include __DIR__ . '/../views/book.php';
    }
}
?>
