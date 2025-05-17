<?php
class Database {
    private $host = 'localhost';
    private $db   = 'bookstore';   //  database name
    private $user = 'root';        // default XAMPP user
    private $pass = '';            // default XAMPP password is empty
    private $charset = 'utf8mb4';

    public function connect() {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            return new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
?>