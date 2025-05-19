<?php
require_once __DIR__ . '/../config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['database']}",
        $config['db']['username'],
        $config['db']['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Drop existing foreign key if it exists
    try {
        $pdo->exec("ALTER TABLE orders DROP FOREIGN KEY orders_ibfk_1");
        echo "Dropped existing foreign key constraint<br>";
    } catch (PDOException $e) {
        // Ignore if constraint doesn't exist
    }

    // Create modified orders table
    $createTable = "CREATE TABLE IF NOT EXISTS orders (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        address TEXT NOT NULL,
        apartment VARCHAR(100),
        city VARCHAR(100) NOT NULL,
        postal_code VARCHAR(20) NOT NULL,
        country VARCHAR(100) NOT NULL,
        payment_method VARCHAR(50) NOT NULL,
        status VARCHAR(50) NOT NULL DEFAULT 'pending',
        order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        is_guest BOOLEAN DEFAULT 0,
        total DECIMAL(10,2) DEFAULT 0.00,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($createTable);
    echo "orders table structure updated successfully!<br>";

    // Add foreign key only for registered users
    $addForeignKey = "ALTER TABLE orders 
                      ADD CONSTRAINT orders_user_fk 
                      FOREIGN KEY (user_id) 
                      REFERENCES users(id)
                      ON DELETE SET NULL";
    
    try {
        $pdo->exec($addForeignKey);
        echo "Added new foreign key constraint with SET NULL on delete<br>";
    } catch (PDOException $e) {
        echo "Note: Foreign key already exists or users table not found<br>";
    }

    // Make sure order_items table exists with correct structure
    $createItemsTable = "CREATE TABLE IF NOT EXISTS order_items (
        id INT PRIMARY KEY AUTO_INCREMENT,
        order_id INT NOT NULL,
        book_id INT NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
        FOREIGN KEY (book_id) REFERENCES books(id)
    )";

    $pdo->exec($createItemsTable);
    echo "order_items table structure updated successfully!<br>";

    echo "Database setup completed successfully!";
} catch (PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>
