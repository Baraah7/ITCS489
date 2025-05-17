<?php
// $cartItems and $cartTotal variables are available from the controller
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | BookStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation would be included here -->
    
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Your Shopping Cart</h1>
        
        <?php if (empty($cartItems)): ?>
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <i class="fas fa-shopping-cart text-5xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">Your cart is empty</h2>
                <p class="text-gray-600 mb-6">Start shopping to add items to your cart</p>
                <a href="/" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors">
                    Continue Shopping
                </a>
            </div>
        <?php else: ?>
            <div class="lg:flex gap-8">
                <!-- Cart Items -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="hidden md:grid grid-cols-12 bg-gray-100 p-4 font-medium text-gray-700">
                            <div class="col-span-5">Product</div>
                            <div class="col-span-2 text-center">Price</div>
                            <div class="col-span-3 text-center">Quantity</div>
                            <div class="col-span-2 text-right">Subtotal</div>
                        </div>
                        
                        <div id="cartItemsContainer">
                            <?php foreach ($cartItems as $item): ?>
                                <div class="cart-item grid grid-cols-1 md:grid-cols-12 gap-4 p-4 border-b" data-cart-item-id="<?php echo $item['cart_item_id']; ?>">
                                    <!-- Product Info -->
                                    <div class="md:col-span-5 flex items-center">
                                        <img src="<?php echo htmlspecialchars($item['cover_image']); ?>" 
                                             alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                             class="w-16 h-16 object-cover rounded mr-4">
                                        <div>
                                            <h3 class="font-medium text-gray-900">
                                                <a href="/book/<?php echo $item['book_id']; ?>" class="hover:text-blue-600">
                                                    <?php echo htmlspecialchars($item['title']); ?>
                                                </a>
                                            </h3>
                                            <button class="text-red-500 text-sm mt-1 remove-item-btn" data-cart-item-id="<?php echo $item['cart_item_id']; ?>">
                                                <i class="fas fa-trash-alt mr-1"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Price -->
                                    <div class="md:col-span-2 flex items-center md:justify-center">
                                        <span class="text-gray-900">$<?php echo number_format($item['price'], 2); ?></span>
                                    </div>
                                    
                                    <!-- Quantity -->
                                    <div class="md:col-span-3 flex items-center justify-center">
                                        <div class="flex border rounded-md">
                                            <button type="button" class="px-3 py-1 bg-gray-200 text-gray-600 decrement" 
                                                    onclick="updateQuantity(<?php echo $item['cart_item_id']; ?>, -1)">
                                                -
                                            </button>
                                            <input type="number" class="w-12 text-center border-0 focus:ring-0 quantity-input" 
                                                   value="<?php echo $item['quantity']; ?>" min="1" max="10"
                                                   data-cart-item-id="<?php echo $item['cart_item_id']; ?>">
                                            <button type="button" class="px-3 py-1 bg-gray-200 text-gray-600 increment" 
                                                    onclick="updateQuantity(<?php echo $item['cart_item_id']; ?>, 1)">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Subtotal -->
                                    <div class="md:col-span-2 flex items-center justify-end">
                                        <span class="font-medium text-gray-900">$<?php echo number_format($item['subtotal'], 2); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="p-4 flex justify-between items-center">
                            <button id="clearCartBtn" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash-alt mr-1"></i> Clear Cart
                            </button>
                            <a href="/" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-arrow-left mr-1"></i> Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:w-1/3 mt-6 lg:mt-0">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-900">$<?php echo number_format($cartTotal, 2); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span class="text-gray-900">$<?php echo $cartTotal > 25 ? '0.00' : '5.99'; ?></span>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <span class="text-gray-600">Tax</span>
                                <span class="text-gray-900">$<?php echo number_format($cartTotal * 0.08, 2); ?></span>
                            </div>
                            <div class="flex justify-between border-t pt-3 font-semibold text-lg">
                                <span>Total</span>
                                <span>$<?php 
                                    $shipping = $cartTotal > 25 ? 0 : 5.99;
                                    $tax = $cartTotal * 0.08;
                                    echo number_format($cartTotal + $shipping + $tax, 2); 
                                ?></span>
                            </div>
                        </div>
                        
                        <button id="checkoutBtn" class="w-full px-6 py-3 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 transition-colors">
                            Proceed to Checkout
                        </button>
                        
                        <div class="mt-4 text-sm text-gray-500">
                            <p><i class="fas fa-lock mr-1"></i> Secure checkout</p>
                            <p class="mt-2"><i class="fas fa-truck mr-1"></i> Free delivery on orders over $25</p>
                        </div>
                    </div>
                    
                    <!-- Promo Code -->
                    <div class="bg-white rounded-lg shadow-md p-6 mt-4">
                        <h3 class="font-medium text-gray-900 mb-2">Have a promo code?</h3>
                        <div class="flex">
                            <input type="text" placeholder="Enter promo code" 
                                   class="flex-1 px-4 py-2 border rounded-l-md focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-r-md hover:bg-gray-300">
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer would be included here -->

    <script>
        // Update quantity function
        function updateQuantity(cartItemId, change) {
            const inputElement = document.querySelector(`.quantity-input[data-cart-item-id="${cartItemId}"]`);
            let newValue = parseInt(inputElement.value) + change;
            newValue = Math.max(1, Math.min(10, newValue));
            
            // Update the input value immediately for better UX
            inputElement.value = newValue;
            
            // Send the update to the server
            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    cart_item_id: cartItemId,
                    quantity: newValue
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert('Failed to update quantity');
                    // Revert the input value if the update failed
                    inputElement.value = parseInt(inputElement.value) - change;
                } else {
                    // Update the cart total in the UI (would need to implement this)
                    updateCartTotals();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating quantity');
                inputElement.value = parseInt(inputElement.value) - change;
            });
        }

        // Remove item from cart
        document.querySelectorAll('.remove-item-btn').forEach(button => {
            button.addEventListener('click', function() {
                const cartItemId = this.getAttribute('data-cart-item-id');
                const cartItemElement = document.querySelector(`.cart-item[data-cart-item-id="${cartItemId}"]`);
                
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    fetch('/cart/remove', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            cart_item_id: cartItemId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the item from the UI
                            cartItemElement.remove();
                            
                            // Update the cart total in the UI
                            updateCartTotals();
                            
                            // Check if cart is now empty
                            if (document.querySelectorAll('.cart-item').length === 0) {
                                location.reload(); // Reload to show empty cart message
                            }
                        } else {
                            alert('Failed to remove item');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while removing item');
                    });
                }
            });
        });

        // Clear cart
        document.getElementById('clearCartBtn').addEventListener('click', function() {
            if (confirm('Are you sure you want to clear your entire cart?')) {
                fetch('/cart/clear', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Reload to show empty cart message
                    } else {
                        alert('Failed to clear cart');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while clearing cart');
                });
            }
        });

        // Quantity input change handler
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const cartItemId = this.getAttribute('data-cart-item-id');
                const newQuantity = parseInt(this.value);
                
                if (isNaN(newQuantity) {
                    this.value = 1;
                    return;
                }
                
                const validatedQuantity = Math.max(1, Math.min(10, newQuantity));
                this.value = validatedQuantity;
                
                if (validatedQuantity !== newQuantity) {
                    return; // Don't send update if value was corrected
                }
                
                // Send the update to the server
                fetch('/cart/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        cart_item_id: cartItemId,
                        quantity: validatedQuantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Failed to update quantity');
                        // Revert the input value if the update failed
                        this.value = parseInt(this.value);
                    } else {
                        // Update the cart total in the UI
                        updateCartTotals();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating quantity');
                    this.value = parseInt(this.value);
                });
            });
        });

        // Checkout button
        document.getElementById('checkoutBtn').addEventListener('click', function() {
            window.location.href = '/checkout';
        });

        // Function to update cart totals (would need to implement based on your needs)
        function updateCartTotals() {
            // In a real implementation, you might want to:
            // 1. Fetch the updated cart totals from the server
            // 2. Update the subtotal, shipping, tax, and total displays
            // For simplicity, we'll just reload the page here
            location.reload();
        }
    </script>
</body>
</html>