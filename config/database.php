<?php
class database {
  private $host = 'localhost';
  private $db   = 'bookstore';
  private $user = 'root';
  private $pass = '';
  private $charset = 'utf8mb4';
  public $pdo;

  public function __construct() {
    $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
    try {
      $this->pdo = new PDO($dsn, $this->user, $this->pass);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Database connection failed: " . $e->getMessage());
    }
  }
}
?>