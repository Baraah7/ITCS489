<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baghdad Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Arial:wght@400;500;700&display=swap');
        
        body {
            font-family: 'Arial', sans-serif;
        }
    </style>
</head>
<body class="bg-[#FFF9F4]">
    <div class="max-w-screen-xl mx-auto w-full px-4">
        <!-- Header -->
        <header class="bg-white shadow-md">
            <div class="header-top px-8 py-6">
                <div class="flex justify-between items-center mb-6">                    <div class="text-left">
                        <h1 class="text-5xl font-bold text-[#2A3F5F] mb-2">Baghdad</h1>
                        <p class="subtitle text-[#6B778C] text-lg font-normal">Your go to library of endless, wonderful knowledge</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="search.html" class="p-2 text-[#2A3F5F] hover:text-opacity-70" title="Search">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </a>
                        <a href="#login" class="px-6 py-2 bg-[#2A3F5F] text-white rounded-full hover:opacity-90">Log In</a>
                        <a href="#about" class="button secondary px-6 py-2 bg-[#E8E9EB] text-[#2A3F5F] rounded-full hover:bg-gray-300">About Us</a>
                    </div>
                </div>
                <div class="nav-bar flex justify-center space-x-8 text-[#495057] font-medium border-t border-[#dee2e6] pt-4">
                    <a href="#about" class="nav-item hover:text-[#2A3F5F]">About Us</a>
                    <div class="relative group">
                        <button class="nav-item hover:text-[#2A3F5F] flex items-center">
                            Books
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute hidden group-hover:block w-48 bg-white shadow-lg rounded-md mt-2 py-2 z-50">
                            <a href="#fiction" class="block px-4 py-2 text-[#495057] hover:text-[#2A3F5F] hover:bg-gray-50">Fiction</a>
                            <a href="#non-fiction" class="block px-4 py-2 text-[#495057] hover:text-[#2A3F5F] hover:bg-gray-50">Non-Fiction</a>
                            <a href="#science" class="block px-4 py-2 text-[#495057] hover:text-[#2A3F5F] hover:bg-gray-50">Science</a>
                            <a href="#biography" class="block px-4 py-2 text-[#495057] hover:text-[#2A3F5F] hover:bg-gray-50">Biography</a>
                            <a href="#fantasy" class="block px-4 py-2 text-[#495057] hover:text-[#2A3F5F] hover:bg-gray-50">Fantasy</a>
                        </div>
                    </div>                    <a href="#top-sellers" class="nav-item text-[#495057] hover:text-[#2A3F5F]">Top Sellers</a>
                    <a href="help.php" class="nav-item text-[#495057] hover:text-[#2A3F5F]">Self Help</a>
                    <a href="#new-arrivals" class="nav-item hover:text-[#2A3F5F]">New Arrivals</a>
                    <a href="#offers" class="nav-item hover:text-[#2A3F5F]">Offers</a>
                    <a href="#share" class="nav-item hover:text-[#2A3F5F]">Share Experience</a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            <!-- SPACE AFTER HEADER -->
            <div class="header-spacing h-10"></div>

            <!-- NEW ARRIVALS SECTION -->            <section class="new-arrivals py-12">
                <h2 class="section-title text-3xl font-bold text-[#2A3F5F] mb-8 text-center">New Arrivals</h2>
                <div class="image-box long w-full h-96 bg-[#D0B8A8] rounded-xl overflow-hidden mx-auto max-w-6xl">
                    <img src="Images/books1.png" alt="New Arrivals Banner" class="w-full h-full object-cover">
                </div>
            </section>

            <!-- TOP SELLERS SECTION -->
            <section class="top-sellers py-12 bg-[#f8f9fa]">
                <h2 class="section-title text-3xl font-bold text-[#2A3F5F] mb-8 px-8">Top Sellers</h2>
                <div class="box-container grid grid-cols-1 md:grid-cols-3 gap-8 px-8">                    <!-- BOOK CARD 1 -->
                    <div class="book-card bg-[#D0B8A8] rounded-xl shadow-[0_4px_6px_rgba(0,0,0,0.05)] p-6 hover:shadow-lg">
                        <a href="index.php?route=book&id=10" class="block">
                            <div class="image-box bg-[#D0B8A8] rounded-lg h-64">
                                <img src="Images/books1.png" alt="Book Cover" class="w-full h-full object-contain">
                            </div>
                            <h3 class="font-bold text-lg mt-4 text-[#2A3F5F]">Harry Potter and the Cursed Child</h3>
                            <p class="author text-[#6B778C] text-sm mt-2">By J.K. Rowling</p>
                            <p class="description text-[#4A5568] text-sm mt-2">Return to the Wizarding World in this two-part stage play.</p>
                        </a>
                    </div>

                    <!-- BOOK CARD 2 -->
                    <div class="book-card bg-[#D0B8A8] rounded-xl shadow-[0_4px_6px_rgba(0,0,0,0.05)] p-6 hover:shadow-lg">
                        <a href="index.php?route=book&id=11" class="block">
                            <div class="image-box bg-[#D0B8A8] rounded-lg h-64">
                                <img src="Images/book 3.bmp" alt="Book Cover" class="w-full h-full object-contain">
                            </div>
                            <h3 class="font-bold text-lg mt-4 text-[#2A3F5F]">The Great Gatsby</h3>
                            <p class="author text-[#6B778C] text-sm mt-2">By F. Scott Fitzgerald</p>
                            <p class="description text-[#4A5568] text-sm mt-2">A story of decadence and excess.</p>
                        </a>
                    </div>

                    <!-- BOOK CARD 3 -->
                    <div class="book-card bg-[#D0B8A8] rounded-xl shadow-[0_4px_6px_rgba(0,0,0,0.05)] p-6 hover:shadow-lg">
                        <a href="index.php?route=book&id=12" class="block">
                            <div class="image-box bg-[#D0B8A8] rounded-lg h-64">
                                <img src="Images/book 4.bmp" alt="Book Cover" class="w-full h-full object-contain">
                            </div>
                            <h3 class="font-bold text-lg mt-4 text-[#2A3F5F]">1984</h3>
                            <p class="author text-[#6B778C] text-sm mt-2">By George Orwell</p>
                            <p class="description text-[#4A5568] text-sm mt-2">A dystopian social science fiction novel.</p>
                        </a>
                    </div>
                </div>
            </section>

            <!-- SELF HELP SECTION -->
            <section class="self-help py-12">
                <h2 class="section-title text-3xl font-bold text-[#2A3F5F] mb-8 px-8">Self Help</h2>
                <div class="box-container grid grid-cols-1 md:grid-cols-3 gap-8 px-8">
                    <!-- BOOK CARD 1 -->
                    <div class="book-card bg-[#D0B8A8] rounded-xl shadow-[0_4px_6px_rgba(0,0,0,0.05)] p-6 hover:shadow-lg">
                        <div class="image-box bg-[#D0B8A8] rounded-lg h-64">
                            <img src="Images/book 5.bmp" alt="Book Cover" class="w-full h-full object-contain">
                        </div>
                        <h3 class="font-bold text-lg mt-4 text-[#2A3F5F]">Autism Empowerment for Adults</h3>
                        <p class="author text-[#6B778C] text-sm mt-2">By Jules Golden</p>
                        <p class="description text-[#4A5568] text-sm mt-2">Practical strategies for neurodiverse adults.</p>
                    </div>

                    <!-- BOOK CARD 2 -->
                    <div class="book-card bg-[#D0B8A8] rounded-xl shadow-[0_4px_6px_rgba(0,0,0,0.05)] p-6 hover:shadow-lg">
                        <div class="image-box bg-[#D0B8A8] rounded-lg h-64">
                            <img src="Images/book 6.bmp" alt="Book Cover" class="w-full h-full object-contain">
                        </div>
                        <h3 class="font-bold text-lg mt-4 text-[#2A3F5F]">The Power of Habit</h3>
                        <p class="author text-[#6B778C] text-sm mt-2">By Charles Duhigg</p>
                        <p class="description text-[#4A5568] text-sm mt-2">Why we do what we do in life and business.</p>
                    </div>

                    <!-- BOOK CARD 3 -->
                    <div class="book-card bg-[#D0B8A8] rounded-xl shadow-[0_4px_6px_rgba(0,0,0,0.05)] p-6 hover:shadow-lg">
                        <div class="image-box bg-[#D0B8A8] rounded-lg h-64">
                            <img src="Images/book 7.bmp" alt="Book Cover" class="w-full h-full object-contain">
                        </div>
                        <h3 class="font-bold text-lg mt-4 text-[#2A3F5F]">Atomic Habits</h3>
                        <p class="author text-[#6B778C] text-sm mt-2">By James Clear</p>
                        <p class="description text-[#4A5568] text-sm mt-2">An easy and proven way to build good habits.</p>
                    </div>
                </div>
            </section>

            <!-- TESTIMONIALS SECTION -->
            <section class="testimonials py-16 bg-[#f8f6f2]">
                <div class="container mx-auto px-8">
                    <h2 class="text-3xl font-bold text-[#2A3F5F] text-center mb-12">What Our Community Says</h2>
                    <div class="testimonials-grid grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Testimonial 1 -->
                        <div class="testimonial-card bg-white rounded-xl shadow-[0_5px_15px_rgba(0,0,0,0.05)] p-8">
                            <blockquote class="text-lg text-[#555] italic mb-6">"A terrific piece of praise"</blockquote>
                            <div class="testimonial-author flex items-center">
                                <div class="author-image w-12 h-12 bg-[#e0e0e0] rounded-full flex items-center justify-center text-[#999]">SJ</div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-[#2A3F5F]">Sarah Johnson</h4>
                                    <p class="text-[#6B778C] text-sm">Book Enthusiast</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 2 -->
                        <div class="testimonial-card bg-white rounded-xl shadow-[0_5px_15px_rgba(0,0,0,0.05)] p-8">
                            <blockquote class="text-lg text-[#555] italic mb-6">"A fantastic bit of feedback"</blockquote>
                            <div class="testimonial-author flex items-center">
                                <div class="author-image w-12 h-12 bg-[#e0e0e0] rounded-full flex items-center justify-center text-[#999]">MT</div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-[#2A3F5F]">Mike Thompson</h4>
                                    <p class="text-[#6B778C] text-sm">Literature Professor</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 3 -->
                        <div class="testimonial-card bg-white rounded-xl shadow-[0_5px_15px_rgba(0,0,0,0.05)] p-8">
                            <blockquote class="text-lg text-[#555] italic mb-6">"A genuinely glowing review"</blockquote>
                            <div class="testimonial-author flex items-center">
                                <div class="author-image w-12 h-12 bg-[#e0e0e0] rounded-full flex items-center justify-center text-[#999]">ED</div>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-[#2A3F5F]">Emily Davis</h4>
                                    <p class="text-[#6B778C] text-sm">Regular Reader</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA SECTION -->
            <section class="cta py-16 bg-white text-center">
                <h2 class="text-3xl font-bold text-[#2A3F5F] mb-8">Get Involved</h2>
                <div class="cta-buttons flex justify-center space-x-4">
                    <a href="#" class="px-8 py-3 bg-[#2A3F5F] text-white rounded-full hover:opacity-90">Join Now</a>
                    <a href="#" class="px-8 py-3 bg-[#E8E9EB] text-[#2A3F5F] rounded-full hover:bg-gray-300">Learn More</a>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-[#2A3F5F] text-white py-8 mt-12">
            <div class="container mx-auto px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">Baghdad Library</h3>
                        <p class="text-gray-400">Your go to library of endless, wonderful knowledge since 2010.</p>
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
                            <a href="#" class="text-gray-400 hover:text-white">FB</a>
                            <a href="#" class="text-gray-400 hover:text-white">TW</a>
                            <a href="#" class="text-gray-400 hover:text-white">IG</a>
                            <a href="#" class="text-gray-400 hover:text-white">PIN</a>
                        </div>
                        <p class="text-gray-400">Subscribe to our newsletter</p>
                        <div class="mt-2 flex">
                            <input type="email" placeholder="Your email" class="px-3 py-2 rounded-l-md text-gray-800 w-full focus:outline-none">
                            <button class="bg-[#2A3F5F] hover:opacity-90 px-4 py-2 rounded-r-md border-l border-gray-600">Subscribe</button>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                    <p>&copy; 2023 Baghdad Library. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>