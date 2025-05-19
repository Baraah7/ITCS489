<?php
require_once __DIR__ . '/../config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['database']}",
        $config['db']['username'],
        $config['db']['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the orders_new table
    $createTable = "CREATE TABLE IF NOT EXISTS orders_new (
        order_id INT PRIMARY KEY AUTO_INCREMENT,
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
        is_guest BOOLEAN DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    $pdo->exec($createTable);
    echo "orders_new table created successfully!<br>";

    // Create order_items_new table
    $createItemsTable = "CREATE TABLE IF NOT EXISTS order_items_new (
        item_id INT PRIMARY KEY AUTO_INCREMENT,
        order_id INT NOT NULL,
        book_id INT NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES orders_new(order_id),
        FOREIGN KEY (book_id) REFERENCES books(id)
    )";

    $pdo->exec($createItemsTable);
    echo "order_items_new table created successfully!<br>";

    // Transfer data from old tables if they exist
    try {
        $pdo->beginTransaction();

        // Check if old tables exist
        $checkOldTable = $pdo->query("SHOW TABLES LIKE 'orders'");
        if ($checkOldTable->rowCount() > 0) {
            // Transfer orders
            $pdo->exec("INSERT IGNORE INTO orders_new (
                order_id, user_id, email, phone, first_name, last_name,
                address, apartment, city, postal_code, country,
                payment_method, status, is_guest, created_at
            )
            SELECT 
                id, user_id, email, phone, first_name, last_name,
                address, apartment, city, postal_code, country,
                payment_method, status, is_guest, created_at
            FROM orders");

            // Transfer order items
            $pdo->exec("INSERT IGNORE INTO order_items_new (
                order_id, book_id, quantity, price, created_at
            )
            SELECT 
                order_id, book_id, quantity, price, created_at
            FROM order_items");

            echo "Data transferred from old tables successfully!<br>";
        }

        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error transferring data: " . $e->getMessage() . "<br>";
    }

    echo "Database setup completed successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
