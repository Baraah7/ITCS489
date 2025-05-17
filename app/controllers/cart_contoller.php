<?php
require_once __DIR__ . '/../models/cart_model.php';

class CartController {
    private $model;
    private $sessionId;

    public function __construct($db) {
        $this->model = new CartModel($db);
        $this->sessionId = session_id();
    }

    private function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function showCart() {
        $cartItems = $this->model->getCartItems($this->sessionId);
        $cartTotal = $this->model->getCartTotal($this->sessionId);
        
        include __DIR__ . '/../views/cart.php';
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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request method']);
        }

        // Get JSON input
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid JSON data']);
        }

        $bookId = filter_var($data['book_id'] ?? null, FILTER_VALIDATE_INT);
        $quantity = filter_var($data['quantity'] ?? 1, FILTER_VALIDATE_INT);

        if (!$bookId || $quantity < 1) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid book ID or quantity']);
        }

        $success = $this->model->addToCart($this->sessionId, $bookId, $quantity);
        if ($success) {
            $cartItems = $this->model->getCartItems($this->sessionId);
            $cartCount = count($cartItems);
            $this->jsonResponse([
                'success' => true,
                'message' => 'Item added to cart successfully',
                'cart_count' => $cartCount
            ]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to add item to cart']);
        }
    }

    public function getCartCount() {
        $cartItems = $this->model->getCartItems($this->sessionId);
        $this->jsonResponse([
            'success' => true,
            'count' => count($cartItems)
        ]);
    }
}
?>