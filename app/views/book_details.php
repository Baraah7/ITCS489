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
                         class="h-96 object-contain rounded-lg shadow-lg"
                         id="mainBookImage">
                    <div class="mt-4 flex space-x-2" id="thumbnailContainer">
                        <!-- Thumbnails would be dynamically added here if available -->
                    </div>
                </div>

                <!-- Book Info -->
                <div class="md:w-2/3 p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($book['title']); ?></h1>
                    <p class="text-lg text-gray-600 mb-4">by <?php echo htmlspecialchars($book['author_name']); ?></p>
                    
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 mr-2">
                            <?php 
                            $rating = $book['rating'] ?? 0;
                            $fullStars = floor($rating);
                            $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                            $emptyStars = 5 - $fullStars - $halfStar;
                            
                            for ($i = 0; $i < $fullStars; $i++) {
                                echo '<i class="fas fa-star"></i>';
                            }
                            if ($halfStar) {
                                echo '<i class="fas fa-star-half-alt"></i>';
                            }
                            for ($i = 0; $i < $emptyStars; $i++) {
                                echo '<i class="far fa-star"></i>';
                            }
                            ?>
                        </div>
                        <span class="text-gray-600">(<?php echo $book['review_count'] ?? 0; ?> reviews)</span>
                    </div>

                    <div class="mb-6">
                        <span class="text-2xl font-bold text-gray-900">$<?php echo number_format($book['price'], 2); ?></span>
                        <?php if (isset($book['original_price']) && $book['original_price'] > $book['price']): ?>
                            <span class="text-lg text-gray-500 line-through ml-2">$<?php echo number_format($book['original_price'], 2); ?></span>
                            <span class="bg-red-100 text-red-800 text-sm font-semibold ml-2 px-2.5 py-0.5 rounded">
                                Save <?php echo round(100 - ($book['price'] / $book['original_price'] * 100)); ?>%
                            </span>
                        <?php endif; ?>
                    </div>

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
                            <p class="text-gray-600"><?php echo htmlspecialchars($book['isbn']); ?></p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Pages</h3>
                            <p class="text-gray-600"><?php echo number_format($book['page_count']); ?></p>
                        </div>
                    </div>

                    <div class="flex items-center mb-6">
                        <div class="mr-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <div class="flex border rounded-md">
                                <button type="button" class="px-3 py-1 bg-gray-200 text-gray-600 decrement" onclick="updateQuantity(-1)">
                                    -
                                </button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="10" 
                                       class="w-12 text-center border-0 focus:ring-0">
                                <button type="button" class="px-3 py-1 bg-gray-200 text-gray-600 increment" onclick="updateQuantity(1)">
                                    +
                                </button>
                            </div>
                        </div>
                        <button id="addToCartBtn" 
                                class="px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
                                data-book-id="<?php echo $book['id']; ?>">
                            Add to Cart
                        </button>
                        <button class="ml-4 px-6 py-3 border border-gray-300 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            <i class="far fa-heart mr-2"></i> Wishlist
                        </button>
                    </div>

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
                    <a href="/book/<?php echo $relatedBook['id']; ?>">
                        <img src="<?php echo htmlspecialchars($relatedBook['cover_image']); ?>" 
                             alt="<?php echo htmlspecialchars($relatedBook['title']); ?>" 
                             class="w-full h-48 object-contain p-4">
                    </a>
                    <div class="p-4">
                        <a href="/book/<?php echo $relatedBook['id']; ?>" class="block">
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

    <!-- Footer would be included here -->

    <script>
        // Quantity control
        function updateQuantity(change) {
            const quantityInput = document.getElementById('quantity');
            let newValue = parseInt(quantityInput.value) + change;
            newValue = Math.max(1, Math.min(10, newValue));
            quantityInput.value = newValue;
        }

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

        // Add to cart functionality
        document.getElementById('addToCartBtn').addEventListener('click', function() {
            const bookId = this.getAttribute('data-book-id');
            const quantity = document.getElementById('quantity').value;
            
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    book_id: bookId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const originalText = this.textContent;
                    this.textContent = 'Added to Cart!';
                    this.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                    this.classList.add('bg-green-600', 'hover:bg-green-700');
                    
                    // Update cart count in navbar (if exists)
                    const cartCount = document.getElementById('cartCount');
                    if (cartCount) {
                        cartCount.textContent = data.cart_count;
                    }
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.classList.remove('bg-green-600', 'hover:bg-green-700');
                        this.classList.add('bg-blue-600', 'hover:bg-blue-700');
                    }, 2000);
                } else {
                    alert('Failed to add to cart: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding to cart');
            });
        });

        // If the book has multiple images, we would load them here
        // This is just a placeholder for that functionality
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
