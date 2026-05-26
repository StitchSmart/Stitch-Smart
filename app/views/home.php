<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=$webname ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= BASE_URL ?>/css/navbar.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>/css/footer.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>/css/style.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>/css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>/css/luxury_theme.css" rel="stylesheet">

</head>
<body>
<?php include('header.php'); ?>

<!-- Banner Carousel (At the top) -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="false">
    <div class="carousel-indicators">
        <?php foreach($banners as $i => $row): ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $i ?>" class="<?= ($i == 0) ? 'active' : '' ?>"></button>
        <?php endforeach; ?>
    </div>

    <div class="carousel-inner">
        <?php foreach($banners as $i => $row): ?>
            <div class="carousel-item <?= ($i == 0) ? 'active' : '' ?>" style="background-image: url('<?= BASE_URL . '/' . $row['image_url']; ?>'); background-size: cover; background-position: center; height: 500px;">
                <div class="overlay" style="background: rgba(0, 0, 0, 0.2); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
            </div>
        <?php $i++; endforeach; ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
<!-- Luxury Hero Section -->
<section class="luxury-hero">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Side: Content -->
            <div class="col-lg-6">
                <div class="hero-left-content animate-fade-up">
                    <span class="badge mb-3" style="background: var(--luxury-bronze); color: #1a0f0a; padding: 8px 15px; border-radius: 50px; font-weight: 700;">Premium Collection</span>
                    <h1>Shop <span>Smarter,</span><br>Live Better.</h1>
                    <p>Discover curated premium products handpicked for quality and style. From fashion to electronics — we bring the best to your doorstep.</p>
                    <div class="hero-btns">
                        <a href="<?= BASE_URL; ?>/index.php?page=allproducts" class="btn-luxury-primary">Browse Collection</a>
                        <a href="<?= BASE_URL; ?>/index.php?page=about" class="btn-luxury-outline">Our Story</a>
                    </div>
                </div>
            </div>
            
            <!-- Right Side: Category Grid -->
            <div class="col-lg-6">
                <div class="hero-right-grid">
                    <?php 
                    $hero_cats = array_slice($categories, 0, 4);
                    foreach($hero_cats as $h_cat): 
                    ?>
                        <a href="<?= BASE_URL; ?>/index.php?page=products&category_id=<?= $h_cat['c_id']; ?>" class="luxury-hero-card">
                            <div class="icon-box">
                                <img src="<?= BASE_URL ?><?= htmlspecialchars($h_cat['c_image']); ?>" alt="<?= htmlspecialchars($h_cat['c_name']); ?>">
                            </div>
                            <div class="card-content">
                                <h3><?= htmlspecialchars($h_cat['c_name']); ?></h3>
                                <p>From $<?= rand(49, 199); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Featured Products Section -->
<section class="featured-section">
    <div class="container">
        <div class="featured-header">
            <div>
                <h2>Featured <span>Products</span></h2>
            </div>
            <a href="<?= BASE_URL; ?>/index.php?page=allproducts" class="view-all-link">VIEW ALL →</a>
        </div>

        <div class="row g-4">
            <?php 
            $counter = 0;
            foreach($products as $product): 
                if($counter >= 4) break;
            ?>
            <div class="col-lg-3 col-md-6">
                <div class="featured-card">
                    <div class="card-top">
                        <?php $productImage = strtok($product['image_url'], ','); ?>
                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars(trim($productImage)); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                    </div>
                    <div class="card-bottom">
                        <span class="category-pill"><?= htmlspecialchars($product['article_number'] ?? 'Premium'); ?></span>
                        <h4><?= htmlspecialchars($product['name']); ?></h4>
                        <p class="desc"><?= htmlspecialchars(substr($product['description'], 0, 40)); ?>...</p>
                        <div class="price-row">
                            <span class="current-price">$<?= htmlspecialchars($product['price']); ?></span>
                            <?php if(!empty($product['old_price'])): ?>
                                <span class="old-price">$<?= htmlspecialchars($product['old_price']); ?></span>
                            <?php endif; ?>
                        </div>
                        <a href="<?= BASE_URL; ?>index.php?page=product_show&id=<?= $product['id']; ?>" class="add-btn-circle">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php $counter++; endforeach; ?>
        </div>
    </div>
