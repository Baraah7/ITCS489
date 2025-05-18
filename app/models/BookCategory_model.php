<?php
class BookCategory {
    public $book_id, $category_id;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getByBookId($book_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM book_categories WHERE book_id = ?");
        $stmt->execute([$book_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>