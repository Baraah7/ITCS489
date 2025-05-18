<?php
require_once __DIR__ . '/../models/book_model.php';

class SearchAPI {
    private $bookModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->bookModel = new book_model($db);
    }    public function search() {
        // Set headers for JSON response and CORS
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET');

        try {
            // Debug request info
            error_log("Search API Request:");
            error_log("GET params: " . print_r($_GET, true));

            // Get and validate search parameters
            $query = isset($_GET['q']) ? trim($_GET['q']) : '';
            $category = isset($_GET['category']) ? trim($_GET['category']) : '';
            $author = isset($_GET['author']) ? trim($_GET['author']) : '';
            $minPrice = !empty($_GET['minPrice']) ? floatval($_GET['minPrice']) : null;
            $maxPrice = !empty($_GET['maxPrice']) ? floatval($_GET['maxPrice']) : null;
            $year = !empty($_GET['year']) ? intval($_GET['year']) : null;
            $sort = isset($_GET['sort']) ? trim($_GET['sort']) : 'relevance';

            // Get search results
            $results = $this->bookModel->searchBooks($query, $category, $author, $minPrice, $maxPrice, $year, $sort);

            // Format the results
            $formattedResults = array_map(function($book) {
                return [
                    'id' => $book['id'],
                    'title' => $book['title'],
                    'author' => $book['author'],
                    'description' => $book['description'],
                    'price' => (float)$book['price'],
                    'cover' => $book['cover_image'],
                    'category' => $book['category'],
                    'rating' => isset($book['rating']) ? (float)$book['rating'] : null,
                    'year' => isset($book['publication_date']) ? date('Y', strtotime($book['publication_date'])) : null
                ];
            }, $results);

            // Debug response info
            error_log("Search API Response:");
            error_log("Number of results: " . count($formattedResults));

            // Return JSON response
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'books' => $formattedResults,
                'total' => count($formattedResults),
                'query' => [
                    'search' => $query,
                    'category' => $category,
                    'author' => $author,
                    'minPrice' => $minPrice,
                    'maxPrice' => $maxPrice,
                    'year' => $year,
                    'sort' => $sort
                ]
            ]);
        } catch (Exception $e) {
            error_log("Search API Error: " . $e->getMessage());
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'An error occurred while searching',
                'debug_message' => $e->getMessage()
            ]);
        }
        exit;
    }
}