</section>


<!--Sale Section-->
<section class="sale-section py-5">
  <div class="container">
    <div class="text-center mb-4">
        <h2>
            <a href="<?= BASE_URL; ?>/index.php?page=sale" style="text-decoration: none; transition: color 0.3s;">Sale Products</a>
        </h2>
    </div>
    <div class="row py-4 g-4 d-flex justify-content-center">
        <?php foreach($products as $product): ?>
    <?php if($product['featured'] != 1) continue; ?> <!-- Skip non-featured -->

    <div class="col-md-3 col-sm-6">
        <a href="<?= BASE_URL; ?>index.php?page=product_show&id=<?= $product['id']; ?>" class="text-decoration-none text-dark">
            <div class="prod-card shadow-sm rounded">
                <div class="prod-img position-relative">
                    <?php $productImage = strtok($product['image_url'], ','); ?>
                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars(trim($productImage)); ?>" 
                         alt="<?= htmlspecialchars($product['name']); ?>" class="img-fluid rounded">
                    <?php if(!empty($product['badge'])): ?>
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2"><?= htmlspecialchars($product['badge']); ?></span>
                    <?php endif; ?>
                </div>
                <div class="prod-info p-2 text-center">
                    <h3 class="h6"><?= htmlspecialchars($product['name']); ?></h3>
                    <div class="price-box mt-1">
                        <?php if(!empty($product['old_price'])): ?>
                            <span class="old-price text-muted text-decoration-line-through me-2">$<?= htmlspecialchars($product['old_price']); ?></span>
                        <?php endif; ?>
                        <span class="prod-price2 fw-bold" style="color:#c19a4e;">$<?= htmlspecialchars($product['price']); ?></span>
                    </div>
                </div>
           </div> 
        </a>
    </div>

<?php endforeach; ?>

   
        </div>

        
    
    <div class="contbut d-flex justify-content-center align-items-center">
<a href="<?= BASE_URL; ?>/index.php?page=sale"> <button class="headbutton">View All</button></a>
    </div>
   
    </div>
    </section>





<!-- Features Strip (above footer) -->
<section class="features-strip py-5">
  <div class="container">
    <div class="row text-center g-4">

      <!-- Feature 1 -->
      <div class="col-6 col-md-3">
        <div class="d-flex flex-column align-items-center">
          <i class="bi bi-scooter display-5 mb-2" style="color:#c19a4e;"></i>
          <p class="mb-0 fw-semibold">Curb-side pickup</p>
        </div>
      </div>

      <!-- Feature 2 -->
      <div class="col-6 col-md-3">
        <div class="d-flex flex-column align-items-center">
          <i class="bi bi-box-seam display-5 mb-2" style="color:#c19a4e;"></i>
          <p class="mb-0 fw-semibold">Free shipping on orders over $50</p>
        </div>
      </div>

      <!-- Feature 3 -->
      <div class="col-6 col-md-3">
        <div class="d-flex flex-column align-items-center">
          <i class="bi bi-percent display-5 mb-2" style="color:#c19a4e;"></i>
          <p class="mb-0 fw-semibold">Low prices guaranteed</p>
        </div>
      </div>

      <!-- Feature 4 -->
      <div class="col-6 col-md-3">
        <div class="d-flex flex-column align-items-center">
          <i class="bi bi-clock display-5 mb-2" style="color:#c19a4e;"></i>
          <p class="mb-0 fw-semibold">Available to you 24/7</p>
        </div>
      </div>

    </div>
  </div>
</section>

<?php include('footer.php'); ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>