<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the header file
include __DIR__ . '/layout/header.php';

// Redirect if no guest order exists
if (!isset($_SESSION['guest_order']) || empty($_SESSION['guest_order']['items'])) {
    header('Location: /ITCS489/public/index.php?route=orders');
    exit;
}

// Calculate totals
$subtotal = 0;
foreach ($_SESSION['guest_order']['items'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$shipping = $subtotal >= 25 ? 0 : 5.99;
$tax = $subtotal * 0.08;
$total = $subtotal + $shipping + $tax;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | BookStore</title>
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
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <a href="/ITCS489/public/index.php?route=orders" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                            Guest Order
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Checkout</span>
                    </div>
                </li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold text-gray-900 mb-8">Guest Checkout</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Checkout Form -->
            <div>
                <form action="/ITCS489/public/index.php?route=order/checkout" method="POST" class="space-y-6">
                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Contact Information</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="email" id="email" name="email" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" id="phone" name="phone" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Shipping Address</h2>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="firstName" class="block text-sm font-medium text-gray-700">First Name</label>
                                    <input type="text" id="firstName" name="firstName" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                                    <input type="text" id="lastName" name="lastName" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" id="address" name="address" required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="apartment" class="block text-sm font-medium text-gray-700">Apartment, suite, etc. (optional)</label>
                                <input type="text" id="apartment" name="apartment"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" id="city" name="city" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="postalCode" class="block text-sm font-medium text-gray-700">Postal Code</label>
                                    <input type="text" id="postalCode" name="postalCode" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <select id="country" name="country" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="Bahrain">Bahrain</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Method</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="paymentMethod" value="cash" checked
                                           class="form-radio h-4 w-4 text-blue-600">
                                    <span class="ml-2">Cash on Delivery</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:row-span-2">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                            
                            <!-- Order Items -->
                            <div class="divide-y divide-gray-200">
                                <?php foreach ($_SESSION['guest_order']['items'] as $item): ?>
                                    <div class="py-4 flex items-center">
                                        <img src="/ITCS489/public/Images/<?php echo htmlspecialchars($item['cover_image'] ?? 'books1.png'); ?>" 
                                             alt="<?php echo htmlspecialchars($item['title']); ?>"
                                             class="w-16 h-16 object-contain rounded">
                                        <div class="ml-4 flex-1">
                                            <h3 class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($item['title']); ?></h3>
                                            <p class="text-sm text-gray-500">Quantity: <?php echo $item['quantity']; ?></p>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">
                                            $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Totals -->
                            <div class="border-t border-gray-200 mt-6 pt-6 space-y-4">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Subtotal</span>
                                    <span>$<?php echo number_format($subtotal, 2); ?></span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Shipping</span>
                                    <span><?php echo $shipping > 0 ? '$' . number_format($shipping, 2) : 'Free'; ?></span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Tax</span>
                                    <span>$<?php echo number_format($tax, 2); ?></span>
                                </div>
                                <div class="flex justify-between text-base font-medium text-gray-900 border-t border-gray-200 pt-4">
                                    <span>Total</span>
                                    <span>$<?php echo number_format($total, 2); ?></span>
                                </div>
                            </div>
                            <!-- Place Order Button -->
                            <button type="submit"
                                    class="mt-6 w-full px-6 py-3 bg-[#2A3F5F] text-white font-medium rounded-md hover:bg-opacity-90 transition-colors">
                                Place Order (Cash on Delivery)
                            </button>

                            <div class="mt-4 text-sm text-gray-500">
                                <p><i class="fas fa-lock mr-1"></i> Secure checkout</p>
                                <p class="mt-2"><i class="fas fa-truck mr-1"></i> Free delivery on orders over $25</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/layout/footer.php'; ?>
</body>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    // Phone validation (8 digits, optionally starting with +973)
    const phone = document.getElementById('phone').value;
    const phonePattern = /^(\+973)?[0-9]{8}$/;
    if (!phonePattern.test(phone)) {
        e.preventDefault();
        alert('Please enter a valid phone number (8 digits, optionally starting with +973)');
        return;
    }

    // Postal code validation (Bahrain format: 3-4 digits)
    const postalCode = document.getElementById('postalCode').value;
    const postalPattern = /^[0-9]{3,4}$/;
    if (!postalPattern.test(postalCode)) {
        e.preventDefault();
        alert('Please enter a valid postal code (3-4 digits)');
        return;
    }
});
</script>
</html>
