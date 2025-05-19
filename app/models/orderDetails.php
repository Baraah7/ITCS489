<?php
class orderDetails {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Create a new order (for registered or guest users)
    public function createOrder($userId, $email, $phone, $firstName, $lastName, $address, $apartment, $city, $postalCode, $country, $paymentMethod, $status, $isGuest) {
        $query = "INSERT INTO orders (user_id, email, phone, first_name, last_name, address, apartment, city, postal_code, country, payment_method, status, is_guest, order_date) 
                  VALUES (:user_id, :email, :phone, :first_name, :last_name, :address, :apartment, :city, :postal_code, :country, :payment_method, :status, :is_guest, NOW())";
        
        $stmt = $this->db->prepare($query);
        
        // For guest orders, explicitly set user_id to NULL
        if ($isGuest) {
            $stmt->bindValue(':user_id', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':user_id', $userId);
        }
        
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':apartment', $apartment);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':postal_code', $postalCode);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':payment_method', $paymentMethod);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':is_guest', $isGuest, PDO::PARAM_BOOL);

        return $stmt->execute();
    }

    // Get order details by order_id
    public function getOrder($orderId) {
        $query = "SELECT * FROM orders WHERE id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all orders for a specific user (registered users only)
    public function getOrdersByUserId($userId) {
        $query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all guest orders (is_guest = 1)
    public function getGuestOrders() {
        $query = "SELECT * FROM orders_new WHERE is_guest = 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update the status of an order
    public function updateOrderStatus($orderId, $status) {
        $query = "UPDATE orders SET status = :status WHERE id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':order_id', $orderId);
        
        return $stmt->execute();
    }

    // Add item to an order
    public function addOrderItem($orderId, $bookId, $quantity, $price) {
        $query = "INSERT INTO order_items (order_id, book_id, quantity, price) 
                  VALUES (:order_id, :book_id, :quantity, :price)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->bindParam(':book_id', $bookId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);

        return $stmt->execute();
    }

    // Get all items for an order
    public function getOrderItems($orderId) {
        $query = "SELECT oi.*, b.title, b.cover_image 
                 FROM order_items oi
                 JOIN books b ON oi.book_id = b.id
                 WHERE oi.order_id = :order_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Calculate order total
    public function calculateOrderTotal($orderId) {
        $query = "SELECT SUM(quantity * price) as total 
                 FROM order_items 
                 WHERE order_id = :order_id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    // Get order with items
    public function getOrderWithItems($orderId) {
        $order = $this->getOrder($orderId);
        if ($order) {
            $order['items'] = $this->getOrderItems($orderId);
            $order['total'] = $this->calculateOrderTotal($orderId);
        }
        return $order;
    }
}
?>
