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
            <a href="index.php" class="text-2xl font-bold">Baghdad</a>
            <div class="flex items-center space-x-4">
                <a href="#" class="hover:text-gray-200">Categories</a>
                <a href="#" class="hover:text-gray-200">Best Sellers</a>
                <a href="#" class="hover:text-gray-200">About</a>
                <div class="relative"> 
                                       
                    <button id="cart-btn" class="hover:text-gray-200 relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<svg version="1.1" id="shopping_x5F_carts_1_" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 128 128" xml:space="preserve"><style>.st0{display:none}.st1{display:inline}.st2{fill:#020202}</style><g id="_x34__1_"><path class="st2" d="M45.3 81.2h78V43.7L35.9 25.4l-3.1-12.9-12.6-4.2c0-.2.1-.3.1-.5 0-4.3-3.5-7.8-7.8-7.8S4.7 3.5 4.7 7.8s3.5 7.8 7.8 7.8c1.8 0 3.4-.6 4.7-1.6l9.4 4.7L39 78l-12.5 9.4V103l5.7 7.1c-1.6 1.9-2.5 4.3-2.5 7 0 6 4.9 10.9 10.9 10.9s10.9-4.9 10.9-10.9-4.9-10.9-10.9-10.9c-.9 0-1.8.1-2.6.3l-2.1-3.4h65.6l3.6 6c-2.2 2-3.6 4.9-3.6 8.1 0 6 4.9 10.9 10.9 10.9s10.9-4.9 10.9-10.9-4.9-10.9-10.9-10.9h-.3l-1.3-3.1h12.5V97H32.8v-6.2l12.5-9.6zm0-6.3-4.6-21.4.6 3L59.8 58l3.8 17H45.3zm21.8 0-3.7-16.7 18.1 1.4 1.4 15.3H67.1zm18.8 0-1.4-15 17 1.3v13.7H85.9zm31.2-15.6v15.6h-12.5V61.5l12.5 1v-3.2l-12.5-1V44.4l12.5 2.4v12.5zM35.9 31.2l65.6 12.6V58l-17.3-1.4-1.5-16.4-3.1-.6 1.6 16.8-18.5-1.5-4.3-19.3-3.7-.7 4.4 19.7-18.5-1.5-4.7-21.9zm76.5 81.2c2.6 0 4.7 2.1 4.7 4.7s-2.1 4.7-4.7 4.7-4.7-2.1-4.7-4.7 2.1-4.7 4.7-4.7zm-71.8 0c2.6 0 4.7 2.1 4.7 4.7s-2.1 4.7-4.7 4.7-4.7-2.1-4.7-4.7 2.1-4.7 4.7-4.7z" id="icon_11_"/></g></svg>
                        </svg>
                        <a href="cart.php" class="fas fa-shopping-cart text-xl"></a>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </button>
                </div>
                <a href="#" class="px-4 py-2 bg-gray-200 text-[#2A3F5F] rounded-md hover:bg-gray-300">Sign In</a>
            </div>
        </div>
    </nav>