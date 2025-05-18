<?php
// Autoload required files
require_once __DIR__ . '/../app/controllers/book_controller.php';
require_once __DIR__ . '/../app/controllers/order_controller.php';
require_once __DIR__ . '/../app/controllers/user_controller.php';
require_once __DIR__ . '/../app/controllers/search_api.php';
require_once __DIR__ . '/../app/core/database.php';
// Add more as needed...

// Initialize database connection
$db = Database::connect();
session_start();

// Initialize all controllers with database connection
$bookController = new BookController($db);
$orderController = new OrderController($db);
$userController = new UserController($db);
$searchAPI = new SearchAPI($db);

// Determine route from query string
$route = $_GET['route'] ?? 'home';

switch ($route) {
    // Search routes
    case 'search/api':
        $searchAPI->search();
        break;

    case 'search':
        include __DIR__ . '/../app/views/search.php';
        break;

    // Book routes
    case 'books':
        $bookController->index();
        break;
    
    case 'book/show':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $bookController->show($id);
        }
        break;
    
    case 'book/details': // Support for old route
        $id = $_GET['id'] ?? null;
        if ($id) {
            $bookController->showBookDetails($id);
        }
        break;
    
    case 'book/create':
        $bookController->create();
        break;
    
    case 'book/store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookController->store($_POST);
        }
        break;
    
    case 'book/edit':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $bookController->edit($id);
        }
        break;
    
    case 'book/update':
        $id = $_GET['id'] ?? null;
        if ($id && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookController->update($id, $_POST);
        }
        break;
    
    case 'book/delete':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $bookController->delete($id);
        }        break;

    // Order routes
    case 'orders':
        $orderController->index();
        break;

    case 'order/add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderController->addToOrder();
        } else {
            header('Location: index.php?route=home');
        }
        break;

    case 'order/update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderController->updateGuestOrder();
        } else {
            header('Location: index.php?route=orders');
        }
        break;

    case 'order/remove':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderController->removeFromGuestOrder();
        } else {
            header('Location: index.php?route=orders');
        }
        break;

    case 'order/checkout':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderController->processCheckout();
        } else {
            $orderController->guestCheckout();
        }
        break;

    case (preg_match('/^order\/confirmation\/(\d+)$/', $route, $matches) ? true : false):
        $orderController->showConfirmation($matches[1]);
        break;

    // User routes
    case 'login':
        $userController->login();
        break;

    case 'login/authenticate':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->authenticate($_POST['email'], $_POST['password']);
        } else {
            header('Location: index.php?route=login');
        }
        break;

    case 'logout':
        $userController->logout();
        break;    case 'search':
        include __DIR__ . '/../app/views/search.php';
        break;

    case 'home':
    default:
        include __DIR__ . '/../app/views/mainPage.php';
        break;
}
