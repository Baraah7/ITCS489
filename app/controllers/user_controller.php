<?php 

require_once __DIR__ . '/../models/user_model.php';

class UserController {
    private $db;

    public function __construct($db = null) {
        $this->db = $db;
        // Start the session if it's not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
        include __DIR__ . '/../views/user/login.php';
    }

    // API endpoint for AJAX login (expects JSON, returns JSON)
    public function apiAuthenticate() {
        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        $username = $input['username'] ?? '';
        $password = $input['password'] ?? '';

        $user = User::authenticate($username, $password);

        header('Content-Type: application/json');
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            echo json_encode([
                'success' => true,
                'role' => $user['is_admin'] ? 'admin' : 'user'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid username or password'
            ]);
        }
        exit;
    }

    public function authenticate($email, $password) {
        $user = User::authenticate($email, $password);
        if ($user) {
            // Set user session data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            // Convert guest order if exists
            $this->convertGuestOrder($user['id']);
            
            // Redirect to home page
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['error'] = 'Invalid email or password';
            header('Location: index.php?route=login');
            exit;
        }
    }

    public function logout() {
        // Clear all session data except guest order
        $guestOrder = $_SESSION['guest_order'] ?? null;
        session_destroy();
        session_start();
        if ($guestOrder) {
            $_SESSION['guest_order'] = $guestOrder;
        }
        
        // Redirect to home page
        header('Location: index.php');
        exit;
    }

    private function convertGuestOrder($userId) {
        if (isset($_SESSION['guest_order']) && !empty($_SESSION['guest_order']['items'])) {
            try {
                // Create new order
                $orderId = $this->orderModel->create([
                    'user_id' => $userId
                ]);

                // Add items from guest order
                foreach ($_SESSION['guest_order']['items'] as $item) {
                    $this->orderItemModel->addItem([
                        'order_id' => $orderId,
                        'book_id' => $item['book_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    ]);
                }

                // Clear guest order
                unset($_SESSION['guest_order']);
                $_SESSION['success'] = 'Your guest order has been added to your account!';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Error converting guest order: ' . $e->getMessage();
            }
        }
    }

    public function register() {
        include 'views/users/register.php';
    }

    public function store($data) {
        User::create($data);
        header('Location: index.php?controller=user&action=login');
    }
}
?>