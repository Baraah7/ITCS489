<?php include '../app/views/layout/header.php'; ?>
    <div class="max-w-screen-xl mx-auto w-full px-4">
        <!-- Header (same as other pages) -->
        <header style="background-color: #FFF9F4" class="shadow-md">
            <div class="container mx-auto px-4 py-6">
                <div class="flex flex-col items-center text-center mb-6">
                    <h1 class="text-5xl font-bold text-[#2A3F5F] mb-2">Baghdad</h1> 
                    <p class="text-gray-600 text-lg">Your go to library of endless, wonderful knowledge</p> 
                    <nav class="mt-6 space-x-4">
                        <a href="index.html" class="px-6 py-2 bg-[#2A3F5F] text-white rounded-full hover:opacity-90">Home</a>
                        <a href="help.html" class="px-6 py-2 bg-gray-200 text-[#2A3F5F] rounded-full hover:bg-gray-300">Help Center</a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Help Content -->
        <main class="py-12">
            <div class="container mx-auto px-4">
                <h1 class="text-4xl font-bold text-[#2A3F5F] mb-8 text-center">Help Center</h1>
                
                <!-- Search Help Section -->
                <div class="max-w-2xl mx-auto mb-12">
                    <div class="relative">
                        <input type="text" placeholder="Search help articles..." 
                               class="w-full px-6 py-4 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#2A3F5F]">
                        <button class="absolute right-2 top-2 bg-[#2A3F5F] text-white px-6 py-2 rounded-full hover:opacity-90">
                            Search
                        </button>
                    </div>
                </div>

                <!-- Help Categories -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">                    <!-- Category 1 -->
                    <div style="background-color: #D0B8A8" class="p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 bg-[#E8E9EB]rounded-full flex items-center justify-center mb-4">
                            <span class="text-2xl text-[#2A3F5F]">📚</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#2A3F5F] mb-3">Borrowing Books</h3>
                        <p class="text-gray-600 mb-4">Learn how to borrow, return, and renew books from our library.</p>
                        <a href="#" class="text-[#2A3F5F] font-medium hover:underline">View articles →</a>
                    </div>                    <!-- Category 2 -->
                    <div style="background-color: #D0B8A8" class="p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 bg-[#E8E9EB]rounded-full flex items-center justify-center mb-4">
                            <span class="text-2xl text-[#2A3F5F]">🔍</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#2A3F5F] mb-3">Finding Books</h3>
                        <p class="text-gray-600 mb-4">How to search our catalog and locate books in the library.</p>
                        <a href="#" class="text-[#2A3F5F] font-medium hover:underline">View articles →</a>
                    </div>                    <!-- Category 3 -->
                    <div style="background-color: #D0B8A8" class="p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 bg-[#E8E9EB]rounded-full flex items-center justify-center mb-4">
                            <span class="text-2xl text-[#2A3F5F]">💻</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#2A3F5F] mb-3">Digital Resources</h3>
                        <p class="text-gray-600 mb-4">Access e-books, audiobooks, and online databases.</p>
                        <a href="#" class="text-[#2A3F5F] font-medium hover:underline">View articles →</a>
                    </div>
                </div>

                <!-- Popular Questions -->
                <div class="max-w-3xl mx-auto">
                    <h2 class="text-2xl font-bold text-[#2A3F5F] mb-6">Frequently Asked Questions</h2>
                    
                    <!-- FAQ Accordion -->
                    <div class="space-y-4">
                        <!-- FAQ Item 1 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="faq-toggle w-full flex justify-between items-center p-4 bg-[#F5F6F7] hover:bg-gray-100">
                                <h3 class="text-lg font-medium text-[#2A3F5F] text-left">How do I get a library card?</h3>
                                <span class="text-[#2A3F5F] text-xl">+</span>
                            </button>                            <div class="faq-content hidden p-4" style="background-color: #D0B8A8">
                                <p class="text-gray-600">You can apply for a library cardat any of our branches by presenting a valid photo ID and proof of address. You can also start the application process online through our website.</p>
                            </div>
                        </div>

                        <!-- FAQ Item 2 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="faq-toggle w-full flex justify-between items-center p-4 bg-[#F5F6F7] hover:bg-gray-100">
                                <h3 class="text-lg font-medium text-[#2A3F5F] text-left">What are your opening hours?</h3>
                                <span class="text-[#2A3F5F] text-xl">+</span>
                            </button>
                            <div class="faq-content hidden p-4 bg-white">
                                <p class="text-gray-600">Our main branch is open Monday-Friday from 9am to 8pm, and Saturday-Sunday from 10am to 6pm. Some neighborhood branches may have different hours. Please check our Locations page for specific branch hours.</p>
                            </div>
                        </div>

                        <!-- FAQ Item 3 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="faq-toggle w-full flex justify-between items-center p-4 bg-[#F5F6F7] hover:bg-gray-100">
                                <h3 class="text-lg font-medium text-[#2A3F5F] text-left">Can I renew my borrowed items online?</h3>
                                <span class="text-[#2A3F5F] text-xl">+</span>
                            </button>
                            <div class="faq-content hidden p-4 bg-white">
                                <p class="text-gray-600">Yes! You can renew items through your online account on our website or through our mobile app, provided no one else has placed a hold on the item. Most items can be renewed up to 3 times.</p>
                            </div>
                        </div>

                        <!-- FAQ Item 4 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="faq-toggle w-full flex justify-between items-center p-4 bg-[#F5F6F7] hover:bg-gray-100">
                                <h3 class="text-lg font-medium text-[#2A3F5F] text-left">How do I access e-books?</h3>
                                <span class="text-[#2A3F5F] text-xl">+</span>
                            </button>
                            <div class="faq-content hidden p-4 bg-white">
                                <p class="text-gray-600">Our e-book collection is available through the Libby app. Simply download the app, select Baghdad Library as your library, and log in with your library card number and PIN. You can then browse and borrow from our digital collection.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="mt-16 bg-[#F5F6F7] rounded-xl p-8">
                    <h2 class="text-2xl font-bold text-[#2A3F5F] mb-4">Still need help?</h2>
                    <p class="text-gray-600 mb-6">Our friendly staff are ready to assist you with any questions.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Contact Method 1 -->
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h3 class="font-bold text-[#2A3F5F] mb-2">📞 Phone Support</h3>
                            <p class="text-gray-600 mb-3">Call us during business hours</p>
                            <a href="tel:+1234567890" class="text-lg font-medium text-[#2A3F5F] hover:underline">+1 (234) 567-890</a>
                        </div>

                        <!-- Contact Method 2 -->
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h3 class="font-bold text-[#2A3F5F] mb-2">✉️ Email Us</h3>
                            <p class="text-gray-600 mb-3">We'll respond within 24 hours</p>
                            <a href="mailto:help@baghdadlibrary.com" class="text-lg font-medium text-[#2A3F5F] hover:underline">help@baghdadlibrary.com</a>
                        </div>

                        <!-- Contact Method 3 -->
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h3 class="font-bold text-[#2A3F5F] mb-2">📍 Visit Us</h3>
                            <p class="text-gray-600 mb-3">Get in-person assistance</p>
                            <p class="text-lg font-medium text-[#2A3F5F]">123 Knowledge St, Baghdad</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer (same as other pages) -->
        <?php include '../app/views/layout/footer.php'; ?>    <!-- JavaScript -->
    <script src="../../public/js/help.js"></script>
</body>
</html>