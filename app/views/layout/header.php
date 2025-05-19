<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title><?= $pageTitle ?? 'Bookstore' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/ITCS489/public/js/search.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Arial:wght@400;500;700&display=swap');
        body { font-family: 'Arial', sans-serif; }
    </style>
</head>
<body class="min-h-screen" style="background-color: #FFF9F4">    <!-- Navigation -->
    <nav style="background-color: #2A3F5F" class="text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">            <a href="/ITCS489/public/index.php" class="text-2xl font-bold">Baghdad</a>
            <div class="flex items-center space-x-4">
                <a href="/ITCS489/public/index.php?route=categories" class="hover:text-gray-200">Categories</a>
                <a href="/ITCS489/public/index.php?route=bestsellers" class="hover:text-gray-200">Best Sellers</a>
                <a href="/ITCS489/public/index.php?route=about" class="hover:text-gray-200">About</a>
                
                <!-- Cart Button -->
                <a href="/ITCS489/public/index.php?route=orders" class="hover:text-gray-200 relative inline-flex items-center">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        <?php 
                            $cartCount = 0;
                            if (!isset($_SESSION['user_id'])) {
                                if (isset($_SESSION['guest_order']) && !empty($_SESSION['guest_order']['items'])) {
                                    foreach ($_SESSION['guest_order']['items'] as $item) {
                                        $cartCount += $item['quantity'];
                                    }
                                }
                            } else {
                                if (isset($orderController)) {
                                    $activeOrder = $orderController->getActiveUserOrder();
                                    if ($activeOrder) {
                                        foreach ($activeOrder['items'] as $item) {
                                            $cartCount += $item['quantity'];
                                        }
                                    }
                                }
                            }
                            echo $cartCount;
                        ?>
                    </span>
                </a>

                <!-- Authentication -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <a href="index.php?route=logout" class="px-4 py-2 bg-gray-200 text-[#2A3F5F] rounded-md hover:bg-gray-300">Logout</a>
                    </div>
                <?php else: ?>
                    <a href="index.php?route=login" class="px-4 py-2 bg-gray-200 text-[#2A3F5F] rounded-md hover:bg-gray-300">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>