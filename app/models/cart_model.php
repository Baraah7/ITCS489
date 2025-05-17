<?php
class CartModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getCartItems($sessionId) {
        $query = "SELECT ci.id as cart_item_id, b.id as book_id, b.title, b.price, b.cover_image, 
                         ci.quantity, (b.price * ci.quantity) as subtotal
                  FROM cart_items ci
                  JOIN books b ON ci.book_id = b.id
                  WHERE ci.session_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$sessionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCartTotal($sessionId) {
        $query = "SELECT SUM(b.price * ci.quantity) as total
                  FROM cart_items ci
                  JOIN books b ON ci.book_id = b.id
                  WHERE ci.session_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$sessionId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    public function updateCartItem($cartItemId, $quantity) {
        if ($quantity <= 0) {
            $query = "DELETE FROM cart_items WHERE id = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$cartItemId]);
        } else {
            $query = "UPDATE cart_items SET quantity = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$quantity, $cartItemId]);
        }
    }

    public function removeCartItem($cartItemId) {
        $query = "DELETE FROM cart_items WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$cartItemId]);
    }

    public function clearCart($sessionId) {
        $query = "DELETE FROM cart_items WHERE session_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$sessionId]);
    }

    public function addToCart($sessionId, $bookId, $quantity = 1) {
        try {
            // Check if the book exists
            $query = "SELECT id FROM books WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$bookId]);
            if (!$stmt->fetch()) {
                return false;
            }

            // Check if item already exists in cart
            $query = "SELECT id, quantity FROM cart_items WHERE session_id = ? AND book_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$sessionId, $bookId]);
            $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingItem) {
                // Update quantity if item exists
                $newQuantity = $existingItem['quantity'] + $quantity;
                $query = "UPDATE cart_items SET quantity = ? WHERE id = ?";
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$newQuantity, $existingItem['id']]);
            } else {
                // Add new item if it doesn't exist
                $query = "INSERT INTO cart_items (session_id, book_id, quantity) VALUES (?, ?, ?)";
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$sessionId, $bookId, $quantity]);
            }
        } catch (PDOException $e) {
            error_log("Error adding to cart: " . $e->getMessage());
            return false;
        }
    }
}
?>