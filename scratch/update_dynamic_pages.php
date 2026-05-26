<?php
// C:\Users\USER\.gemini\antigravity\brain\2d2fcaf0-185c-4fbb-ba98-dd730556c1e0\scratch\update_dynamic_pages.php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$database = new Database();
$db = $database->connect();

if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

// 1. ABOUT US PAGE HTML
$about_us_html = '
<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h2 class="text-warning mb-3" style="font-family: \'Outfit\', sans-serif; font-weight: 700;">Redefining Custom Fashion</h2>
            <p class="text-light fs-5" style="line-height: 1.8;">
                Welcome to <strong class="text-warning">Stitch-Smart</strong>, where cutting-edge technology meets premium craftsmanship. We believe that clothing should be a direct extension of your unique personality, not a mass-produced compromise.
            </p>
            <p class="text-muted" style="line-height: 1.7;">
                Our revolutionary digital design suite empowers you to customize every detail of your luxury hoodies, sweatpants, shorts, and crewnecks. Choose your fit, blend of materials, custom graphics, and colors, and watch your vision come alive.
            </p>
        </div>
        <div class="col-lg-6">
            <div class="p-3 border border-warning border-opacity-25 rounded-4" style="background: rgba(193, 154, 78, 0.03);">
                <h4 class="text-warning mb-3"><i class="bi bi-shield-check"></i> Our Core Values</h4>
                <div class="d-flex mb-3">
                    <div class="text-warning me-3 fs-3"><i class="bi bi-gem"></i></div>
                    <div>
                        <h5 class="text-white">Uncompromising Quality</h5>
                        <p class="text-muted">We source only the finest long-staple premium cottons and heavyweight fleece for superior warmth and comfort.</p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="text-warning me-3 fs-3"><i class="bi bi-cpu"></i></div>
                    <div>
                        <h5 class="text-white">Tech-Driven Precision</h5>
                        <p class="text-muted">Our custom orders are processed with state-of-the-art digital printing and automated pattern scaling for the perfect fit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';

// 2. PAYMENT AND FINANCING PAGE HTML
$payment_html = '
<div class="container py-5">
    <div class="row justify-content-center text-center mb-5">
        <div class="col-lg-8">
            <h2 class="text-warning mb-3" style="font-family: \'Outfit\', sans-serif; font-weight: 700;">Simple & Flexible Payment Options</h2>
            <p class="text-muted">We make it convenient and easy for you to order custom designer streetwear with a range of secure payment methods.</p>
        </div>
    </div>
    
    <div class="row g-4 mb-5">
        <!-- Card 1: Cards -->
        <div class="col-md-4">
            <div class="card h-100 border border-warning border-opacity-25 text-center p-4" style="background: rgba(10, 10, 10, 0.65);">
                <div class="text-warning fs-1 mb-3"><i class="bi bi-credit-card"></i></div>
                <h4 class="text-white">Credit & Debit Cards</h4>
                <p class="text-muted">We accept all major local and international cards including Visa, Mastercard, and UnionPay. Fully encrypted and secure checkout.</p>
            </div>
        </div>
        <!-- Card 2: JazzCash/EasyPaisa -->
        <div class="col-md-4">
            <div class="card h-100 border border-warning border-opacity-25 text-center p-4" style="background: rgba(10, 10, 10, 0.65);">
                <div class="text-warning fs-1 mb-3"><i class="bi bi-phone"></i></div>
                <h4 class="text-white">EasyPaisa & JazzCash</h4>
                <p class="text-muted">Make instant, frictionless mobile wallet transfers. Simply select mobile transfer during checkout and enter your account detail.</p>
            </div>
        </div>
        <!-- Card 3: Installments -->
        <div class="col-md-4">
            <div class="card h-100 border border-warning border-opacity-25 text-center p-4" style="background: rgba(10, 10, 10, 0.65);">
                <div class="text-warning fs-1 mb-3"><i class="bi bi-calendar-event"></i></div>
                <h4 class="text-white">Flexible Installments</h4>
                <p class="text-muted">Buy Now, Pay Later! Spread the cost of high-end customized corporate bundles over 3 interest-free monthly installments.</p>
            </div>
        </div>
    </div>
</div>';

