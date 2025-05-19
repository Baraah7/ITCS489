<?php
require_once __DIR__ . '/../models/book_model.php';

class BookController {
    private $bookModel;

    public function __construct($db) {
        $this->bookModel = new book_model($db);
    }

    public function index() {
        $books = $this->bookModel->getAllBooks();
        include 'views/books/index.php';
    }    public function show($id) {
        $book = $this->bookModel->getBookById($id);
        $categoryId = $book['category_id'] ?? null;
        $relatedBooks = $categoryId ? $this->bookModel->getRelatedBooks($id, $categoryId) : [];
        include __DIR__ . '/../views/book.php';
    }

    public function create() {
        include 'views/books/create.php';
    }

    public function store($data) {
        $this->bookModel->createBook($data);
        header('Location: index.php?controller=book&action=index');
    }

    public function adminDashboard() {
        $books = $this->bookModel->getRecentSales(5);
        include __DIR__ . '/../views/Admin.php';
    }

    public function edit($id) {
        $book = $this->bookModel->getBookById($id);
        include 'views/books/edit.php';
    }

    public function update($id, $data) {
        $this->bookModel->updateBook($id, $data);
        header('Location: index.php?controller=book&action=index');
    }

    public function delete($id) {
        $this->bookModel->deleteBook($id);
        header('Location: index.php?controller=book&action=index');
    }

    public function showBookDetails($id) {
        // For backward compatibility, internally use show()
        return $this->show($id);
    }
}
