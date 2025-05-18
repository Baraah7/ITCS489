<?php
class book_model {
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
    }    public function getAllBooks() {
        $query = "WITH RankedBooks AS (
                    SELECT b.*, c.name as genre_name,
                           ROW_NUMBER() OVER (PARTITION BY b.title, b.author ORDER BY b.id) as rn
                    FROM books b
                    LEFT JOIN categories c ON b.category_id = c.id
                  )
                  SELECT id, title, author, description, price, rating, stock, cover_image, 
                         created_at, category_id, genre_name
                  FROM RankedBooks
                  WHERE rn = 1
                  ORDER BY title";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createBook($data) {
        $query = "INSERT INTO books (title, author, description, price, cover_image, category_id) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $data['title'],
            $data['author'],
            $data['description'],
            $data['price'],
            $data['cover_image'],
            $data['category_id']
        ]);
    }

    public function updateBook($id, $data) {
        $query = "UPDATE books 
                  SET title = ?, author = ?, description = ?, price = ?, 
                      cover_image = ?, category_id = ?
                  WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $data['title'],
            $data['author'],
            $data['description'],
            $data['price'],
            $data['cover_image'],
            $data['category_id'],
            $id
        ]);
    }

    public function deleteBook($id) {
        $query = "DELETE FROM books WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }    public function searchBooks($query = '', $category = '', $author = '', $minPrice = null, $maxPrice = null, $year = null, $sort = 'relevance') {
        $conditions = [];
        $params = [];
        $orderBy = '';

        // Base query that selects only one book per title-author combination
        $sql = "WITH RankedBooks AS (
                    SELECT b.*, c.name as category,
                           ROW_NUMBER() OVER (PARTITION BY b.title, b.author ORDER BY b.id) as rn
                    FROM books b 
                    LEFT JOIN categories c ON b.category_id = c.id
                    WHERE b.title IS NOT NULL
                )
                SELECT id, title, author, description, price, rating, cover_image, 
                       created_at as publication_date, category
                FROM RankedBooks 
                WHERE rn = 1";// Ensure we get only valid entries

        // Add search conditions
        if (!empty($query)) {
            $conditions[] = "(b.title LIKE ? OR b.description LIKE ? OR b.author LIKE ?)";
            $searchTerm = "%$query%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if (!empty($category)) {
            $conditions[] = "c.name LIKE ?";
            $params[] = "%$category%";
        }

        if (!empty($author)) {
            $conditions[] = "b.author LIKE ?";
            $params[] = "%$author%";
        }

        if (!empty($minPrice)) {
            $conditions[] = "b.price >= ?";
            $params[] = $minPrice;
        }

        if (!empty($maxPrice)) {
            $conditions[] = "b.price <= ?";
            $params[] = $maxPrice;
        }

        if (!empty($year)) {
            $conditions[] = "YEAR(b.created_at) = ?";
            $params[] = $year;
        }

        // Add WHERE clause if there are conditions
        if (!empty($conditions)) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }

        // Add ORDER BY clause
        switch ($sort) {
            case 'price-low':
                $orderBy = " ORDER BY b.price ASC";
                break;
            case 'price-high':
                $orderBy = " ORDER BY b.price DESC";
                break;
            case 'title-asc':
                $orderBy = " ORDER BY b.title ASC";
                break;
            case 'title-desc':
                $orderBy = " ORDER BY b.title DESC";
                break;
            case 'newest':
                $orderBy = " ORDER BY b.created_at DESC";
                break;
            case 'rating':
                $orderBy = " ORDER BY b.rating DESC";
                break;
            default:
                // For relevance, if there's a search query, we want matches in title to come first
                if (!empty($query)) {
                    $orderBy = " ORDER BY 
                        CASE 
                            WHEN b.title LIKE ? THEN 1
                            WHEN b.author LIKE ? THEN 2
                            ELSE 3
                        END";
                    $params[] = "%$query%";
                    $params[] = "%$query%";
                } else {
                    $orderBy = " ORDER BY b.title ASC";
                }
                break;
        }

        $sql .= $orderBy;

        try {
            error_log("Executing search query: " . $sql);
            error_log("With parameters: " . print_r($params, true));
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            error_log("Found " . count($results) . " results");
            return $results;
        } catch (PDOException $e) {
            error_log("Search query error: " . $e->getMessage());
            error_log("SQL: " . $sql);
            error_log("Params: " . print_r($params, true));
            return [];
        }
    }
}
?>