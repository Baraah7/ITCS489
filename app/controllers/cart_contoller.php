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
}
?>