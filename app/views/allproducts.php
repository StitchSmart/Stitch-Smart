<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Products | <?= APP_NAME ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>

<link rel="stylesheet" href="<?= BASE_URL ?>css/navbar.css">
<link rel="stylesheet" href="<?= BASE_URL ?>css/colors.css">
<link rel="stylesheet" href="<?= BASE_URL ?>css/footer.css">
<link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
<link href="<?= BASE_URL ?>css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">

<style>
/* PREMIUM CONTAINER AND WRAPPER */
.shop-container {
    padding: 60px 0;
    font-family: var(--font-body, 'Inter'), sans-serif;
    color: var(--text-main, #3d241c);
}

/* FILTERS SIDEBAR */
.filters-sidebar {
    background: var(--bg-card, rgba(255, 255, 255, 0.9));
    border: 1px solid var(--border-color, rgba(193, 154, 78, 0.15));
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    position: sticky;
    top: 100px;
    transition: all 0.3s ease;
}

.filters-sidebar:hover {
    box-shadow: 0 15px 40px rgba(0,0,0,0.06);
}

.filters-title {
    font-family: var(--font-headings, 'Playfair Display'), 'Outfit', serif;
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 30px;
    color: var(--text-main, #3d241c);
    border-bottom: 2px solid var(--accent-bronze, #CD9A48);
    padding-bottom: 12px;
}

.filter-group {
    margin-bottom: 35px;
}

.filter-group-title {
    font-family: var(--font-headings, 'Playfair Display'), 'Outfit', serif;
    font-size: 1.35rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: capitalize;
    color: var(--accent-brown, #5c3c26);
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--border-color, rgba(193, 154, 78, 0.15));
    padding-bottom: 8px;
}

/* Custom Styled Checkboxes */
.custom-checkbox-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.custom-checkbox-item {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 0.95rem;
    font-weight: 500;
    transition: color 0.2s ease;
    user-select: none;
}

.custom-checkbox-item:hover {
    color: var(--accent-bronze, #CD9A48);
}

.custom-checkbox-input {
    display: none;
}

.custom-checkbox-box {
    width: 20px;
    height: 20px;
    border: 2px solid var(--accent-bronze, #CD9A48);
    border-radius: 6px;
    margin-right: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    background: transparent;
}

.custom-checkbox-input:checked + .custom-checkbox-box {
    background: var(--accent-bronze, #CD9A48);
}

.custom-checkbox-box::after {
    content: "\f00c";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    color: #fff;
    font-size: 10px;
    display: none;
}

.custom-checkbox-input:checked + .custom-checkbox-box::after {
    display: block;
}

/* Price Range Slider */
.price-slider-wrap {
    padding: 5px 0;
}

.custom-range {
    -webkit-appearance: none;
    width: 100%;
    height: 6px;
    border-radius: 5px;
    background: var(--border-color, rgba(193, 154, 78, 0.2));
    outline: none;
    transition: background 0.3s ease;
}

.custom-range::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: var(--accent-bronze, #CD9A48);
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    transition: transform 0.2s ease, background-color 0.2s ease;
}

.custom-range::-webkit-slider-thumb:hover {
    transform: scale(1.2);
    background-color: var(--accent-bronze-hover, #b08238);
}

.price-slider-values {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    font-weight: 600;
    margin-top: 12px;
    color: var(--text-muted, #5c3c26);
}

/* PRODUCT GRID AREA */
.grid-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    flex-wrap: wrap;
    gap: 15px;
}

.grid-title {
    font-family: var(--font-headings, 'Playfair Display'), 'Outfit', serif;
    font-size: 2.2rem;
    font-weight: 700;
    margin: 0;
    color: var(--text-main, #3d241c);
}

/* Custom Sort Dropdown */
.sort-select-wrapper {
    position: relative;
    width: 200px;
}

.sort-select {
    width: 100%;
    padding: 10px 18px;
    background: var(--bg-card, rgba(255, 255, 255, 0.9)) !important;
    border: 1px solid var(--border-color, rgba(193, 154, 78, 0.25)) !important;
    border-radius: 12px !important;
    font-size: 0.9rem !important;
    font-weight: 600 !important;
    color: var(--text-main, #3d241c) !important;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    transition: all 0.3s ease;
}

.sort-select:focus {
    outline: none;
    border-color: var(--accent-bronze, #CD9A48) !important;
    box-shadow: 0 0 10px rgba(193, 154, 78, 0.15);
}

.sort-select-wrapper::after {
    content: "\f078";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    font-size: 11px;
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--accent-bronze, #CD9A48);
    pointer-events: none;
}

/* PRODUCT CARDS */
.prod-grid-card {
    background: #ffffff !important; /* Pure white card background like the sample image */
    border: 1px solid var(--border-color, rgba(193, 154, 78, 0.15));
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.02);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
}

.prod-grid-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(193, 154, 78, 0.08);
    border-color: var(--accent-bronze, #CD9A48);
}

.prod-grid-img-wrap {
    background: #F5EFEB !important; /* Warm cream/tan wrapper background like the sample image */
    border: none;
    border-radius: 16px;
    height: 280px; /* Increased size to take up half of the complete card */
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-bottom: 20px;
    transition: all 0.3s ease;
    padding: 20px;
}

.prod-grid-card:hover .prod-grid-img-wrap {
    background: #EFE6D5 !important; /* Elegant hover darkening of the cream container */
}

.prod-grid-img-wrap img {
    max-width: 95%;
    max-height: 95%;
    object-fit: contain;
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}

.prod-grid-card:hover .prod-grid-img-wrap img {
    transform: scale(1.06);
}

.prod-grid-badge {
    background: rgba(193, 154, 78, 0.08);
    color: var(--accent-bronze, #CD9A48);
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 50px;
    display: inline-block;
    margin-bottom: 12px;
    width: fit-content;
}

.prod-grid-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--text-main, #3d241c);
    margin-bottom: 6px;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prod-grid-desc {
    font-size: 0.85rem;
    color: var(--text-muted, #5c3c26);
    margin-bottom: 20px;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex-grow: 1;
}

.prod-grid-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid var(--border-color, rgba(193, 154, 78, 0.08));
    padding-top: 16px;
    margin-top: auto;
}

.prod-grid-price-block {
    display: flex;
    flex-direction: column;
}

.prod-grid-price {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--accent-bronze, #CD9A48);
    line-height: 1;
}

.prod-grid-old-price {
    font-size: 0.82rem;
    color: var(--text-muted, #999);
    text-decoration: line-through;
    margin-top: 3px;
}

.prod-grid-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #000;
    border: none;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.prod-grid-card:hover .prod-grid-btn {
    background: var(--accent-bronze, #CD9A48);
    transform: rotate(90deg);
}

.prod-grid-btn i {
    font-size: 0.9rem;
}

/* PAGINATION */
.custom-pagination-wrap {
    display: flex;
    justify-content: center;
    margin-top: 50px;
}

.custom-pagination {
    display: flex;
    gap: 8px;
    list-style: none;
    padding: 0;
}

.custom-pagination-btn {
    padding: 10px 18px;
    border-radius: 12px;
    border: 1px solid var(--border-color, rgba(193, 154, 78, 0.2));
    background: var(--bg-card, rgba(255, 255, 255, 0.9));
    color: var(--text-main, #3d241c);
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.custom-pagination-btn:hover, .custom-pagination-btn.active {
    background: var(--accent-bronze, #CD9A48);
    border-color: var(--accent-bronze, #CD9A48);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(193, 154, 78, 0.15);
}

.custom-pagination-btn.disabled {
    opacity: 0.5;
    pointer-events: none;
}
</style>
</head>

<body>

<?php include('header.php'); ?>

<div class="main">

    <div class="shop-container">
        <div class="container">
            <div class="row g-4">
                
                <!-- Left Sidebar Filters (25% width) -->
                <div class="col-lg-3">
                    <div class="filters-sidebar">
                        <div class="filters-title">Filters</div>
                        
                        <!-- Categories Filter Group -->
                        <div class="filter-group">
                            <div class="filter-group-title">Category</div>
                            <div class="custom-checkbox-list" id="categoryChecklist">
                                <!-- Categories dynamically loaded via JS -->
                            </div>
                        </div>
                        
                        <!-- Price Range Filter Group -->
                        <div class="filter-group">
                            <div class="filter-group-title">Price Range</div>
                            <div class="price-slider-wrap">
                                <input type="range" id="priceSlider" class="custom-range" min="0" max="1000" value="1000" step="5">
                                <div class="price-slider-values">
                                    <span>$0</span>
                                    <span id="priceSliderLabel">$0 - $1000</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <!-- Right Products Grid (75% width) -->
                <div class="col-lg-9">
                    <div class="grid-header">
                        <h2 class="grid-title">All Products</h2>
                        
                        <div class="sort-select-wrapper">
                            <select id="sortSelect" class="sort-select">
                                <option value="featured">Sort: Featured</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                                <option value="name_az">Name: A to Z</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Products Grid -->
                    <div class="row g-4" id="productsGrid">
                        <!-- Products dynamically rendered here -->
                    </div>
                    
                    <!-- Empty State -->
                    <div id="emptyState" class="text-center py-5 d-none">
                        <h5 class="fw-bold">No products found</h5>
                        <p class="text-muted">Looks like the shelves are empty right now 👀 Try modifying your filters!</p>
                    </div>
                    
                    <!-- Pagination Controls -->
                    <div class="custom-pagination-wrap" id="paginationWrap">
                        <ul class="custom-pagination" id="paginationList">
                            <!-- Pagination dynamically loaded here -->
                        </ul>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>

</div>

<?php include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- FILTERING, SORTING, PAGINATION LOGIC -->
<script>
// Load full list of products injected securely from PHP
const allProducts = <?= json_encode($allProducts); ?>;
const categoriesTree = <?= json_encode($categories); ?>;
const baseUrl = "<?= BASE_URL ?>";

// Extract dynamic options
const prices = allProducts.map(p => parseFloat(p.price) || 0);
const maxProductPrice = prices.length ? Math.ceil(Math.max(...prices)) : 1000;

// Filter State
let selectedParentCategoryIds = [];
let currentPriceMax = maxProductPrice;
let currentSort = "featured";
let currentPage = 1;
const itemsPerPage = 6;

// Elements
const categoryChecklist = document.getElementById('categoryChecklist');
const priceSlider = document.getElementById('priceSlider');
const priceSliderLabel = document.getElementById('priceSliderLabel');
const productsGrid = document.getElementById('productsGrid');
const emptyState = document.getElementById('emptyState');
const sortSelect = document.getElementById('sortSelect');
const paginationList = document.getElementById('paginationList');

// Initialize Filters
function initFilters() {
    // Setup Price Range Slider Limits
    priceSlider.max = maxProductPrice;
    priceSlider.value = maxProductPrice;
    currentPriceMax = maxProductPrice;
    priceSliderLabel.innerText = `$0 - $${maxProductPrice}`;
    
    // Render Category Checkboxes based on parent categories from the database tree
    categoryChecklist.innerHTML = "";
    categoriesTree.forEach((parentCat) => {
        const id = `cat_${parentCat.c_id}`;
        const item = document.createElement('label');
        item.className = 'custom-checkbox-item';
        item.htmlFor = id;
        item.innerHTML = `
            <input type="checkbox" id="${id}" class="custom-checkbox-input" value="${parentCat.c_id}">
            <div class="custom-checkbox-box"></div>
            <span>${parentCat.c_name}</span>
        `;
        categoryChecklist.appendChild(item);
    });
    
    // Event listeners
    categoryChecklist.addEventListener('change', (e) => {
        if(e.target.classList.contains('custom-checkbox-input')) {
            const val = parseInt(e.target.value);
            if(e.target.checked) {
                selectedParentCategoryIds.push(val);
            } else {
                selectedParentCategoryIds = selectedParentCategoryIds.filter(id => id !== val);
            }
            currentPage = 1;
            applyFiltersAndRender();
        }
    });
    
    priceSlider.addEventListener('input', (e) => {
        currentPriceMax = parseFloat(e.target.value);
        priceSliderLabel.innerText = `$0 - $${currentPriceMax}`;
        currentPage = 1;
        applyFiltersAndRender();
    });
    
    sortSelect.addEventListener('change', (e) => {
        currentSort = e.target.value;
        currentPage = 1;
        applyFiltersAndRender();
    });
}

// Filter, Sort and Paginate
function applyFiltersAndRender() {
    // Compute all allowed category IDs based on checked parents (include children)
    let allowedCategoryIds = [];
    selectedParentCategoryIds.forEach(parentId => {
        allowedCategoryIds.push(parentId);
        const parent = categoriesTree.find(c => parseInt(c.c_id) === parentId);
        if (parent && parent.subs) {
            parent.subs.forEach(sub => {
                allowedCategoryIds.push(parseInt(sub.c_id));
            });
        }
    });

    // 1. Filtering
    let filtered = allProducts.filter(prod => {
        const prodCatId = parseInt(prod.parent_cat);
        const matchesCategory = selectedParentCategoryIds.length === 0 || allowedCategoryIds.includes(prodCatId);
        const matchesPrice = (parseFloat(prod.price) || 0) <= currentPriceMax;
        return matchesCategory && matchesPrice;
    });
    
    // 2. Sorting
    if (currentSort === "price_low") {
        filtered.sort((a, b) => (parseFloat(a.price) || 0) - (parseFloat(b.price) || 0));
    } else if (currentSort === "price_high") {
        filtered.sort((a, b) => (parseFloat(b.price) || 0) - (parseFloat(a.price) || 0));
    } else if (currentSort === "name_az") {
        filtered.sort((a, b) => (a.name || "").localeCompare(b.name || ""));
    } else {
        // "featured" default - sort by ID or featured column
        filtered.sort((a, b) => b.id - a.id);
    }
    
    // 3. Paginate
    const totalItems = filtered.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    currentPage = Math.min(currentPage, totalPages || 1);
    
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = Math.min(startIndex + itemsPerPage, totalItems);
    const paginatedItems = filtered.slice(startIndex, endIndex);
    
    // Render Products Grid
    renderGrid(paginatedItems);
    
    // Render Pagination
    renderPagination(totalPages);
    
    // Handle Empty State
    if(totalItems === 0) {
        emptyState.classList.remove('d-none');
        productsGrid.innerHTML = "";
    } else {
        emptyState.classList.add('d-none');
    }
}

// Render Products into Grid
function renderGrid(products) {
    productsGrid.innerHTML = "";
    products.forEach(prod => {
        const retailPrice = Math.round(parseFloat(prod.price) * 1.45) || (parseFloat(prod.price) + 40);
        
        // Dynamic bulletproof image URL resolution
        let cleanImgUrl = "";
        if (prod.image_url) {
            let path = prod.image_url.split(',')[0].trim();
            // strip leading slash if present
            if (path.startsWith('/')) {
                path = path.substring(1);
            }
            cleanImgUrl = baseUrl.endsWith('/') ? baseUrl + path : baseUrl + '/' + path;
        } else {
            cleanImgUrl = "https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=350&q=80"; // Premium fallback image
        }

        const card = document.createElement('div');
        card.className = "col-md-4 mb-4";
        card.innerHTML = `
            <div class="prod-grid-card">
                <div class="prod-grid-img-wrap">
                    <img src="${cleanImgUrl}" alt="${prod.name}" class="img-fluid">
                </div>
                <div class="prod-grid-badge">${prod.category || 'Collection'}</div>
                <h3 class="prod-grid-title">${prod.name}</h3>
                <p class="prod-grid-desc">${prod.description || 'Exclusive handcrafted luxury garment.'}</p>
                <div class="prod-grid-footer">
                    <div class="prod-grid-price-block">
                        <span class="prod-grid-price">$${prod.price}</span>
                        <span class="prod-grid-old-price">$${retailPrice}</span>
                    </div>
                    <a href="${baseUrl}index.php?page=product_show&id=${prod.id}">
                        <button class="prod-grid-btn" title="View Details">
                            <i class="fas fa-plus"></i>
                        </button>
                    </a>
                </div>
            </div>
        `;
        productsGrid.appendChild(card);
    });
}

// Render Pagination controls
function renderPagination(totalPages) {
    paginationList.innerHTML = "";
    if (totalPages <= 1) return;
    
    // Prev button
    const prevLi = document.createElement('li');
    prevLi.innerHTML = `<button class="custom-pagination-btn ${currentPage === 1 ? 'disabled' : ''}">Previous</button>`;
    prevLi.querySelector('button').addEventListener('click', () => {
        if(currentPage > 1) {
            currentPage--;
            applyFiltersAndRender();
            window.scrollTo({ top: 300, behavior: 'smooth' });
        }
    });
    paginationList.appendChild(prevLi);
    
    // Numbers
    for(let i = 1; i <= totalPages; i++) {
        const numLi = document.createElement('li');
        numLi.innerHTML = `<button class="custom-pagination-btn ${currentPage === i ? 'active' : ''}">${i}</button>`;
        numLi.querySelector('button').addEventListener('click', () => {
            currentPage = i;
            applyFiltersAndRender();
            window.scrollTo({ top: 300, behavior: 'smooth' });
        });
        paginationList.appendChild(numLi);
    }
    
    // Next button
    const nextLi = document.createElement('li');
    nextLi.innerHTML = `<button class="custom-pagination-btn ${currentPage === totalPages ? 'disabled' : ''}">Next</button>`;
    nextLi.querySelector('button').addEventListener('click', () => {
        if(currentPage < totalPages) {
            currentPage++;
            applyFiltersAndRender();
            window.scrollTo({ top: 300, behavior: 'smooth' });
        }
    });
    paginationList.appendChild(nextLi);
}

// Run
initFilters();
applyFiltersAndRender();
</script>

</body>
</html>