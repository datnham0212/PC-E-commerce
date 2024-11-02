document.addEventListener('DOMContentLoaded', () => {
    const searchIcon = document.querySelector('.search-icon');
    const searchBarContainer = document.querySelector('.search-container');
    const searchBar = document.querySelector('.search-bar');
    const suggestionsBox = document.querySelector('.suggestions');

    let products = [];

    // Fetch products from Flask backend when the page loads
    fetch('/product_catalog/api/products')
        .then(response => response.json())
        .then(data => {
            products = data.products;
        })
        .catch(error => console.error('Error fetching products:', error));

    // Show/hide search bar when button is clicked
    searchIcon.addEventListener('click', () => {
        searchBarContainer.classList.toggle('show-search-bar');
        searchBar.focus();
    });

    // Search and show suggestions when typing
    searchBar.addEventListener('input', () => {
        const searchTerm = searchBar.value.toLowerCase();
        suggestionsBox.innerHTML = ''; // Clear previous suggestions
        if (searchTerm) {
            const filteredProducts = products.filter(product => 
                product.name.toLowerCase().includes(searchTerm)
            );

            filteredProducts.forEach(product => {
                const suggestionItem = document.createElement('div');
                suggestionItem.classList.add('suggestion-item');
                suggestionItem.textContent = product.name;
                suggestionItem.addEventListener('click', () => {
                    window.location.href = product.link;
                });
                suggestionsBox.appendChild(suggestionItem);
            });
            
            suggestionsBox.style.display = 'block';
            document.querySelector('.product-grid').style.marginTop = '220px'; // Đẩy xuống khi gợi ý xuất hiện
        } else {
            suggestionsBox.style.display = 'none';
            document.querySelector('.product-grid').style.marginTop = '0'; // Trở về vị trí ban đầu
        }
    });

    // Hide suggestions when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.search-container') && !e.target.closest('.search-icon')) {
            searchBarContainer.classList.remove('show-search-bar');
            suggestionsBox.style.display = 'none';
        }
    });
});
