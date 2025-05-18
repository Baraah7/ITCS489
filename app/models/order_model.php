<?php
class Order {
    public $id, $user_id, $order_date, $total, $status;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        
        // Create orders table if it doesn't exist
        $this->createOrdersTable();
    }

    private function createOrdersTable() {
        $sql = "CREATE TABLE IF NOT EXISTS orders (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT NULL,
            email VARCHAR(255),
            phone VARCHAR(50),
            first_name VARCHAR(100),
            last_name VARCHAR(100),
            address TEXT,
            apartment VARCHAR(100),
            city VARCHAR(100),
            postal_code VARCHAR(20),
            country VARCHAR(100),
            status VARCHAR(50),
            order_date DATETIME,
            payment_method VARCHAR(50),
            is_guest BOOLEAN DEFAULT 0,
            total DECIMAL(10,2),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }public function getByUser($user_id) {
        // First get all orders for the user
        $stmt = $this->pdo->prepare("
            SELECT o.*, 
                   SUM(oi.quantity * oi.price) as total 
            FROM orders o 
            LEFT JOIN order_items oi ON o.id = oi.order_id 
            WHERE o.user_id = ? 
            GROUP BY o.id 
            ORDER BY o.order_date DESC
        ");
        $stmt->execute([$user_id]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // For each order, get its items with book details
        foreach ($orders as &$order) {
            $stmt = $this->pdo->prepare("
                SELECT oi.*, b.title, b.cover_image 
                FROM order_items oi 
                JOIN books b ON oi.book_id = b.id 
                WHERE oi.order_id = ?
            ");
            $stmt->execute([$order['id']]);
            $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $orders;
    }public function getActiveOrderByUser($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = ? AND status = 'pending' ORDER BY order_date DESC LIMIT 1");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, order_date, status) VALUES (?, NOW(), 'pending')");
        $stmt->execute([$data['user_id']]);
        return $this->pdo->lastInsertId();
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function createGuestOrder($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO orders (
                email, phone, first_name, last_name,
                address, apartment, city, postal_code, country,
                status, order_date, payment_method, is_guest
            ) VALUES (
                ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                'pending', NOW(), ?, 1
            )
        ");

        $stmt->execute([
            $data['email'],
            $data['phone'],
            $data['firstName'],
            $data['lastName'],
            $data['address'],
            $data['apartment'] ?? null,
            $data['city'],
            $data['postalCode'],
            $data['country'],
            $data['paymentMethod']
        ]);

        return $this->pdo->lastInsertId();
    }

    public function getGuestOrderById($orderId) {
        $stmt = $this->pdo->prepare("
            SELECT o.*, 
                   oi.*,
                   b.title,
                   b.cover_image
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN books b ON oi.book_id = b.id
            WHERE o.id = ? AND o.is_guest = 1
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrderTotal($orderId) {
        $stmt = $this->pdo->prepare("
            UPDATE orders o
            SET o.total = (
                SELECT SUM(oi.quantity * oi.price)
                FROM order_items oi
                WHERE oi.order_id = ?
            )
            WHERE o.id = ?
        ");
        return $stmt->execute([$orderId, $orderId]);
    }
}
?>