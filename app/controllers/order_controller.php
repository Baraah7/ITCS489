<?php
require_once __DIR__ . '/../models/order_model.php';
require_once __DIR__ . '/../models/orderItem_model.php';
require_once __DIR__ . '/../core/EmailHelper.php';

class OrderController {
    private $db;
    private $orderModel;
    private $orderItemModel;

    public function __construct($db) {
        $this->db = $db;
        $this->orderModel = new Order($db);
        $this->orderItemModel = new OrderItem($db);
    }    public function index() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Debug information
        error_log('Order Controller - Index method called');
        error_log('Session user_id: ' . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Not set'));
        error_log('Guest order items: ' . (isset($_SESSION['guest_order']) ? count($_SESSION['guest_order']['items']) : 'No guest order'));
        
        // Initialize orders array
        $orders = [];
        
        if (isset($_SESSION['user_id'])) {
            // For logged in users, get their orders from database
            $orders = $this->orderModel->getByUser($_SESSION['user_id']);
            error_log('User orders count: ' . count($orders));
        }

        // Use getBaseDir() to get the base directory path
        $basePath = $this->getBaseDir();
        $viewPath = $basePath . '/app/views/order.php';
        error_log('Loading view from: ' . $viewPath);
        
        if (!file_exists($viewPath)) {
            error_log('Error: Order view file not found at: ' . $viewPath);
            echo 'Error loading order view';
            return;
        }

        // Include the view
        include $viewPath;
    }

    private function getBaseDir() {
        // Go up one level from the controllers directory to get the app root
        return dirname(dirname(__DIR__));
    }

    public function show($id) {
        $order = Order::getById($id);
        include 'views/orders/show.php';
    }

    public function store($data) {
        $orderId = Order::create($data);
        header("Location: index.php?controller=order&action=show&id=$orderId");
    }

    public function delete($id) {
        Order::delete($id);
        header('Location: index.php?controller=order&action=index');
    }    public function addToOrder() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Get book_id and quantity from POST data
        $book_id = $_POST['book_id'] ?? null;
        $quantity = intval($_POST['quantity'] ?? 1);
        
