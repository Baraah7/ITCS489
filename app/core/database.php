<?php
class Database {
  public static function connect() {
    try {
      $config = require __DIR__ . '/../../config/config.php';
      $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
        $config['username'],
        $config['password'],
        [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false
        ]
      );
      return $pdo;
    } catch (PDOException $e) {
      // Log the error
      error_log("Database connection failed: " . $e->getMessage());
      
      // Send clean error response for AJAX requests
      if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
      }
      
      // For normal requests, show a user-friendly error
      die("Connection failed. Please try again later.");
    }
  }
}