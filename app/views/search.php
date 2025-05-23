<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>Book Haven - Search Books</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Add defer to ensure DOM is loaded before script runs -->
    <script src="/ITCS489/public/js/search.js" defer></script>
</head>
<body id="search-page" class="min-h-screen" style="background-color: #FFF9F4">
    <!-- Navigation -->
    <nav style="background-color: #2A3F5F" class="text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/ITCS489/public/index.php" class="text-2xl font-bold">Baghdad</a>
            <div class="flex items-center space-x-4">
                <a href="/ITCS489/public/index.php" class="hover:text-gray-200">Home</a>
                <a href="/ITCS489/public/index.php?route=categories" class="hover:text-gray-200">Categories</a>
                <a href="/ITCS489/public/index.php?route=bestsellers" class="hover:text-gray-200">Best Sellers</a>
                <a href="/ITCS489/public/index.php?route=about" class="hover:text-gray-200">About</a>
                <div class="relative">
                    <a href="/ITCS489/public/index.php?route=cart" id="cart-btn" class="hover:text-gray-200 relative inline-block">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </a>
                </div>
                <a href="/ITCS489/public/index.php?route=login" class="px-4 py-2 bg-gray-200 text-[#2A3F5F] rounded-md hover:bg-gray-300">Sign In</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Search Section -->
        <section class="mb-12">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Find Your Next Favorite Book</h1>
            
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-grow relative">
                        <input type="text" 
                               id="search-input" 
                               placeholder="Search by title, author, or ISBN..." 
                               value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2A3F5F]">
                        <button id="search-btn" class="absolute right-3 top-3 text-gray-500 hover:text-[#2A3F5F]">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    
                    <select id="category-filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2A3F5F]">
                        <option value="">All Categories</option>
                        <option value="fiction">Fiction</option>
                        <option value="non-fiction">Non-Fiction</option>
                        <option value="science">Science</option>
                        <option value="biography">Biography</option>
                        <option value="fantasy">Fantasy</option>
                        <option value="mystery">Mystery</option>
                        <option value="romance">Romance</option>
                    </select>
                    
                    <button id="advanced-search-toggle" class="px-4 py-3 bg-gray-200 hover:bg-gray-300 rounded-lg">
                        Advanced <i class="fas fa-caret-down ml-1"></i>
                    </button>
                </div>

                <!-- Advanced Search -->
                <div id="advanced-search" class="hidden mt-4 pt-4 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700 mb-2">Author</label>
                            <input type="text" id="author-filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Price Range</label>
                            <div class="flex items-center space-x-2">
                                <input type="number" id="min-price" placeholder="Min" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <span>to</span>
                                <input type="number" id="max-price" placeholder="Max" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Publication Year</label>
                            <input type="number" id="year-filter" placeholder="Year" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button id="reset-filters" class="px-4 py-2 text-gray-600 hover:text-gray-800 mr-2">
                            Reset
                        </button>
                        <button id="apply-filters" style="background-color: #2A3F5F" class="px-4 py-2 text-white rounded-lg hover:opacity-90">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Results Section -->
        <section>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Search Results</h2>
                <div class="flex items-center">
                    <span class="mr-2 text-gray-600">Sort by:</span>
                    <select id="sort-by" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2A3F5F]">
                        <option value="relevance">Relevance</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="title-asc">Title: A-Z</option>
                        <option value="title-desc">Title: Z-A</option>
                        <option value="newest">Newest</option>
                        <option value="rating">Highest Rated</option>
                    </select>
                </div>
            </div>

            <!-- Results Grid -->
            <div id="results-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-search fa-3x mb-4"></i>
                    <p>Enter a search term to find books</p>
                </div>
            </div>

            <!-- Pagination -->
            <div id="pagination" class="mt-8 flex justify-center hidden">
                <nav class="inline-flex rounded-md shadow">
                    <button id="prev-page" class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50">
                        Previous
                    </button>
                    <div id="page-numbers" class="flex">
                        <!-- Page numbers will be inserted here -->
                    </div>
                    <button id="next-page" class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                        Next
                    </button>
                </nav>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Book Haven</h3>
                    <p class="text-gray-400">Your one-stop shop for all your reading needs since 2010.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">New Releases</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Deals</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Gift Cards</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Customer Service</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Shipping</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Returns</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Stay Connected</h4>
                    <div class="flex space-x-4 mb-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-pinterest"></i></a>
                    </div>
                    <p class="text-gray-400">Subscribe to our newsletter</p>
                    <div class="mt-2 flex">
                        <input type="email" placeholder="Your email" class="px-3 py-2 rounded-l-md text-gray-800 w-full">
                        <button class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-r-md">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                <p>&copy; 2023 Book Haven. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>