<?php if (!empty($hide_header)) {
    return;
}
?>
<!-- design -->
<link rel="stylesheet" href="<?= BASE_URL ?>css/mega_menu.css">
<link rel="stylesheet" href="<?= BASE_URL ?>css/navbar-professional.css">

<?php if (empty($hide_announcement)): ?>
<!-- Premium Top Announcement Bar -->
<div class="announcement-bar">
    <div class="container-fluid">
        <div class="announcement-content">
            <div class="announcement-left">
                <i class="bi bi-truck"></i>
                <span>Free Worldwide Shipping on Orders Over $50</span>
            </div>
            <div class="announcement-center">
                <span>✨ Premium Collection ✨</span>
            </div>
            <div class="announcement-right">
                <i class="bi bi-shield-check"></i>
                <span>100% Secure & Authentic</span>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['qty'];
    }
}
?>

<!-- Main Navbar -->
<nav class="main-navbar">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <a class="brand-logo" href="<?= BASE_URL ?>/index.php?page=home">
                <div class="logo-icon">S</div>
                <div class="brand-info">
                    <div class="brand-name">Stitch<span>Smart</span></div>
                    <div class="brand-tagline">Premium Collection</div>
                </div>
            </a>
            <div class="navbar-right d-flex align-items-center gap-3">
                <form method="GET" action="<?= BASE_URL; ?>/index.php" class="search-form d-flex align-items-center">
                    <input type="hidden" name="page" value="products">
                    <div class="search-input-group">
                        <input 
                            type="text" 
                            id="searchInput"
                            name="search" 
                            class="search-input"
                            placeholder="Search products..."
                            autocomplete="off"
                        >
                        <button type="submit" class="search-btn">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                <div id="globalSuggestions" class="search-suggestions"></div>
            </div>
        </div>
    </div>
</nav>

