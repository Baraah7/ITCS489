<?php
require_once __DIR__ . '/../config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['database']}",
        $config['db']['username'],
        $config['db']['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Add missing columns to orders table
    $alterQueries = [
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS email VARCHAR(255) AFTER user_id",
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS phone VARCHAR(50) AFTER email",
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS first_name VARCHAR(100) AFTER phone",
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS last_name VARCHAR(100) AFTER first_name",
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS address TEXT AFTER last_name",
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS apartment VARCHAR(100) AFTER address",
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS city VARCHAR(100) AFTER apartment",
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS postal_code VARCHAR(20) AFTER city",
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS country VARCHAR(100) AFTER postal_code",
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS payment_method VARCHAR(50) AFTER order_date",
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS is_guest BOOLEAN DEFAULT 0 AFTER status",
        "ALTER TABLE orders MODIFY COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
    ];

    foreach ($alterQueries as $query) {
        try {
            $pdo->exec($query);
            echo "Successfully executed: $query<br>";
        } catch (PDOException $e) {
            echo "Error executing query ($query): " . $e->getMessage() . "<br>";
        }
    }

    echo "Database update completed successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
