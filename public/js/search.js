document.addEventListener('DOMContentLoaded', function() {
    // Sample book data - in a real app, this would come from an API
    const books = [
        {
            id: 1,
            title: "The Silent Patient",
            author: "Alex Michaelides",
            price: 12.99,
            rating: 4.5,
            category: "mystery",
            year: 2019,
            cover: "https://m.media-amazon.com/images/I/71hTq4QqgBL._AC_UF1000,1000_QL80_.jpg",
            description: "A psychological thriller about a woman who shoots her husband and then stops speaking."
        },
        {
            id: 2,
            title: "Educated",
            author: "Tara Westover",
            price: 14.95,
            rating: 4.7,
            category: "biography",
            year: 2018,
            cover: "https://m.media-amazon.com/images/I/71I7snGfQVL._AC_UF1000,1000_QL80_.jpg",
            description: "A memoir about a woman who leaves her survivalist family and goes on to earn a PhD from Cambridge University."
        },
        {
            id: 3,
            title: "Dune",
            author: "Frank Herbert",
            price: 9.99,
            rating: 4.8,
            category: "science",
            year: 1965,
            cover: "https://m.media-amazon.com/images/I/81ym3QUd3KL._AC_UF1000,1000_QL80_.jpg",
            description: "A science fiction novel about a desert planet and the boy who would become its messiah."
        },
        {
            id: 4,
            title: "The Midnight Library",
            author: "Matt Haig",
            price: 13.49,
            rating: 4.2,
            category: "fiction",
            year: 2020,
            cover: "https://m.media-amazon.com/images/I/81Kc8OsbDxL._AC_UF1000,1000_QL80_.jpg",
            description: "A novel about a library between life and death where each book represents a different life path."
        },
        {
            id: 5,
            title: "Atomic Habits",
            author: "James Clear",
            price: 11.98,
            rating: 4.6,
            category: "non-fiction",
            year: 2018,
            cover: "https://m.media-amazon.com/images/I/91bYsX41DVL._AC_UF1000,1000_QL80_.jpg",
            description: "A guide to building good habits and breaking bad ones with tiny changes."
        },
        {
            id: 6,
            title: "The Hobbit",
            author: "J.R.R. Tolkien",
            price: 8.99,
            rating: 4.9,
            category: "fantasy",
            year: 1937,
            cover: "https://m.media-amazon.com/images/I/710+HcoP38L._AC_UF1000,1000_QL80_.jpg",
            description: "A fantasy novel about a hobbit who goes on an adventure with a group of dwarves."
        },
        {
            id: 7,
            title: "Where the Crawdads Sing",
            author: "Delia Owens",
            price: 10.49,
            rating: 4.8,
            category: "fiction",
            year: 2018,
            cover: "https://m.media-amazon.com/images/I/81O1oy0y9eL._AC_UF1000,1000_QL80_.jpg",
            description: "A novel about a girl who raises herself in the marshes of North Carolina."
        },
        {
            id: 8,
            title: "The Song of Achilles",
            author: "Madeline Miller",
            price: 12.99,
            rating: 4.6,
            category: "romance",
            year: 2011,
            cover: "https://m.media-amazon.com/images/I/91Q9Skk9JhL._AC_UF1000,1000_QL80_.jpg",
            description: "A retelling of the Iliad from the perspective of Patroclus, Achilles' lover."
        }
    ];

    // DOM Elements
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search-btn');
    const categoryFilter = document.getElementById('category-filter');
    const authorFilter = document.getElementById('author-filter');
    const minPrice = document.getElementById('min-price');
    const maxPrice = document.getElementById('max-price');
    const yearFilter = document.getElementById('year-filter');
    const sortBy = document.getElementById('sort-by');
    const resultsContainer = document.getElementById('results-container');
    const pagination = document.getElementById('pagination');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const pageNumbers = document.getElementById('page-numbers');
    const advancedSearchToggle = document.getElementById('advanced-search-toggle');
    const advancedSearch = document.getElementById('advanced-search');
    const applyFiltersBtn = document.getElementById('apply-filters');
    const resetFiltersBtn = document.getElementById('reset-filters');
    const cartBtn = document.getElementById('cart-btn');
    const cartCount = document.getElementById('cart-count');

    // State
    let currentPage = 1;
    const booksPerPage = 8;
    let cartItems = [];

    // Toggle advanced search
    advancedSearchToggle.addEventListener('click', function() {
        advancedSearch.classList.toggle('hidden');
        const icon = advancedSearchToggle.querySelector('i');
        if (advancedSearch.classList.contains('hidden')) {
            icon.classList.remove('fa-caret-up');
            icon.classList.add('fa-caret-down');
        } else {
            icon.classList.remove('fa-caret-down');
            icon.classList.add('fa-caret-up');
        }
    });

    // Search and filter functions
    function searchBooks() {
        const searchTerm = searchInput.value.toLowerCase();
        const category = categoryFilter.value;
        const author = authorFilter.value.toLowerCase();
        const min = minPrice.value ? parseFloat(minPrice.value) : null;
        const max = maxPrice.value ? parseFloat(maxPrice.value) : null;
        const year = yearFilter.value ? parseInt(yearFilter.value) : null;

        return books.filter(book => {
            // Search term matches title or author
            const matchesSearch = !searchTerm || 
                book.title.toLowerCase().includes(searchTerm) || 
                book.author.toLowerCase().includes(searchTerm);

            // Category filter
            const matchesCategory = !category || book.category === category;

            // Author filter
            const matchesAuthor = !author || book.author.toLowerCase().includes(author);

            // Price range
            const matchesPrice = (!min || book.price >= min) && (!max || book.price <= max);

            // Year
            const matchesYear = !year || book.year === year;

            return matchesSearch && matchesCategory && matchesAuthor && matchesPrice && matchesYear;
        });
    }

    // Sort books
    function sortBooks(filteredBooks) {
        const sortValue = sortBy.value;
        
        return [...filteredBooks].sort((a, b) => {
            switch(sortValue) {
                case 'price-low':
                    return a.price - b.price;
                case 'price-high':
                    return b.price - a.price;
                case 'title-asc':
                    return a.title.localeCompare(b.title);
                case 'title-desc':
                    return b.title.localeCompare(a.title);
                case 'newest':
                    return b.year - a.year;
                case 'rating':
                    return b.rating - a.rating;
                default: // relevance
                    return 0;
            }
        });
    }

    // Display books
    function displayBooks(filteredBooks, page = 1) {
        currentPage = page;
        const startIndex = (page - 1) * booksPerPage;
        const endIndex = startIndex + booksPerPage;
        const paginatedBooks = filteredBooks.slice(startIndex, endIndex);

        if (filteredBooks.length === 0) {
            resultsContainer.innerHTML = `
                <div class="col-span-full text-center py-12 text-gray-500">
                    <i class="fas fa-book-open fa-3x mb-4"></i>
                    <p>No books found matching your search criteria</p>
                </div>
            `;
            pagination.classList.add('hidden');
            return;
        }

        resultsContainer.innerHTML = paginatedBooks.map(book => `
            <div class="rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow" style="background-color: #D0B8A8">
                <div class="relative pb-48 overflow-hidden">
                    <img src="${book.cover}" alt="${book.title}" class="absolute inset-0 w-full h-full object-contain p-4">
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg mb-1 truncate">${book.title}</h3>
                    <p class="text-gray-600 text-sm mb-2">${book.author}</p>
                    <div class="flex items-center mb-2">
                        ${Array(Math.floor(book.rating)).fill('<i class="fas fa-star text-yellow-400"></i>').join('')}
                        ${book.rating % 1 ? '<i class="fas fa-star-half-alt text-yellow-400"></i>' : ''}
                        ${Array(5 - Math.ceil(book.rating)).fill('<i class="far fa-star text-yellow-400"></i>').join('')}
                        <span class="text-gray-500 text-sm ml-1">${book.rating}</span>
                    </div>
                    <p class="text-gray-700 text-sm mb-3 line-clamp-2">${book.description}</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-lg">$${book.price.toFixed(2)}</span>
                        <button class="add-to-cart text-white px-3 py-1 rounded-md text-sm" style="background-color: #2A3F5F; hover:opacity-90" data-id="${book.id}">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        `).join('');

        // Setup pagination
        setupPagination(filteredBooks.length);
    }

    // Setup pagination
    function setupPagination(totalBooks) {
        const totalPages = Math.ceil(totalBooks / booksPerPage);
        
        if (totalPages <= 1) {
            pagination.classList.add('hidden');
            return;
        }
        
        pagination.classList.remove('hidden');
        prevPageBtn.disabled = currentPage === 1;
        
        // Clear existing page numbers
        pageNumbers.innerHTML = '';
        
        // Add page numbers
        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.className = `px-3 py-2 border-t border-b border-gray-300 bg-white ${currentPage === i ? 'text-blue-600 font-bold' : 'text-gray-500 hover:bg-gray-50'}`;
            pageBtn.textContent = i;
            pageBtn.addEventListener('click', () => {
                const filteredBooks = sortBooks(searchBooks());
                displayBooks(filteredBooks, i);
            });
            pageNumbers.appendChild(pageBtn);
        }
        
        // Next button event
        nextPageBtn.addEventListener('click', () => {
            if (currentPage < totalPages) {
                const filteredBooks = sortBooks(searchBooks());
                displayBooks(filteredBooks, currentPage + 1);
            }
        });
        
        // Previous button event
        prevPageBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                const filteredBooks = sortBooks(searchBooks());
                displayBooks(filteredBooks, currentPage - 1);
            }
        });
    }

    // Add to cart
    function addToCart(bookId) {
        const book = books.find(b => b.id === bookId);
        if (book) {
            cartItems.push(book);
            cartCount.textContent = cartItems.length;
            
            // Show notification
            const notification = document.createElement('div');
            notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg flex items-center';
            notification.innerHTML = `
                <i class="fas fa-check-circle mr-2"></i>
                Added "${book.title}" to cart
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => notification.remove(), 500);
            }, 2000);
        }
    }

    // Event listeners
    searchBtn.addEventListener('click', function() {
        const filteredBooks = sortBooks(searchBooks());
        displayBooks(filteredBooks);
    });

    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const filteredBooks = sortBooks(searchBooks());
            displayBooks(filteredBooks);
        }
    });

    [categoryFilter, sortBy].forEach(element => {
        element.addEventListener('change', function() {
            const filteredBooks = sortBooks(searchBooks());
            displayBooks(filteredBooks);
        });
    });

    applyFiltersBtn.addEventListener('click', function() {
        const filteredBooks = sortBooks(searchBooks());
        displayBooks(filteredBooks);
    });

    resetFiltersBtn.addEventListener('click', function() {
        searchInput.value = '';
        categoryFilter.value = '';
        authorFilter.value = '';
        minPrice.value = '';
        maxPrice.value = '';
        yearFilter.value = '';
        sortBy.value = 'relevance';
        
        const filteredBooks = sortBooks(searchBooks());
        displayBooks(filteredBooks);
    });

    // Event delegation for add to cart buttons
    resultsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-to-cart') || e.target.closest('.add-to-cart')) {
            const button = e.target.classList.contains('add-to-cart') ? e.target : e.target.closest('.add-to-cart');
            const bookId = parseInt(button.getAttribute('data-id'));
            addToCart(bookId);
        }
    });

    // Cart button
    cartBtn.addEventListener('click', function() {
        alert(`You have ${cartItems.length} items in your cart.`);
    });

    // Initial display
    displayBooks(books);
});