<!-- Categories Navbar (Separate Row) -->
<div class="categories-bar border-top border-bottom py-2">
    <div class="container">

        <div class="category-row d-flex flex-column flex-lg-row align-items-center justify-content-between gap-3">
            <button class="btn w-100 text-start d-lg-none mb-2 menu-toggle"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#categoryMenu">
                ☰ Menu
            </button>

            <div class="collapse d-lg-block flex-grow-1" id="categoryMenu">
                <ul class="nav flex-wrap justify-content-start py-2 mb-0 header-menu">
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/index.php?page=allproducts">Shop All</a></li>
                    <li class="nav-item dropdown dropdown-mega">
                        <a class="nav-link dropdown-toggle" href="#" id="browseMenuLink" data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <div class="dropdown-menu">
                            <div class="mega-menu-banner">
                                <span class="mega-menu-label">Signature Categories</span>
                                <h3>Premium collections with international style.</h3>
                                <p>Fast access to curated category lines, bestselling collections and global-ready fashion in one elegant menu.</p>
                            </div>
                            <div class="mega-menu-content">
                                <div class="mega-menu-main-panel">
                                    <?php foreach($categories as $idx => $cat): ?>
                                        <a class="nav-link <?= $idx === 0 ? 'active' : '' ?>" 
                                           href="<?= BASE_URL; ?>/index.php?page=products&category_id=<?= $cat['c_id']; ?>"
                                           onmouseover="showMegaSub('cat-<?= $cat['c_id']; ?>', this)">
                                            <?= htmlspecialchars($cat['c_name']); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                                <div class="mega-menu-sub-panel">
                                    <?php foreach($categories as $idx => $cat): ?>
                                        <div class="sub-content-panel <?= $idx === 0 ? '' : 'd-none' ?>" id="cat-<?= $cat['c_id']; ?>">
                                            <h3><?= htmlspecialchars($cat['c_name']); ?></h3>
                                            <div class="sub-grid">
                                                <ul>
                                                    <?php if(!empty($cat['subs'])): ?>
                                                        <?php foreach($cat['subs'] as $sub): ?>
                                                            <li><a href="<?= BASE_URL; ?>/index.php?page=products&category_id=<?= $sub['c_id']; ?>"><?= htmlspecialchars($sub['c_name']); ?></a></li>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <li><a href="<?= BASE_URL; ?>/index.php?page=products&category_id=<?= $cat['c_id']; ?>">Explore all <?= htmlspecialchars($cat['c_name']); ?></a></li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="mega-menu-highlight">
                                        <span class="mega-menu-chip">Trending now</span>
                                        <h4>Curated premium picks</h4>
                                        <p>Discover our standout categories, premium collections, and global design stories in one elegant menu.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL; ?>/index.php?page=page&slug=about-us">About Us</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="<?= BASE_URL; ?>/index.php?page=sale">Sale</a></li>
                </ul>
            </div>
            <div class="category-actions d-flex align-items-center justify-content-end gap-2 mt-2 mt-lg-0">
                <a href="<?= BASE_URL; ?>/index.php?page=design" class="btn btn-action btn-design-yourself">
                    <i class="bi bi-pencil-square"></i> Design Yourself
                </a>
                <?php if (isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in'] === true): ?>
                    <a href="<?= BASE_URL; ?>/index.php?page=customer_orders" class="btn btn-action btn-my-orders">
                        <i class="bi bi-box-seam"></i> My Orders
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL; ?>/index.php?page=checkout" class="btn btn-action btn-login">
                        <i class="bi bi-lock"></i> Login
                    </a>
                <?php endif; ?>
                <a href="<?= BASE_URL; ?>/index.php?page=cart" class="btn btn-action btn-cart cart-btn position-relative" title="Shopping Cart">
                    <i class="bi bi-cart3"></i> Cart
                    <?php if ($cartCount > 0): ?>
                        <span class="cart-badge"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    #globalSuggestions {
        position: fixed !important;
        z-index: 999999 !important;
    }
    #globalSuggestions.active {
        display: block !important;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("searchInput");
    const box = document.getElementById("globalSuggestions");

    if (!input || !box) return;

    // Ensure suggestions are not trapped inside the navbar stacking context
    if (box.parentElement !== document.body) {
        document.body.appendChild(box);
    }

    input.addEventListener("keyup", function () {
        let query = this.value;

        if (query.length < 2) {
            box.innerHTML = "";
            box.classList.remove('active');
            return;
        }

        fetch("<?= BASE_URL ?>/index.php?page=live_search&q=" + encodeURIComponent(query))
            .then(res => res.json())
            .then(data => {
                let html = "";

                if (data.length > 0) {
                    data.forEach(item => {
                        let url = item.type === 'category'
                            ? '<?= BASE_URL ?>/index.php?page=products&category_id=' + item.id
                            : '<?= BASE_URL ?>/index.php?page=product_show&id=' + item.id;
                        let label = item.type === 'category'
                            ? '<span class="category-badge">Category</span>'
                            : '';

                        html += `
                            <div class="suggest-item" onclick="window.location='${url}'">
                                <img src="<?= BASE_URL ?>/${item.image}" width="35" height="35" alt="${item.name}">
                                <div class="suggest-info">
                                    <div class="suggest-name">${item.name}</div>
                                    ${label}
                                </div>
                            </div>
                        `;
                    });
                    box.innerHTML = html;
                    box.classList.add('active');
                    positionSuggestions();
                } else {
                    html = `<div class="suggest-empty">No products found</div>`;
                    box.innerHTML = html;
                    box.classList.add('active');
                    positionSuggestions();
                }

            })
            .catch(err => console.error('Search error:', err));
    });

    // Position suggestion box using fixed positioning so it overlays header buttons
    function positionSuggestions() {
        const rect = input.getBoundingClientRect();
        box.style.setProperty('position', 'fixed', 'important');
        box.style.setProperty('left', rect.left + 'px', 'important');
        box.style.setProperty('top', (rect.bottom + 8) + 'px', 'important');
        box.style.setProperty('width', rect.width + 'px', 'important');
        box.style.setProperty('right', 'auto', 'important');
        box.style.setProperty('z-index', '999999', 'important');
        box.style.setProperty('max-width', 'calc(100vw - 32px)', 'important');
    }

    // Hide suggestions on scroll/resize to avoid misplacement
    window.addEventListener('scroll', function() {
        box.classList.remove('active');
        box.innerHTML = '';
    });
    window.addEventListener('resize', function() {
        box.classList.remove('active');
        box.innerHTML = '';
    });

    // Show recent searches when input is focused and empty
    input.addEventListener('focus', function() {
        const query = this.value.trim();
        if (query.length === 0) {
            // fetch recent searches for logged-in users
            fetch("<?= BASE_URL ?>/index.php?page=user_search_history")
                .then(res => res.json())
                .then(data => {
                    if (!data.searches || data.searches.length === 0) return;
                    let html = '';
                    data.searches.forEach(s => {
                        html += `
                            <div class="suggest-item recent-search" data-query="${encodeURIComponent(s.query)}">
                                <div class="suggest-info">
                                    <div class="suggest-name">${s.query}</div>
                                    <div class="suggest-meta small text-muted">${s.created_at}</div>
                                </div>
                            </div>
                        `;
                    });
                    box.innerHTML = html;
                    box.classList.add('active');
                    positionSuggestions();
                }).catch(()=>{});
        }
    });

    // Click on a recent search -> perform search
    box.addEventListener('click', function(e) {
        const item = e.target.closest('.recent-search');
        if (!item) return;
        const q = decodeURIComponent(item.getAttribute('data-query') || '');
        if (!q) return;
        // set input and submit the search form
        input.value = q;
        const form = input.closest('form');
        if (form) form.submit();
    });

    // Close suggestions on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.navbar-right') && !e.target.closest('#globalSuggestions')) {
            box.innerHTML = "";
            box.classList.remove('active');
        }
    });

    // Keep mega menu open while cursor moves inside dropdown
    const megaDropdown = document.querySelector('.nav-item.dropdown-mega');
    const megaMenu = megaDropdown?.querySelector('.dropdown-menu');
    let megaCloseTimer;
    let megaOpenTimer;

    if (megaDropdown && megaMenu) {
        const openMegaMenu = () => {
            clearTimeout(megaCloseTimer);
            megaDropdown.classList.add('show');
            megaMenu.classList.add('show');
        };

        const closeMegaMenu = () => {
            megaCloseTimer = setTimeout(() => {
                megaDropdown.classList.remove('show');
                megaMenu.classList.remove('show');
            }, 220);
        };

        megaDropdown.addEventListener('mouseenter', () => {
            clearTimeout(megaCloseTimer);
            megaOpenTimer = setTimeout(openMegaMenu, 80);
        });

        megaDropdown.addEventListener('mouseleave', () => {
            clearTimeout(megaOpenTimer);
            closeMegaMenu();
        });

        megaMenu.addEventListener('mouseenter', () => {
            clearTimeout(megaCloseTimer);
        });

        megaMenu.addEventListener('mouseleave', closeMegaMenu);
    }
});

