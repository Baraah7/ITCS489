<?php
// Autoload required files
require_once __DIR__ . '/../app/controllers/book_controller.php';
require_once __DIR__ . '/../app/controllers/cart_contoller.php';
require_once __DIR__ . '/../app/core/database.php';
// Add more as needed...

// Initialize database connection
$db = Database::connect();
session_start();

// Determine route from query string
$route = $_GET['route'] ?? 'home';

switch ($route) {
    case 'cart/count':
        $cartController = new CartController($db);
        $cartController->getCartCount();
        break;

    case 'cart/add':
        $cartController = new CartController($db);
        $cartController->addToCart();
        break;
        
    case 'cart/update':
        $cartController = new CartController($db);
        $cartController->updateCart();
        break;
        
    case 'cart/remove':
        $cartController = new CartController($db);
        $cartController->removeItem();
        break;
        
    case 'cart/clear':
        $cartController = new CartController($db);
        $cartController->clearCart();
        break;
        
    case 'cart':
        $cartController = new CartController($db);
        $cartController->showCart();
        break;

    case 'book':
        // e.g. /public/index.php?route=book&id=5
        $bookController = new BookController($db);
        $bookController->showBookDetails($_GET['id'] ?? null);
        break;

    case 'login':
        $userController = new UserController($db);
        $userController->login();
        break;

    case 'home':
    default:
        include __DIR__ . '/../app/views/mainPage.php';
        break;
}
