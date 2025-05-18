<?php
class OrderItem {
    public $id, $order_id, $book_id, $quantity, $price;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        
        // Create order_items table if it doesn't exist
        $this->createOrderItemsTable();
    }

    private function createOrderItemsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS order_items (
            id INT PRIMARY KEY AUTO_INCREMENT,
            order_id INT,
            book_id INT,
            quantity INT,
            price DECIMAL(10,2),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (order_id) REFERENCES orders(id),
            FOREIGN KEY (book_id) REFERENCES books(id)
        )";
        $this->pdo->exec($sql);
    }

    public function getByOrder($order_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addItem($data) {
        // Get book price
        $stmt = $this->pdo->prepare("SELECT price FROM books WHERE id = ?");
        $stmt->execute([$data['book_id']]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$book) {
            throw new Exception("Book not found");
        }

        // Check if item already exists in order
        $stmt = $this->pdo->prepare("SELECT * FROM order_items WHERE order_id = ? AND book_id = ?");
        $stmt->execute([$data['order_id'], $data['book_id']]);
        $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingItem) {
            // Update quantity if item exists
            $stmt = $this->pdo->prepare("UPDATE order_items SET quantity = quantity + ? WHERE order_id = ? AND book_id = ?");
            $stmt->execute([$data['quantity'], $data['order_id'], $data['book_id']]);
        } else {
            // Insert new item with book price
            $stmt = $this->pdo->prepare("INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$data['order_id'], $data['book_id'], $data['quantity'], $book['price']]);
        }

        // Update order total
        $stmt = $this->pdo->prepare("UPDATE orders SET total = (SELECT SUM(quantity * price) FROM order_items WHERE order_id = ?) WHERE id = ?");
        $stmt->execute([$data['order_id'], $data['order_id']]);
    }
}
?>