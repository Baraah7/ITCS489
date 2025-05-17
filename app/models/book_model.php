<?php
class BookModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getBookById($bookId) {
        $query = "SELECT b.*, b.author as author_name, c.name as genre_name 
                  FROM books b
                  LEFT JOIN categories c ON b.category_id = c.id
                  WHERE b.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$bookId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRelatedBooks($bookId, $categoryId, $limit = 4) {
        $query = "SELECT b.id, b.title, b.price, b.cover_image 
                  FROM books b
                  WHERE b.category_id = ? AND b.id != ?
                  LIMIT $limit";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$categoryId, $bookId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>