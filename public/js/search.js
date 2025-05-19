// Debug to verify script is loading
console.log('Search script loaded!');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content loaded!');
    
    // Only initialize search functionality if we're on the search page
    const isSearchPage = document.getElementById('search-page');
    
    // These are elements used in multiple pages
    const cartCount = document.getElementById('cart-count');

    // Search page specific elements
    let searchInput, searchBtn, categoryFilter, authorFilter, minPrice, maxPrice;
    let yearFilter, sortBy, resultsContainer, pagination, prevPageBtn, nextPageBtn;
    let pageNumbers, advancedSearchToggle, advancedSearch;
    
    if (isSearchPage) {
        searchInput = document.getElementById('search-input');
        searchBtn = document.getElementById('search-btn');
        categoryFilter = document.getElementById('category-filter');
        authorFilter = document.getElementById('author-filter');
        minPrice = document.getElementById('min-price');
        maxPrice = document.getElementById('max-price');
        yearFilter = document.getElementById('year-filter');
        sortBy = document.getElementById('sort-by');
        resultsContainer = document.getElementById('results-container');
        pagination = document.getElementById('pagination');
        prevPageBtn = document.getElementById('prev-page');
        nextPageBtn = document.getElementById('next-page');
        pageNumbers = document.getElementById('page-numbers');
        advancedSearchToggle = document.getElementById('advanced-search-toggle');
        advancedSearch = document.getElementById('advanced-search');
    }    // Initialize shared functionality
    updateCartCount(); // This will work on any page

    // Only proceed with search functionality if we're on the search page
    if (!isSearchPage) return;

    // Debug log DOM elements
    console.log('Search page elements found:', {
        searchInput: !!searchInput,
        searchBtn: !!searchBtn,
        categoryFilter: !!categoryFilter,
        resultsContainer: !!resultsContainer,
    });

    // State
    let currentPage = 1;
    const booksPerPage = 8;

    // Function to fetch books from API
    async function fetchBooks(searchParams = {}) {
        try {
            console.log('Fetching books with params:', searchParams);
            const queryString = new URLSearchParams(searchParams).toString();
            const url = `/ITCS489/public/index.php?route=search/api&${queryString}`;
            console.log('API URL:', url);

            const response = await fetch(url);
            console.log('API Response status:', response.status);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('API Response data:', data);

            if (data.success) {
                return data.books;
            }
            console.error('API error:', data.error || 'Unknown error');
            return [];
        } catch (error) {
            console.error('Error fetching books:', error);
            return [];
        }
    }

    // Pagination utilities
    function setupPagination(totalBooks) {
        if (!pagination || !pageNumbers || !prevPageBtn || !nextPageBtn) return;

        const totalPages = Math.ceil(totalBooks / booksPerPage);
        
        if (totalPages <= 1) {
            pagination.classList.add('hidden');
            return;
        }

        pagination.classList.remove('hidden');
        pageNumbers.innerHTML = '';

        // Previous button
        prevPageBtn.disabled = currentPage === 1;
        prevPageBtn.classList.toggle('opacity-50', currentPage === 1);

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.className = `px-3 py-2 border border-gray-300 ${currentPage === i ? 'bg-[#2A3F5F] text-white' : 'bg-white text-gray-500 hover:bg-gray-50'}`;
            button.textContent = i;
            button.addEventListener('click', () => {
                currentPage = i;
                displayBooks(currentBooks, i);
            });
            pageNumbers.appendChild(button);
        }

        // Next button
        nextPageBtn.disabled = currentPage === totalPages;
        nextPageBtn.classList.toggle('opacity-50', currentPage === totalPages);
    }

    // Function to display books
    function displayBooks(books, page = 1) {
        if (!resultsContainer) {
            console.error('Results container not found');
            return;
        }

        console.log('Displaying books:', books);
        currentBooks = books; // Store the current books
        currentPage = page;
        const startIndex = (page - 1) * booksPerPage;
        const endIndex = startIndex + booksPerPage;
        const paginatedBooks = books.slice(startIndex, endIndex);

        if (books.length === 0) {
            resultsContainer.innerHTML = `
                <div class="col-span-full text-center py-12 text-gray-500">
                    <i class="fas fa-book-open fa-3x mb-4"></i>
                    <p>No books found matching your search criteria</p>
                </div>
            `;
            if (pagination) {
                pagination.classList.add('hidden');
            }
            return;
        }        resultsContainer.innerHTML = paginatedBooks.map(book => `
            <div class="book-card rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow cursor-pointer" 
                 style="background-color: #D0B8A8"
                 data-id="${book.id}"
                 onclick="if (!event.target.closest('.add-to-cart')) window.location.href='/ITCS489/public/index.php?route=book/show&id=${book.id}'">
                <div class="relative pb-48 overflow-hidden">
                    <img src="${book.cover || '/ITCS489/public/Images/books1.png'}" 
                         alt="${book.title}" 
                         class="absolute inset-0 w-full h-full object-contain p-4">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2 text-gray-900 line-clamp-2">${book.title}</h3>
                    <p class="text-gray-600 text-sm mb-2">${book.author || 'Unknown Author'}</p>
                    <div class="flex items-center mb-2">
                        ${Array(Math.ceil(book.rating || 0)).fill('<i class="fas fa-star text-yellow-400"></i>').join('')}
                        ${book.rating % 1 ? '<i class="fas fa-star-half-alt text-yellow-400"></i>' : ''}
                        ${Array(5 - Math.ceil(book.rating || 0)).fill('<i class="far fa-star text-yellow-400"></i>').join('')}
                        <span class="text-gray-500 text-sm ml-1">${book.rating || 'N/A'}</span>
                    </div>
                    <p class="text-gray-700 text-sm mb-3 line-clamp-2">${book.description || ''}</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-lg">$${(book.price || 0).toFixed(2)}</span>
                        <button class="add-to-cart text-white px-3 py-1 rounded-md text-sm" 
                                style="background-color: #2A3F5F; hover:opacity-90" 
                                data-id="${book.id}">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        `).join('');

        setupPagination(books.length);
    }    // Function to collect all search parameters
    function getSearchParams() {
        return {
            q: searchInput?.value?.trim() || '',
            category: categoryFilter?.value?.trim() || '',
            author: authorFilter?.value?.trim() || '',
            minPrice: parseFloat(minPrice?.value) || '',
            maxPrice: parseFloat(maxPrice?.value) || '',
            year: parseInt(yearFilter?.value) || '',
            sort: sortBy?.value || 'relevance'
        };
    }

    // Function to validate price range
    function validatePriceRange() {
        const min = parseFloat(minPrice?.value);
        const max = parseFloat(maxPrice?.value);
        
        if (!isNaN(min) && !isNaN(max) && min > max) {
            showNotification('Minimum price cannot be greater than maximum price', 'error');
            return false;
        }
        return true;
    }

    // Function to reset all filters
    function resetFilters() {
        if (searchInput) searchInput.value = '';
        if (categoryFilter) categoryFilter.value = '';
        if (authorFilter) authorFilter.value = '';
        if (minPrice) minPrice.value = '';
        if (maxPrice) maxPrice.value = '';
        if (yearFilter) yearFilter.value = '';
        if (sortBy) sortBy.value = 'relevance';
    }

    // Perform search with current filters
    async function performSearch(searchTerm) {
        if (!resultsContainer) {
            showNotification('Error: Results container not found. Please refresh the page.', 'error');
            return;
        }

        try {
            if (!validatePriceRange()) return;

            const searchParams = getSearchParams();
            if (searchTerm !== undefined) {
                searchParams.q = searchTerm;
            }
            
            resultsContainer.innerHTML = `
                <div class="col-span-full flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#2A3F5F]"></div>
                </div>
            `;
            
            const books = await fetchBooks(searchParams);
            displayBooks(books);
        } catch (error) {
            console.error('Search error:', error);
            showNotification('An error occurred while searching. Please try again.', 'error');
            resultsContainer.innerHTML = '<div class="error">An error occurred while searching. Please try again.</div>';
        }
    }

    // Function to show notification
    function showNotification(message, type = 'info') {
        // Remove any existing notifications
        const existingNotifications = document.querySelectorAll('.notification-overlay');
        existingNotifications.forEach(notification => notification.remove());

        // Create overlay
        const overlay = document.createElement('div');
        overlay.className = 'notification-overlay fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';

        // Create notification container
        const notification = document.createElement('div');
        notification.className = `notification p-4 rounded-lg shadow-lg max-w-md w-full mx-4 relative 
            ${type === 'error' ? 'bg-red-100 border-red-400 text-red-700' : 
              type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 
              'bg-blue-100 border-blue-400 text-blue-700'}`;

        // Add icon based on type
        const icon = document.createElement('span');
        icon.className = 'absolute left-4 top-4';
        icon.innerHTML = type === 'error' ? '❌' : 
                        type === 'success' ? '✅' : 
                        'ℹ️';

        // Add message
        const messageElement = document.createElement('div');
        messageElement.className = 'ml-8 mr-8';
        messageElement.textContent = message;

        // Add close button
        const closeButton = document.createElement('button');
        closeButton.className = 'absolute right-2 top-2 text-gray-600 hover:text-gray-800';
        closeButton.innerHTML = '×';
        closeButton.onclick = () => overlay.remove();

        // Assemble notification
        notification.appendChild(icon);
        notification.appendChild(messageElement);
        notification.appendChild(closeButton);
        overlay.appendChild(notification);
        document.body.appendChild(overlay);

        // Add fade-in animation
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        notification.style.transition = 'opacity 0.3s ease-in-out, transform 0.3s ease-in-out';
        
        // Trigger animation
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 10);

        // Auto-dismiss after 3 seconds
        setTimeout(() => {
            if (overlay.parentNode) {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-20px)';
                setTimeout(() => overlay.remove(), 300);
            }
        }, 3000);

        // Close on click outside
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.remove();
            }
        });
    }

    // Function to update cart count
    async function updateCartCount() {
        try {
            const response = await fetch('/ITCS489/public/index.php?route=order/count', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            let contentType = response.headers.get("content-type");
            if (!contentType) {
                throw new TypeError("No content type header received");
            }
            contentType = contentType.toLowerCase();
            if (!contentType.includes("application/json")) {
                console.error("Unexpected content type:", contentType);
                throw new TypeError("Server sent an invalid response format");
            }

            const data = await response.json();
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = data.count || '0';
            }
        } catch (error) {
            console.error('Error updating cart count:', error);
            // Don't show error to user since this is a background operation
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = '0';
            }
        }
    }

    // Add to cart functionality
    if (resultsContainer) {
        resultsContainer.addEventListener('click', async function(e) {
            if (e.target.classList.contains('add-to-cart')) {
                e.preventDefault();
                e.stopPropagation();
                const bookId = e.target.dataset.id;
                if (!bookId) return;

                try {
                    const response = await fetch('/ITCS489/public/index.php?route=order/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: `book_id=${bookId}&quantity=1`
                    });

                    if (!response.ok) {
                        try {
                            const errorData = await response.json();
                            throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                        } catch (e) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                    }

                    let contentType = response.headers.get("content-type");
                    if (!contentType) {
                        throw new TypeError("No content type header received");
                    }
                    contentType = contentType.toLowerCase();
                    if (!contentType.includes("application/json")) {
                        console.error("Unexpected content type:", contentType);
                        throw new TypeError("Server sent an invalid response format");
                    }

                    const data = await response.json();
                    showNotification(data.message || 'Book added to cart successfully', data.success ? 'success' : 'error');
                    if (data.success) {
                        await updateCartCount();
                    }
                } catch (error) {
                    console.error('Error adding to cart:', error);
                    showNotification(error.message || 'Failed to add book to cart. Please try again.', 'error');
                }
            }
        });
    }

    // Add click event for book details
    if (resultsContainer) {
        resultsContainer.addEventListener('click', function(e) {
            const bookCard = e.target.closest('.book-card');
            if (bookCard && !e.target.classList.contains('add-to-cart')) {
                const bookId = bookCard.dataset.id;
                if (bookId) {
                    window.location.href = `/ITCS489/public/index.php?route=book/show&id=${bookId}`;
                }
            }
        });
    }

    // Initial cart count update
    updateCartCount();

    // Event listeners
    if (searchBtn) {
        searchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            performSearch();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });
    }    // Event listeners for filters
    if (sortBy) {
        sortBy.addEventListener('change', () => performSearch());
    }

    if (categoryFilter) {
        categoryFilter.addEventListener('change', () => performSearch());
    }

    // Advanced search toggle
    if (advancedSearchToggle) {
        advancedSearchToggle.addEventListener('click', function() {
            if (advancedSearch) {
                advancedSearch.classList.toggle('hidden');
                const icon = advancedSearchToggle.querySelector('i');
                if (icon) {
                    if (advancedSearch.classList.contains('hidden')) {
                        icon.classList.remove('fa-caret-up');
                        icon.classList.add('fa-caret-down');
                    } else {
                        icon.classList.remove('fa-caret-down');
                        icon.classList.add('fa-caret-up');
                    }
                }
            }
        });
    }

    // Reset filters button
    const resetFiltersBtn = document.getElementById('reset-filters');
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', () => {
            resetFilters();
            performSearch();
        });
    }

    // Apply filters button
    const applyFiltersBtn = document.getElementById('apply-filters');
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', () => performSearch());
    }

    // Price range validation
    if (minPrice && maxPrice) {
        minPrice.addEventListener('change', validatePriceRange);
        maxPrice.addEventListener('change', validatePriceRange);
    }

    // Event listeners for pagination
    if (prevPageBtn) {
        prevPageBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                displayBooks(currentBooks, currentPage);
            }
        });
    }

    if (nextPageBtn) {
        nextPageBtn.addEventListener('click', () => {
            const totalPages = Math.ceil((currentBooks?.length || 0) / booksPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                displayBooks(currentBooks, currentPage);
            }
        });
    }

    // Initial search
    const urlParams = new URLSearchParams(window.location.search);
    const initialQuery = urlParams.get('q');
    if (initialQuery && searchInput) {
        searchInput.value = decodeURIComponent(initialQuery);
    }
    performSearch();
});
