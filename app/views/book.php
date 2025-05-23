<?php
// This would be included by the controller
// $book and $relatedBooks variables are available from the controller

// Fix header include path
include __DIR__ . '/layout/header.php';

// Prevent errors if $book is not set
if (!isset($book) || !is_array($book)) {
    echo '<div class="text-red-600 font-bold p-4">Book details not available.</div>';
    include __DIR__ . '/layout/footer.php';
    return;
}
?>
    
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <a href="/category/<?php echo strtolower($book['genre_name']); ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                            <?php echo htmlspecialchars($book['genre_name']); ?>
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                            <?php echo htmlspecialchars($book['title']); ?>
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Main Book Details -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <!-- Book Cover -->
                <div class="md:w-1/3 p-6 flex justify-center">
                    <img src="<?php echo htmlspecialchars($book['cover_image']); ?>" 
                         alt="<?php echo htmlspecialchars($book['title']); ?>"
                         class="max-w-full h-auto rounded-lg shadow-lg">
                </div>
                
                <!-- Book Details -->                <div class="md:w-2/3 p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4"><?php echo htmlspecialchars($book['title']); ?></h1>
                    <div class="mb-4">
                        <span class="text-gray-600">By</span>
                        <span class="text-gray-900 font-medium"><?php echo htmlspecialchars($book['author_name']); ?></span>
                    </div>                    <!-- Price and Add to Order Form -->
                    <div class="flex items-center space-x-4 mb-6">
                        <span class="text-2xl font-bold text-[#2A3F5F]">$<?php echo number_format($book['price'], 2); ?></span>
                        
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="text-green-600"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="text-red-600"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                        <?php endif; ?>

                        <form id="addToCartForm" action="index.php?route=order/add" method="POST" class="flex items-center space-x-2">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <div class="flex border rounded-md">
                                <button type="button" class="px-3 py-1 bg-gray-200 text-gray-600" onclick="updateQuantity(-1)">-</button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="99"
                                       class="w-16 text-center border-0 focus:ring-0">
                                <button type="button" class="px-3 py-1 bg-gray-200 text-gray-600" onclick="updateQuantity(1)">+</button>
                            </div>
                            <button type="submit" 
                                    class="px-6 py-2 bg-[#2A3F5F] text-white rounded-md hover:bg-opacity-90 transition-colors">
                                Add to Order
                            </button>
                        </form>
                    </div>
                    
                    <!-- Book Description -->
                    <div class="mb-6">
                        <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
                    </div>

                    <div class="mb-6 grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-semibold text-gray-900">Publisher</h3>
                            <p class="text-gray-600"><?php echo htmlspecialchars($book['publisher']); ?></p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Publication Date</h3>
                            <p class="text-gray-600"><?php echo date('F j, Y', strtotime($book['publication_date'])); ?></p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">ISBN</h3>
                            <p class="text-gray-600"><?php echo isset($book['isbn']) ? htmlspecialchars($book['isbn']) : 'N/A'; ?></p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Pages</h3>
                            <p class="text-gray-600"><?php echo number_format($book['page_count']); ?></p>
                        </div>
                    </div>                    <!-- Removed duplicate quantity control -->

                    <div class="border-t pt-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Delivery Options</h3>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-truck mr-2"></i>
                            <span>Free delivery on orders over $25</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Details Tabs -->
        <div class="mt-8 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button id="detailsTab" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                        Details
                    </button>
                    <button id="reviewsTab" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Reviews
                    </button>
                </nav>
            </div>
            <div class="p-6">
                <div id="detailsContent" class="tab-content">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-medium text-gray-900">Format</h4>
                            <p class="text-gray-600"><?php echo htmlspecialchars($book['format'] ?? 'Paperback'); ?></p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Dimensions</h4>
                            <p class="text-gray-600"><?php echo htmlspecialchars($book['dimensions'] ?? 'N/A'); ?></p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Language</h4>
                            <p class="text-gray-600"><?php echo htmlspecialchars($book['language'] ?? 'English'); ?></p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Weight</h4>
                            <p class="text-gray-600"><?php echo htmlspecialchars($book['weight'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>
                <div id="reviewsContent" class="tab-content hidden">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Reviews</h3>
                    <!-- Reviews would be loaded here -->
                    <div class="text-center py-8 text-gray-500">
                        <p>No reviews yet. Be the first to review this book!</p>
                        <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Write a Review
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Books -->
        <?php if (!empty($relatedBooks)): ?>
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">You May Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($relatedBooks as $relatedBook): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <a href="book.php?id=<?php echo $relatedBook['id']; ?>">
                        <img src="<?php echo htmlspecialchars($relatedBook['cover_image']); ?>" 
                             alt="<?php echo htmlspecialchars($relatedBook['title']); ?>" 
                             class="w-full h-48 object-contain p-4">
                    </a>
                    <div class="p-4">
                        <a href="book.php?id=<?php echo $relatedBook['id']; ?>" class="block">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1 hover:text-blue-600"><?php echo htmlspecialchars($relatedBook['title']); ?></h3>
                        </a>
                        <p class="text-gray-600 text-sm mb-2">by Author Name</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-lg font-bold text-gray-900">$<?php echo number_format($relatedBook['price'], 2); ?></span>
                            <button class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Footer would be included here -->    <script>
        // Quantity control
        function updateQuantity(change) {
            const quantityInput = document.getElementById('quantity');
            let newValue = parseInt(quantityInput.value) + change;
            newValue = Math.max(1, Math.min(99, newValue));
            quantityInput.value = newValue;
        }

        // Notification function
        function showNotification(message, success = true) {
            let notification = document.getElementById('notification');
            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'notification';
                document.body.appendChild(notification);
            }

            notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded shadow-lg transition-all duration-300 transform translate-y-0 
                                    ${success ? 'bg-green-500' : 'bg-red-500'} text-white flex items-center space-x-2`;
            notification.innerHTML = `
                <i class="fas ${success ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                <span>${message}</span>
                <button class="ml-4" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;

            setTimeout(() => {
                notification.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Cart count update
        async function updateCartCount() {
            try {
                const response = await fetch('/ITCS489/public/index.php?route=order/count');
                const data = await response.json();
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = data.count || '0';
                }
            } catch (error) {
                console.error('Error updating cart count:', error);
            }
        }

        // Form submission
        document.getElementById('addToCartForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const data = await response.json();
                showNotification(data.message, data.success);
                
                if (data.success) {
                    updateCartCount();
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Failed to add book to cart', false);
            }
        });

        // Tab switching
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                // Update active tab
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('border-blue-500', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });
                this.classList.add('border-blue-500', 'text-blue-600');
                this.classList.remove('border-transparent', 'text-gray-500');

                // Show corresponding content
                const tabId = this.id;
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                
                if (tabId === 'detailsTab') {
                    document.getElementById('detailsContent').classList.remove('hidden');
                } else if (tabId === 'reviewsTab') {
                    document.getElementById('reviewsContent').classList.remove('hidden');
                }
            });
        });
        function loadAdditionalImages() {
            // In a real implementation, this would fetch additional images from the server
            /*
            fetch(`/book/${bookId}/images`)
                .then(response => response.json())
                .then(images => {
                    const container = document.getElementById('thumbnailContainer');
                    images.forEach((image, index) => {
                        const img = document.createElement('img');
                        img.src = image.thumbnail;
                        img.alt = `Thumbnail ${index + 1}`;
                        img.className = 'w-16 h-16 object-cover rounded cursor-pointer border-2 border-transparent hover:border-blue-500';
                        img.addEventListener('click', () => {
                            document.getElementById('mainBookImage').src = image.full_size;
                        });
                        container.appendChild(img);
                    });
                });
            */
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Load additional images if available
            loadAdditionalImages();
        });
    </script>

<?php include __DIR__ . '/layout/footer.php'; ?>
