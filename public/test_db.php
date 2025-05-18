<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Load the configuration
    $config = require __DIR__ . '/../config/database.php';
    
    echo "Database Configuration:<br>";
    echo "Host: " . $config['host'] . "<br>";
    echo "Database: " . $config['database'] . "<br>";
    echo "Username: " . $config['username'] . "<br><br>";
    
    echo "Attempting to connect to MySQL...<br>";
    
    // Try to connect without selecting database first
    $pdo = new PDO(
        "mysql:host={$config['host']};charset={$config['charset']}", 
        $config['username'], 
        $config['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "Successfully connected to MySQL server.<br><br>";
    
    // Check if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE '{$config['database']}'");
    $exists = $stmt->fetchColumn();
    
    if (!$exists) {
        echo "Database '{$config['database']}' does not exist.<br>";
        echo "Attempting to create database...<br>";
        
        // Try to create the database
        $pdo->exec("CREATE DATABASE `{$config['database']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
        echo "Database created successfully.<br>";
        
        // Import the SQL file
        echo "Importing database structure and data...<br>";
        $sql = file_get_contents(__DIR__ . '/../database/itcs489.sql');
        if ($sql === false) {
            throw new Exception("Could not read SQL file");
        }
        
        $pdo->exec("USE `{$config['database']}`");
        $pdo->exec($sql);
        echo "Database structure and data imported successfully.<br>";
    } else {
        echo "Database '{$config['database']}' exists.<br>";
    }
    
    // Test connection to the specific database
    $dbPdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}", 
        $config['username'], 
        $config['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "Successfully connected to the database.<br>";
    
    // Test a simple query
    $stmt = $dbPdo->query("SELECT COUNT(*) FROM books");
    $count = $stmt->fetchColumn();
    echo "Number of books in database: " . $count . "<br>";
    
} catch (PDOException $e) {
    echo "<br>Database Error: " . $e->getMessage() . "<br>";
    echo "Error Code: " . $e->getCode() . "<br>";
} catch (Exception $e) {
    echo "<br>General Error: " . $e->getMessage() . "<br>";
}
