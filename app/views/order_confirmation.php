<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the header file
include __DIR__ . '/layout/header.php';

// Calculate order totals
$subtotal = 0;
foreach ($orderDetails as $item) {
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
    <title>Order Confirmation | BookStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-8" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-8" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Order Confirmation</h1>
                    <p class="text-gray-600 mt-2">Order #<?php echo $orderDetails[0]['order_id']; ?></p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600">Order Date</p>
                    <p class="font-medium"><?php echo date('F j, Y', strtotime($orderDetails[0]['order_date'])); ?></p>
                </div>
            </div>

            <div class="border-t border-b border-gray-200 py-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Shipping Information -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Shipping Information</h2>
                        <p class="text-gray-600">
                            <?php echo htmlspecialchars($orderDetails[0]['first_name'] . ' ' . $orderDetails[0]['last_name']); ?><br>
                            <?php echo htmlspecialchars($orderDetails[0]['address']); ?><br>
                            <?php if (!empty($orderDetails[0]['apartment'])): ?>
                                <?php echo htmlspecialchars($orderDetails[0]['apartment']); ?><br>
                            <?php endif; ?>
                            <?php echo htmlspecialchars($orderDetails[0]['city'] . ', ' . $orderDetails[0]['postal_code']); ?><br>
                            <?php echo htmlspecialchars($orderDetails[0]['country']); ?>
                        </p>
                    </div>

                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h2>
                        <p class="text-gray-600">
                            Email: <?php echo htmlspecialchars($orderDetails[0]['email']); ?><br>
                            Phone: <?php echo htmlspecialchars($orderDetails[0]['phone']); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Details</h2>
            <div class="border rounded-lg overflow-hidden mb-8">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Quantity</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($orderDetails as $item): ?>
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <img src="/ITCS489/public/Images/<?php echo htmlspecialchars($item['cover_image'] ?? 'books1.png'); ?>" 
                                             alt="<?php echo htmlspecialchars($item['title']); ?>"
                                             class="w-16 h-16 object-contain rounded">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($item['title']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-500">
                                    <?php echo $item['quantity']; ?>
                                </td>
                                <td class="px-6 py-4 text-right text-sm text-gray-500">
                                    $<?php echo number_format($item['price'], 2); ?>
                                </td>
                                <td class="px-6 py-4 text-right text-sm text-gray-900">
                                    $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Subtotal</td>
                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">$<?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Shipping</td>
                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900"><?php echo $shipping > 0 ? '$' . number_format($shipping, 2) : 'Free'; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Tax</td>
                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">$<?php echo number_format($tax, 2); ?></td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td colspan="3" class="px-6 py-3 text-right text-base font-semibold text-gray-900">Total</td>
                            <td class="px-6 py-3 text-right text-base font-semibold text-gray-900">$<?php echo number_format($total, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-center">
                <p class="text-gray-600 mb-4">Thank you for your order! We will contact you with delivery details.</p>
                <a href="/ITCS489/public/index.php" class="inline-block px-6 py-3 bg-[#2A3F5F] text-white font-medium rounded-md hover:bg-opacity-90 transition-colors">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/layout/footer.php'; ?>
</body>
</html>