// 3. PRODUCT ADVICE PAGE HTML
$advice_html = '
<div class="container py-5">
    <div class="row justify-content-center text-center mb-5">
        <div class="col-lg-8">
            <h2 class="text-warning mb-3" style="font-family: \'Outfit\', sans-serif; font-weight: 700;">Expert Styling & Care Guide</h2>
            <p class="text-muted">Sizing, fit guidelines, material selections, and wash-care suggestions to keep your custom items looking pristine.</p>
        </div>
    </div>
    
    <div class="row g-4">
        <!-- Sizing Guide -->
        <div class="col-lg-6">
            <div class="p-4 border border-warning border-opacity-25 rounded-4 h-100" style="background: rgba(193, 154, 78, 0.02);">
                <h4 class="text-warning mb-3"><i class="bi bi-rulers"></i> Perfect Fit Guidelines</h4>
                <p class="text-light">
                    Our customized products are available in three premium silhouette types:
                </p>
                <ul>
                    <li class="text-light mb-2"><strong class="text-warning">Oversized:</strong> Intentionally generous, drop-shoulder luxury streetwear fit. Order your normal size.</li>
                    <li class="text-light mb-2"><strong class="text-warning">Relaxed:</strong> Comfortable every day fit, slightly roomier around the chest and sleeves.</li>
                    <li class="text-light"><strong class="text-warning">Slim:</strong> Form-fitting and contoured close to the body. Perfect for athletic builds.</li>
                </ul>
            </div>
        </div>
        
        <!-- Fabric & Wash Care -->
        <div class="col-lg-6">
            <div class="p-4 border border-warning border-opacity-25 rounded-4 h-100" style="background: rgba(193, 154, 78, 0.02);">
                <h4 class="text-warning mb-3"><i class="bi bi-droplet"></i> Material & Wash Care Advice</h4>
                <p class="text-light">
                    To maintain the vibrancy of customized prints, heavy embroidery, and premium long-staple cotton:
                </p>
                <ul>
                    <li class="text-light mb-2">Wash inside out in cold water on a delicate cycle (max 30°C).</li>
                    <li class="text-light mb-2">Use mild, color-safe eco-friendly detergents; avoid liquid chlorine bleach.</li>
                    <li class="text-light">Air dry naturally away from direct sunlight. Never iron directly over graphics or custom embroidery!</li>
                </ul>
            </div>
        </div>
    </div>
</div>';

// 4. OUR STORY PAGE HTML (CEO MOIZ AHMED, BISSMA IJAZ, ALI HAIDER)
$story_html = '
<div class="container py-5">
    <div class="row justify-content-center text-center mb-5">
        <div class="col-lg-8">
            <h2 class="text-warning mb-3" style="font-family: \'Outfit\', sans-serif; font-weight: 700;">The Birth of Stitch-Smart</h2>
            <p class="text-light fs-5" style="line-height: 1.8;">
                Stitch-Smart was founded by three ambitious students who shared a common goal: to revolutionize customized fashion through technical innovation.
            </p>
        </div>
    </div>
    
    <div class="row g-4 mb-5 justify-content-center">
        <!-- Founder 1: Moiz Ahmed -->
        <div class="col-md-4">
            <div class="card h-100 border border-warning border-opacity-25 text-center p-4" style="background: rgba(10, 10, 10, 0.65); border-radius: 16px;">
                <div class="fs-1 text-warning mb-2"><i class="bi bi-person-workspace"></i></div>
                <h4 class="text-white mb-1">Moiz Ahmed</h4>
                <p class="text-warning small mb-3" style="letter-spacing: 1px;">CHIEF EXECUTIVE OFFICER (CEO)</p>
                <p class="text-muted" style="font-size: 0.9rem;">
                    As the CEO and Lead Developer, Moiz conceptualized the smart 2D visual customizer workspace. His technical architecture bridges high-end clothing craft with web customization.
                </p>
            </div>
        </div>
        <!-- Founder 2: Bissma Ijaz -->
        <div class="col-md-4">
            <div class="card h-100 border border-warning border-opacity-25 text-center p-4" style="background: rgba(10, 10, 10, 0.65); border-radius: 16px;">
                <div class="fs-1 text-warning mb-2"><i class="bi bi-boxes"></i></div>
                <h4 class="text-white mb-1">Bissma Ijaz</h4>
                <p class="text-warning small mb-3" style="letter-spacing: 1px;">INVENTORY MANAGER</p>
                <p class="text-muted" style="font-size: 0.9rem;">
                    Bissma directs our premium supply chain and textile selection, sourcing only the finest cotton, premium loopback fleece, and threads for each custom creation.
                </p>
            </div>
        </div>
        <!-- Founder 3: Ali Haider -->
        <div class="col-md-4">
            <div class="card h-100 border border-warning border-opacity-25 text-center p-4" style="background: rgba(10, 10, 10, 0.65); border-radius: 16px;">
                <div class="fs-1 text-warning mb-2"><i class="bi bi-cash-coin"></i></div>
                <h4 class="text-white mb-1">Ali Haider</h4>
                <p class="text-warning small mb-3" style="letter-spacing: 1px;">FINANCE MANAGER</p>
                <p class="text-muted" style="font-size: 0.9rem;">
                    Ali regulates budgeting operations, pricing algorithms, and safe online gate processing, ensuring outstanding fashion is highly affordable and secure.
                </p>
            </div>
        </div>
    </div>
    
    <div class="row align-items-center mt-5">
        <div class="col-lg-6 mb-4 mb-lg-0 text-center">
            <div class="p-4 border border-warning border-opacity-25 rounded-4 d-inline-block" style="background: rgba(193, 154, 78, 0.05);">
                <h2 class="text-warning font-weight-bold" style="font-size: 3rem;">3</h2>
                <p class="text-white small text-uppercase" style="letter-spacing: 2px; margin-bottom: 0;">Founding Visionary Students</p>
            </div>
        </div>
        <div class="col-lg-6">
            <h3 class="text-warning" style="font-family: \'Outfit\', sans-serif;">From University Project to Real-World Brand</h3>
            <p class="text-muted" style="line-height: 1.7;">
                What started as a collaborative capstone project in early 2026 has grown into a premium streetwear platform. By bridging Moiz\'s software engineering, Bissma\'s fabric management, and Ali\'s financial strategy, Stitch-Smart has brought premium, personalized fits to the global streetwear market.
            </p>
        </div>
    </div>
