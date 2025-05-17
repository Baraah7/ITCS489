<?php
// Autoload required files
require_once __DIR__ . '/../app/controllers/book_controller.php';
require_once __DIR__ . '/../app/controllers/cart_contoller.php';
// Add more as needed...

// Determine route from query string
$route = $_GET['route'] ?? 'home';

switch ($route) {
    case 'book':
        // e.g. /public/index.php?route=book&id=5
        require_once __DIR__ . '/../app/core/database.php';
        $db = Database::connect();
        $bookController = new BookController($db);
        $bookController->showBookDetails($_GET['id'] ?? null);
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
        include __DIR__ . '/../app/views/mainPage.php';
        break;
}
