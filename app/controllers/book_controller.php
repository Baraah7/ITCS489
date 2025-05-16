<?php
require_once 'book_model.php';

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

        $relatedBooks = $this->model->getRelatedBooks($bookId, $book['genre_id']);
        
        include 'views/book_details.php';
    }
}
?>