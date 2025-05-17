<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Bookstore' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Arial:wght@400;500;700&display=swap');
        body { font-family: 'Arial', sans-serif; }
    </style>
</head>
<body class="min-h-screen" style="background-color: #FFF9F4">    <!-- Navigation -->
    <nav style="background-color: #2A3F5F" class="text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Baghdad</a>
            <div class="flex items-center space-x-4">
                <a href="index.html" class="hover:text-gray-200">Home</a>
                <a href="#" class="hover:text-gray-200">Categories</a>
                <a href="#" class="hover:text-gray-200">Best Sellers</a>
                <a href="#" class="hover:text-gray-200">About</a>
                <div class="relative">                    <button id="cart-btn" class="hover:text-gray-200 relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </button>
                </div>
                <a href="#" class="px-4 py-2 bg-gray-200 text-[#2A3F5F] rounded-md hover:bg-gray-300">Sign In</a>
            </div>
        </div>
    </nav>
