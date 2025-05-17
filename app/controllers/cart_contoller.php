<?php
require_once __DIR__ . '/../models/cart_model.php';

class CartController {
    private $model;
    private $sessionId;

    public function __construct($db) {
        $this->model = new CartModel($db);
        $this->sessionId = session_id();
    }

    public function showCart() {
        $cartItems = $this->model->getCartItems($this->sessionId);
        $cartTotal = $this->model->getCartTotal($this->sessionId);
        
        include 'views/cart.php';
    }

    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = filter_input(INPUT_POST, 'cart_item_id', FILTER_VALIDATE_INT);
            $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
            
            if ($cartItemId && $quantity !== false) {
                $success = $this->model->updateCartItem($cartItemId, $quantity);
                echo json_encode(['success' => $success]);
                exit;
            }
        }
        echo json_encode(['success' => false]);
    }

    public function removeItem() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = filter_input(INPUT_POST, 'cart_item_id', FILTER_VALIDATE_INT);
            
            if ($cartItemId) {
                $success = $this->model->removeCartItem($cartItemId);
                echo json_encode(['success' => $success]);
                exit;
            }
        }
        echo json_encode(['success' => false]);
    }

    public function clearCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->model->clearCart($this->sessionId);
            echo json_encode(['success' => $success]);
            exit;
        }
        echo json_encode(['success' => false]);
    }

        public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $bookId = filter_var($data['book_id'] ?? null, FILTER_VALIDATE_INT);
            $quantity = filter_var($data['quantity'] ?? 1, FILTER_VALIDATE_INT);
            
            if ($bookId && $quantity > 0) {
                $success = $this->model->addToCart($this->sessionId, $bookId, $quantity);
                $cartCount = $this->model->getCartCount($this->sessionId);
                echo json_encode([
                    'success' => $success,
                    'cart_count' => $cartCount
                ]);
                exit;
            }
        }
        echo json_encode(['success' => false]);
    }
}
?>