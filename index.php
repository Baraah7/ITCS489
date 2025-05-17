<?php
// Start the session
session_start();

// Autoload required files
require_once __DIR__ . '/../controllers/BookController.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/CartController.php';
// Add more as needed...

// Determine route from query string
$route = $_GET['route'] ?? 'home';

switch ($route) {
    case 'book':
        // e.g. /public/index.php?route=book&id=5
        $bookController = new BookController();
        $bookController->show($_GET['id'] ?? null);
        break;

    case 'login':
        $userController = new UserController();
        $userController->login();
        break;

    case 'cart':
        $cartController = new CartController();
        $cartController->showCart();
        break;

    case 'home':
    default:
        include __DIR__ . '/../views/mainPage.php';
        break;
}