</div>';

// Setup list of pages
$pages = [
    [
        'title' => 'About Us',
        'slug' => 'about-us',
        'content' => $about_us_html,
        'meta_title' => 'About Stitch-Smart | Premium Personalized Streetwear',
        'meta_desc' => 'Discover our mission to merge advanced technology with artisanal clothing craft, empowering you to design unique premium streetwear.',
        'meta_keywords' => 'custom hoodies, design crewneck, customized clothing, streetwear brand'
    ],
    [
        'title' => 'Payment & Financing',
        'slug' => 'payment-and-financing',
        'content' => $payment_html,
        'meta_title' => 'Payment & Financing | Stitch-Smart Secure Payments',
        'meta_desc' => 'Explore safe payment options including Credit/Debit card checkout, mobile wallet transfers, and flexible interest-free monthly installment plans.',
        'meta_keywords' => 'easypaisa payment, secure clothing check, interest free installments'
    ],
    [
        'title' => 'Product Advice',
        'slug' => 'product-advice',
        'content' => $advice_html,
        'meta_title' => 'Product Advice & Sizing Guide | Stitch-Smart Clothing care',
        'meta_desc' => 'Expert advice on custom fits (oversized, relaxed, slim), fabric qualities, and maintenance tips to keep print/embroidery looking new.',
        'meta_keywords' => 'clothing size guide, oversize hoodie wash, cotton fabric care'
    ],
    [
        'title' => 'Our Story',
        'slug' => 'our-story',
        'content' => $story_html,
        'meta_title' => 'Our Story | Three Student Founders Behind Stitch-Smart',
        'meta_desc' => 'Meet Moiz Ahmed (CEO), Bissma Ijaz (Inventory), and Ali Haider (Finance)—the three student founders who revolutionized custom clothing.',
        'meta_keywords' => 'stitch smart founders, moiz ahmed, bissma ijaz, ali haider, custom streetwear startup'
    ]
];

foreach ($pages as $p) {
    // Check if page already exists
    $stmt = $db->prepare("SELECT id FROM pages WHERE slug = ?");
    $stmt->bind_param("s", $p['slug']);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    
    if ($res) {
        $id = $res['id'];
        $stmt_up = $db->prepare("UPDATE pages SET title=?, content=?, meta_title=?, meta_description=?, meta_keywords=?, is_published=1, updated_at=NOW() WHERE id=?");
        $stmt_up->bind_param("sssssi", $p['title'], $p['content'], $p['meta_title'], $p['meta_desc'], $p['meta_keywords'], $id);
        $stmt_up->execute();
        echo "Updated existing page: " . $p['title'] . "\n";
    } else {
        $stmt_in = $db->prepare("INSERT INTO pages (title, slug, content, meta_title, meta_description, meta_keywords, is_published, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, 1, NOW(), NOW())");
        $stmt_in->bind_param("ssssss", $p['title'], $p['slug'], $p['content'], $p['meta_title'], $p['meta_desc'], $p['meta_keywords']);
        $stmt_in->execute();
        echo "Created new page: " . $p['title'] . "\n";
    }
}

echo "Database successfully updated!\n";
