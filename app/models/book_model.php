<?php
class BookModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getBookById($bookId) {
        $query = "SELECT b.*, a.name as author_name, g.name as genre_name 
                  FROM books b
                  JOIN authors a ON b.author_id = a.id
                  JOIN genres g ON b.genre_id = g.id
                  WHERE b.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$bookId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRelatedBooks($bookId, $genreId, $limit = 4) {
        $query = "SELECT b.id, b.title, b.price, b.cover_image 
                  FROM books b
                  WHERE b.genre_id = ? AND b.id != ?
                  LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$genreId, $bookId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>