        // Check if this is an AJAX request
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if (!$book_id || $quantity < 1) {
            if ($isAjax) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid book or quantity'
                ]);
                exit;
            } else {
                $_SESSION['error'] = 'Invalid book or quantity';
                header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/ITCS489/public/index.php');
                exit;
            }
        }

        try {
            // If user is not logged in, store in session
            if (!isset($_SESSION['user_id'])) {
                if (!isset($_SESSION['guest_order'])) {
                    $_SESSION['guest_order'] = [
                        'items' => [],
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }

                // Check if book already exists in guest order
                $found = false;
                foreach ($_SESSION['guest_order']['items'] as &$item) {
                    if ($item['book_id'] == $book_id) {
                        $item['quantity'] += $quantity;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    // Get book details
                    $stmt = $this->db->prepare("SELECT title, price, cover_image FROM books WHERE id = ?");
                    $stmt->execute([$book_id]);
                    $book = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$book) {
                        if ($isAjax) {
                            echo json_encode([
                                'success' => false,
                                'message' => 'Book not found'
                            ]);
                            exit;
                        } else {
                            $_SESSION['error'] = 'Book not found';
                            header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/ITCS489/public/index.php');
                            exit;
                        }
                    }

                    $_SESSION['guest_order']['items'][] = [
                        'book_id' => $book_id,
                        'quantity' => $quantity,
                        'price' => $book['price'],
                        'title' => $book['title'],
                        'cover_image' => $book['cover_image']
                    ];
                }
            } else {
                // Regular user order process
                $activeOrder = $this->orderModel->getActiveOrderByUser($_SESSION['user_id']);
                
                if (!$activeOrder) {
                    // Create new order
                    $orderId = $this->orderModel->create([
                        'user_id' => $_SESSION['user_id']
                    ]);
                } else {
                    $orderId = $activeOrder['id'];
                }

                // Add item to order
                $this->orderItemModel->addItem([
                    'order_id' => $orderId,
                    'book_id' => $book_id,
                    'quantity' => $quantity
                ]);
            }

            // Get the updated cart count
            $cartCount = 0;
            if (!isset($_SESSION['user_id'])) {
                foreach ($_SESSION['guest_order']['items'] as $item) {
                    $cartCount += $item['quantity'];
                }
            } else {
                $activeOrder = $this->orderModel->getActiveOrderByUser($_SESSION['user_id']);
                if ($activeOrder) {
                    $orderItems = $this->orderItemModel->getByOrder($activeOrder['id']);
                    foreach ($orderItems as $item) {
                        $cartCount += $item['quantity'];
                    }
                }
            }

            if ($isAjax) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Book added to cart successfully',
                    'count' => $cartCount
                ]);
            } else {
                $_SESSION['success'] = 'Book added to cart successfully';
                header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/ITCS489/public/index.php');
            }
            
        } catch (Exception $e) {
            if ($isAjax) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error adding book to cart: ' . $e->getMessage()
                ]);
            } else {
                $_SESSION['error'] = 'Error adding book to cart: ' . $e->getMessage();
                header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/ITCS489/public/index.php');
            }
        }
        exit;
    }

    public function updateGuestOrder() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['guest_order']) || !isset($_POST['index']) || !isset($_POST['quantity'])) {
            $_SESSION['error'] = 'Invalid update request';
            header('Location: /ITCS489/public/index.php?route=orders');
            exit;
        }

        $index = intval($_POST['index']);
        $quantity = intval($_POST['quantity']);

        if ($quantity < 1 || $quantity > 99) {
            $_SESSION['error'] = 'Invalid quantity';
            header('Location: /ITCS489/public/index.php?route=orders');
            exit;
        }

        if (isset($_SESSION['guest_order']['items'][$index])) {
            $_SESSION['guest_order']['items'][$index]['quantity'] = $quantity;
            $_SESSION['success'] = 'Order updated successfully';
        }

        header('Location: /ITCS489/public/index.php?route=orders');
        exit;
    }

    public function removeFromGuestOrder() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['guest_order']) || !isset($_POST['index'])) {
            $_SESSION['error'] = 'Invalid remove request';
            header('Location: /ITCS489/public/index.php?route=orders');
            exit;
        }

        $index = intval($_POST['index']);

        if (isset($_SESSION['guest_order']['items'][$index])) {
            unset($_SESSION['guest_order']['items'][$index]);
            // Reindex the array to prevent holes
            $_SESSION['guest_order']['items'] = array_values($_SESSION['guest_order']['items']);
            $_SESSION['success'] = 'Item removed from order';
        }

        header('Location: /ITCS489/public/index.php?route=orders');
        exit;
    }

    public function guestCheckout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['guest_order']) || empty($_SESSION['guest_order']['items'])) {
            $_SESSION['error'] = 'No items in your order';
            header('Location: /ITCS489/public/index.php?route=orders');
            exit;
        }

        include __DIR__ . '/../views/checkout.php';
    }

    public function processCheckout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['guest_order']) || empty($_SESSION['guest_order']['items'])) {
            $_SESSION['error'] = 'No items in your order';
            header('Location: /ITCS489/public/index.php?route=orders');
            exit;
        }

        try {
            // Start transaction
            $this->db->beginTransaction();

            // Create guest order in database
            $stmt = $this->db->prepare("
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
                $_POST['email'],
                $_POST['phone'],
                $_POST['firstName'],
                $_POST['lastName'],
                $_POST['address'],
                $_POST['apartment'] ?? '',
                $_POST['city'],
                $_POST['postalCode'],
                $_POST['country'],
                $_POST['paymentMethod']
            ]);

            $orderId = $this->db->lastInsertId();

            // Add order items
            $stmt = $this->db->prepare("
                INSERT INTO order_items (order_id, book_id, quantity, price)
                VALUES (?, ?, ?, ?)
            ");

            foreach ($_SESSION['guest_order']['items'] as $item) {
                $stmt->execute([
                    $orderId,
                    $item['book_id'],
                    $item['quantity'],
                    $item['price']
                ]);
            }

            // Commit transaction
            $this->db->commit();

            // Get order details for receipt
            $stmt = $this->db->prepare("
                SELECT o.*, oi.*, b.title, b.cover_image
                FROM orders o
                JOIN order_items oi ON o.id = oi.order_id
                JOIN books b ON oi.book_id = b.id
                WHERE o.id = ?
            ");
            $stmt->execute([$orderId]);
            $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($orderDetails)) {
                throw new Exception('Order details not found');
            }

            // Clear guest order from session
            unset($_SESSION['guest_order']);

            // Show receipt
            include __DIR__ . '/../views/receipt.php';
            exit;

        } catch (Exception $e) {
            // Rollback on error
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            
            error_log('Order processing error: ' . $e->getMessage());
            $_SESSION['error'] = 'An error occurred while processing your order. Please try again.';
            header('Location: /ITCS489/public/index.php?route=order/checkout');
            exit;
        }
    }

    public function showConfirmation($orderId) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $stmt = $this->db->prepare("
            SELECT o.*, oi.*, b.title, b.cover_image
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN books b ON oi.book_id = b.id
            WHERE o.id = ? AND o.is_guest = 1
        ");
        $stmt->execute([$orderId]);
        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($orderDetails)) {
            header('Location: /ITCS489/public/index.php');
            exit;
        }

        include __DIR__ . '/../views/order_confirmation.php';
    }

    public function getCartCount() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        $count = 0;
        
        if (!isset($_SESSION['user_id'])) {
            // For guest users
            if (isset($_SESSION['guest_order']) && !empty($_SESSION['guest_order']['items'])) {
                foreach ($_SESSION['guest_order']['items'] as $item) {
                    $count += $item['quantity'];
                }
            }
        } else {
            // For logged-in users, get active order count
            try {
                $activeOrder = $this->orderModel->getActiveOrderByUser($_SESSION['user_id']);
                if ($activeOrder) {
                    $items = $this->orderItemModel->getByOrder($activeOrder['id']);
                    foreach ($items as $item) {
                        $count += $item['quantity'];
                    }
                }
            } catch (Exception $e) {
                error_log("Error getting cart count: " . $e->getMessage());
            }
        }

        echo json_encode([
            'success' => true,
            'count' => $count
        ]);
        exit;
    }

    public function getActiveUserOrder() {
        $activeOrder = $this->orderModel->getActiveOrderByUser($_SESSION['user_id']);
        if ($activeOrder) {
            $items = $this->orderItemModel->getByOrder($activeOrder['id']);
            $activeOrder['items'] = $items;
        }
        return $activeOrder;
    }
}
