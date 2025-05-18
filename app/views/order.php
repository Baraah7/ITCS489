<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the header file
include __DIR__ . '/layout/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | BookStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/ITCS489/public/index.php" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                            <?php echo isset($_SESSION['user_id']) ? 'My Orders' : 'Guest Order'; ?>
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Alert Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Page Title -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <h1 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h1>
        <?php else: ?>
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Guest Order</h1>
        <?php endif; ?>
        
        <?php if (!isset($_SESSION['user_id']) && isset($_SESSION['guest_order']) && !empty($_SESSION['guest_order']['items'])): ?>
            <!-- Guest Order Display -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="p-6">
                    <div class="mb-4">
                        <p class="text-gray-600">You are currently shopping as a guest. 
                            <a href="/ITCS489/public/index.php?route=login" class="text-blue-600 hover:text-blue-800">Log in</a> 
                            to save your order and see your order history.
                        </p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php 
                                $totalAmount = 0;
                                foreach ($_SESSION['guest_order']['items'] as $index => $item): 
                                    $itemTotal = $item['price'] * $item['quantity'];
                                    $totalAmount += $itemTotal;
                                ?>
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="/ITCS489/public/Images/<?php echo htmlspecialchars($item['cover_image'] ?? 'books1.png'); ?>" 
                                                 alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                                 class="w-16 h-16 object-contain mr-4">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="/ITCS489/public/index.php?route=book/show&id=<?php echo $item['book_id']; ?>" class="hover:text-blue-600">
                                                        <?php echo htmlspecialchars($item['title']); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">$<?php echo number_format($item['price'], 2); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="/ITCS489/public/index.php?route=order/update" method="POST" class="flex items-center space-x-2">
                                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                                            <div class="flex border rounded-md">
                                                <button type="button" class="px-3 py-1 bg-gray-200 text-gray-600" 
                                                        onclick="updateOrderQuantity(this, -1)">-</button>
                                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" 
                                                       min="1" max="99" class="w-16 text-center border-0 focus:ring-0"
                                                       onchange="this.form.submit()">
                                                <button type="button" class="px-3 py-1 bg-gray-200 text-gray-600" 
                                                        onclick="updateOrderQuantity(this, 1)">+</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">$<?php echo number_format($itemTotal, 2); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <form action="/ITCS489/public/index.php?route=order/remove" method="POST" class="inline">
                                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                           
                        </table>
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-8 border-t pt-6">
                        <div class="max-w-lg ml-auto">
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-900">$<?php echo number_format($totalAmount, 2); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="text-gray-900"><?php echo $totalAmount >= 25 ? 'Free' : '$5.99'; ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax (8%)</span>
                                    <?php $tax = $totalAmount * 0.08; ?>
                                    <span class="text-gray-900">$<?php echo number_format($tax, 2); ?></span>
                                </div>
                                <div class="flex justify-between pt-4 border-t">
                                    <span class="text-lg font-semibold text-gray-900">Total</span>
                                    <span class="text-lg font-bold text-[#2A3F5F]">
                                        $<?php echo number_format($totalAmount + ($totalAmount >= 25 ? 0 : 5.99) + $tax, 2); ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Checkout Action Buttons -->
                            <div class="mt-6 flex justify-end space-x-4">
                                <a href="/ITCS489/public/index.php" 
                                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                                    Continue Shopping
                                </a>
                                <a href="/ITCS489/public/index.php?route=order/checkout" 
                                   class="px-6 py-2 bg-[#2A3F5F] text-white rounded-md hover:bg-opacity-90 transition-colors inline-flex items-center">
                                    <i class="fas fa-lock mr-2"></i>
                                    Proceed to Checkout
                                </a>
                            </div>
                            
                            <div class="mt-4 text-sm text-gray-500">
                                <p><i class="fas fa-truck mr-2"></i> Free shipping on orders over $25</p>
                                <p class="mt-1"><i class="fas fa-lock mr-2"></i> Secure checkout</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- User Orders Display -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- ...existing code... -->
        <?php elseif (!isset($_SESSION['guest_order']) || empty($_SESSION['guest_order']['items'])): ?>
            <!-- Empty Order State -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <i class="fas fa-shopping-bag text-5xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">Your guest order is empty</h2>
                <p class="text-gray-600 mb-6">Start shopping to add items to your order</p>
                <div class="space-x-4">
                    <a href="/ITCS489/public/index.php" class="px-6 py-3 bg-[#2A3F5F] text-white font-medium rounded-md hover:bg-opacity-90 transition-colors">
                        Browse Books
                    </a>
                    <a href="/ITCS489/public/index.php?route=login" class="px-6 py-3 bg-gray-600 text-white font-medium rounded-md hover:bg-gray-700 transition-colors">
                        Sign In
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function updateOrderQuantity(button, change) {
            const input = button.parentElement.querySelector('input[type="number"]');
            const currentValue = parseInt(input.value);
            const newValue = Math.max(1, Math.min(99, currentValue + change));
            if (newValue !== currentValue) {
                input.value = newValue;
                input.form.submit();
            }
        }
    </script>

<?php include __DIR__ . '/layout/footer.php'; ?>
</body>
</html>