function showMegaSub(id, link) {
    document.querySelectorAll('.sub-content-panel').forEach(panel => {
        panel.classList.toggle('d-none', panel.id !== id);
    });
    document.querySelectorAll('.mega-menu-main-panel .nav-link').forEach(item => {
        item.classList.toggle('active', item === link);
    });
}
</script>
<!-- Professional Floating Chatbot Widget -->
<div id="chat-widget" style="position: fixed !important; bottom: 24px !important; right: 24px !important; z-index: 1000000 !important;">
    <!-- Chat Toggle Button -->
    <button id="chat-toggle" aria-label="Open chat">
        <svg id="chat-icon-open" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
            <path d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1H2z"/>
        </svg>
        <svg id="chat-icon-close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16" style="display:none;">
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
        </svg>
        <span id="chat-unread" style="display:none;">1</span>
    </button>

    <!-- Chat Window -->
    <div id="chat-window">
        <!-- Header -->
        <div id="chat-header">
            <div class="chat-header-info">
                <div class="chat-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5ZM3 8.062C3 6.76 4.235 5.765 5.53 5.886a26.58 26.58 0 0 0 4.94 0C11.765 5.765 13 6.76 13 8.062v1.157a.933.933 0 0 1-.765.935c-.845.147-2.34.346-4.235.346-1.895 0-3.39-.2-4.235-.346A.933.933 0 0 1 3 9.219V8.062Zm4.542-.827a.25.25 0 0 0-.217.068l-.92.9a24.767 24.767 0 0 1-1.871-.183.25.25 0 0 0-.068.495c.55.076 1.232.149 2.02.193a.25.25 0 0 0 .189-.071l.754-.736.847 1.71a.25.25 0 0 0 .404.062l.932-.97a25.286 25.286 0 0 0 1.922-.188.25.25 0 0 0-.068-.495c-.538.074-1.207.145-1.98.189a.25.25 0 0 0-.166.076l-.754.785-.842-1.7a.25.25 0 0 0-.182-.135Z"/>
                        <path d="M8.5 1.866a1 1 0 1 0-1 0V3h-2A4.5 4.5 0 0 0 1 7.5V8a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v1a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-1a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1v-.5A4.5 4.5 0 0 0 10.5 3h-2V1.866Z"/>
                    </svg>
                </div>
                <div>
                    <div class="chat-header-title"><?= APP_NAME ?> Assistant</div>
                    <div class="chat-header-status"><span class="status-dot"></span> Online</div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <button id="chat-minimize" aria-label="Minimize chat" class="me-2" style="background:none; border:none; color:inherit;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </button>
                <button id="chat-close" aria-label="Close chat" style="background:none; border:none; color:inherit;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </button>
            </div>
        </div>

        <div id="chat-messages">
            <div class="chat-welcome">
                <div class="chat-choice-grid">
                    <!-- WhatsApp Support Button -->
                    <a href="https://wa.link/twb6nv" target="_blank" class="chat-choice-card support">
                        <div class="choice-icon"><i class="bi bi-whatsapp"></i></div>
                        <div class="choice-label">Customer Care</div>
                    </a>
                    
                    <!-- AI Assistant Button -->
                    <button type="button" class="chat-choice-card ai" onclick="document.getElementById('chat-input').focus()">
                        <div class="choice-icon"><i class="bi bi-robot"></i></div>
                        <div class="choice-label">AI Assistant</div>
                    </button>
                </div>
                
                <p class="welcome-intro">How can we help you today? Explore our latest collections or talk to a real person instantly.</p>
                <div class="whatsapp-hint">No phone number save required for WhatsApp</div>
            </div>
            <div class="quick-actions">
                <?php foreach($categories as $cat): ?>
                <button class="quick-btn" data-msg="Show me your <?= htmlspecialchars($cat['c_name']) ?> collection">🏷️ <?= htmlspecialchars($cat['c_name']) ?></button>
                <?php endforeach; ?>
                <button class="quick-btn" data-msg="What are your cheapest products?">💰 Budget Picks</button>
                <button class="quick-btn" data-msg="What sizes do you have available?">📏 Size Guide</button>
                <button class="quick-btn" data-msg="What is your shipping and return policy?">📦 Shipping Info</button>
            </div>
        </div>

        <!-- Input Area -->
        <div id="chat-input-area">
            <form id="chat-form">
                <input type="text" id="chat-input" placeholder="Type your message..." autocomplete="off">
                <button type="submit" id="chat-send" aria-label="Send message">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.5.5 0 0 1-.928.086l-2.17-4.776-4.777-2.17a.5.5 0 0 1 .086-.929L14.854.146a.5.5 0 0 1 .54.11ZM6.636 10.07l1.33 2.924 3.558-8.896-4.888 5.972Zm6.182-8.776L4.422 5.856l2.924 1.33 5.472-5.892Z"/>
                    </svg>
                </button>
            </form>
            <div class="chat-powered">Powered by AI</div>
        </div>
    </div>
</div>
