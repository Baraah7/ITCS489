<?php
class Database {
  private static $instance = null;
  private $connection;
  private function __construct() {
    try {
      // Enable error reporting for database connection issues
      error_reporting(E_ALL);
      ini_set('display_errors', 1);
      
      $config = require __DIR__ . '/../../config/database.php';
      
      // Verify config is loaded correctly
      if (!is_array($config) || !isset($config['host'], $config['database'], $config['username'])) {
          throw new Exception("Invalid database configuration");
      }
      
      // Log connection attempt
      error_log("Attempting to connect to database {$config['database']} on {$config['host']}");
      
      $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
      
      $this->connection = new PDO($dsn, $config['username'], $config['password'], [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false,
          // Add a timeout to avoid hanging
          PDO::ATTR_TIMEOUT => 5
      ]);
      
      error_log("Database connection successful");
    } catch(PDOException $e) {
      error_log("Connection failed: " . $e->getMessage());
      
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
  public static function connect() {
    try {
      if (self::$instance === null) {
        self::$instance = new self();
      }
      
      // Test the connection
      self::$instance->connection->query('SELECT 1');
      
      return self::$instance->connection;
    } catch (PDOException $e) {
      error_log("Database connection error: " . $e->getMessage());
      // Provide a user-friendly error message
      throw new Exception("Connection failed. Please check if MySQL is running and try again.");
    } catch (Exception $e) {
      error_log("General error: " . $e->getMessage());
      throw $e;
    }
  }

  public function getConnection() {
    return $this->connection;
  }
}