<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= APP_NAME ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-papvJkn1+lUOHJZ4KJ/4DhrOd2NT6lUP0N9IuqkQKbtVsjG6uE1j+rT6lCz2/0Rvx+3rj2eBx/NrG85K+YdC7Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <link rel="stylesheet" href="<?= BASE_URL ?>css/navbar.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/footer.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/colors.css">
   <link rel="stylesheet" href="<?= BASE_URL ?>css/single-product.css">
   <link href="<?= BASE_URL ?>css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">
<style>
  /* PRODUCT SECTION */
.product-section {
  padding: 60px 0;
}

.gallery-wrap .main-img-wrap {
  overflow: hidden;
  position: relative;
}

.gallery-wrap .main-img-wrap img {
  width: 100%;
  height: auto;
  transition: transform 0.4s ease;
}

.gallery-wrap .main-img-wrap:hover img {
  transform: scale(1.05);
}

.badge-tag {
  background-color: #c52c1e;
  color: #fff;
  font-weight: 600;
  padding: 0.4rem 0.8rem;
  border-radius: 0.25rem;
  top: 10px;
  left: 10px;
  font-size: 0.8rem;
}

.product-info-wrap {
  background-color: var(--bg-card, #0a0a0a);
}

.review-row .stars i {
  margin-right: 2px;
}

.price-block .current-price {
  color: var(--accent-bronze, #c19a4e);
}
.price-block .old-price {
  font-size: 0.95rem;
}

.spec-chips .spec-chip {
  font-size: 0.85rem;
}


.cart{
  background: linear-gradient(135deg, var(--accent-bronze, #c19a4e) 0%, #a67c37 100%);
  color: #1a0f0a;
  border: none;
  font-weight: 700;
  border-radius: 12px;
  transition: all 0.3s ease;
}
.cart:hover{
  background: #1a0f0a;
  border: 2px solid var(--accent-bronze, #c19a4e);
  color: var(--accent-bronze, #c19a4e);
}

.trust-badges .trust-item {
  background-color: rgba(193, 154, 78, 0.08);
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-size: 0.85rem;
  display: flex;
  align-items: center;
  border: 1px solid rgba(193, 154, 78, 0.2);
}

.share-row a {
  color: rgba(255,255,255,0.7);
  font-size: 1rem;
  transition: 0.3s;
}

.share-row a:hover {
  color: var(--accent-bronze, #c19a4e);
}


/* Responsive */
@media (max-width: 992px) {
  .add-to-cart-row {
    flex-direction: column;
    align-items: stretch;
  }

  .trust-badges, .share-row {
    justify-content: center;
  }
}
</style>
</head>
<body>
<?php include('header.php'); ?>
<!-- ── BREADCRUMB & ALERTS ── -->
<div class="breadcrumb-bar">
  <div class="container">
    <ol class="breadcrumb mb-3">
      <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php?page=products">Shop</a></li>
      <li class="breadcrumb-item active"><?= htmlspecialchars($product['name']); ?></li>
    </ol>
    
    <?php if (isset($_SESSION['cart_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-0 mt-3" role="alert" style="background-color: rgba(220, 53, 69, 0.15) !important; border: 1px solid rgba(220, 53, 69, 0.3) !important; color: #ea868f !important; border-radius: 12px; padding: 15px 20px;">
            <i class="fas fa-exclamation-circle me-2"></i> <?= $_SESSION['cart_error']; unset($_SESSION['cart_error']); ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close" style="filter: invert(1);"></button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['cart_success'])): ?>
        <div class="alert alert-success alert-dismissible fade show mb-0 mt-3" role="alert" style="background-color: rgba(25, 135, 84, 0.15) !important; border: 1px solid rgba(25, 135, 84, 0.3) !important; color: #75b798 !important; border-radius: 12px; padding: 15px 20px;">
            <i class="fas fa-check-circle me-2"></i> <?= $_SESSION['cart_success']; unset($_SESSION['cart_success']); ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close" style="filter: invert(1);"></button>
        </div>
    <?php endif; ?>
  </div>
</div>

<!-- ── PRODUCT ── -->
<section class="product-section py-5">
  <div class="container">
    <div class="row g-5">

      <!-- Gallery -->
      <div class="col-lg-6">
        <?php
            $productImages = array_filter(array_map('trim', explode(',', $product['image_url'] ?? '')));
            $productImages = array_values($productImages);
            $mainImage = $productImages[0] ?? '';
        ?>
        <div class="gallery-wrap fade-up">
          <div class="main-img-wrap position-relative rounded">
            <span class="badge-tag position-absolute">New</span>
            <img id="mainImg" src="<?= BASE_URL ?>/<?= htmlspecialchars($mainImage) ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="img-fluid rounded">
            <button type="button" id="prevImgBtn" class="image-nav-btn btn btn-light position-absolute top-50 start-0 translate-middle-y">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button type="button" id="nextImgBtn" class="image-nav-btn btn btn-light position-absolute top-50 end-0 translate-middle-y">
                <i class="bi bi-chevron-right"></i>
            </button>
          </div>
          <?php if(count($productImages) > 1): ?>
          <div class="thumbnail-row d-flex flex-wrap gap-2 mt-3">
              <?php foreach ($productImages as $index => $imgPath): ?>
                  <?php if (!empty($imgPath)): ?>
                  <button type="button" class="thumb-button border-0 bg-transparent p-0" data-index="<?= $index ?>">
                      <img src="<?= BASE_URL ?>/<?= htmlspecialchars($imgPath) ?>" alt="<?= htmlspecialchars($product['name']) ?> thumbnail" class="img-thumbnail rounded" style="max-width:80px; height:auto;">
                  </button>
                  <?php endif; ?>
              <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <style>
        .image-nav-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            opacity: 0.85;
            border: 1px solid rgba(0,0,0,0.08);
            transform: translateY(-50%);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        .image-nav-btn:hover {
            opacity: 1;
        }
        .thumb-button img {
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .thumb-button.active-thumb img {
            box-shadow: 0 0 0 2px rgba(193,154,78,0.85);
            transform: scale(1.03);
        }
      </style>

      <!-- Product Info -->
      <div class="col-lg-6">
        <div class="product-info-wrap p-4 rounded h-100 d-flex flex-column justify-content-between">

          <div>
            <!-- Category & Title -->
            <p class="product-category text-muted small mb-1 fade-up"><?= htmlspecialchars($product['article_number']); ?></p>
            <h1 class="product-title fw-bold mb-3 fade-up delay-1"><?= htmlspecialchars($product['name']); ?></h1>

            <!-- Ratings & Stock -->
            <div class="review-row d-flex align-items-center mb-3 fade-up delay-1">
              <div class="stars me-2">
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="far fa-star text-warning"></i>
              </div>
              <span class="review-count text-decoration-none me-3">(42 Reviews)</span>
              
              <?php if ((int)$product['quantity'] <= 0): ?>
                  <span class="stock-status out-of-stock text-danger fw-bold">
                      <i class="fas fa-times-circle me-1"></i> Out of Stock
                  </span>
              <?php elseif ((int)$product['quantity'] < 10): ?>
                  <span class="stock-status low-stock text-warning fw-bold">
                      <i class="fas fa-exclamation-triangle me-1"></i> Only <?= $product['quantity'] ?> left in stock!
                  </span>
              <?php else: ?>
                  <span class="stock-status in-stock text-success fw-bold">
                      <i class="fas fa-check-circle me-1"></i> In Stock (<?= $product['quantity'] ?> available)
                  </span>
              <?php endif; ?>
              </div>

            <!-- Price -->
            <div class="price-block mb-3 fade-up delay-2">
              <span class="current-price fs-3 fw-bold"><?= htmlspecialchars($product['price']); ?></span>
              
              <span class="save-tag badge bg-success ms-2 text-light">Save 29%</span>
            </div>
 <?php
            $tags = $product['meta_keywords'] ?? [];

            // If it's JSON stored in DB
            if (is_string($tags)) {
                $decoded = json_decode($tags, true);
                $tags = $decoded ?: explode(',', $tags);
            }

            // Limit to 4 tags only
            $tags = array_slice(array_filter($tags), 0, 4);
        ?>

        <?php foreach ($tags as $tag): ?>
            <span class="badge px-3 py-2" style="background-color:rgba(193,154,78,0.15); color:#c19a4e; border:1px solid rgba(193,154,78,0.3);">
                <?= htmlspecialchars(trim($tag)); ?>
            </span>
        <?php endforeach; ?>
            <hr class="divider">

            <!-- Description -->
            <p class="short-desc text-secondary mb-3 fade-up delay-2"><?= htmlspecialchars($product['description']); ?></p>

            <!-- Spec Chips -->
            <div class="spec-chips d-flex flex-wrap gap-2 mb-4 fade-up delay-2">
              <?php
              // Theme-aware Yes/No Styling for Design
              $isDesignYes = strtolower(trim($product['Designing'] ?? '')) === 'yes';
              $designBadgeStyle = '';
              if (($global_theme ?? 'theme-luxury') === 'theme-luxury') {
                  if ($isDesignYes) {
                      $designBadgeStyle = 'background-color: rgba(193, 154, 78, 0.15) !important; color: #c19a4e !important; border: 1px solid var(--accent-bronze, #CD9A48) !important; font-weight: bold;';
                  } else {
                      $designBadgeStyle = 'background-color: rgba(255, 255, 255, 0.05) !important; color: #888 !important; border: 1px solid rgba(255,255,255,0.1) !important;';
                  }
              } else {
                  if ($isDesignYes) {
                      $designBadgeStyle = 'background-color: #3d241c !important; color: var(--accent-bronze, #CD9A48) !important; border: 1px solid #3d241c !important; font-weight: bold;';
                  } else {
                      $designBadgeStyle = 'background-color: rgba(92, 60, 38, 0.05) !important; color: #5c3c26 !important; border: 1px solid rgba(92, 60, 38, 0.15) !important;';
                  }
              }
              ?>
              <span class="spec-chip badge p-2" style="<?= $designBadgeStyle ?>">
                <strong>Design Available:</strong> <?= htmlspecialchars($product['Designing']); ?>
              </span>
            </div>

            <!-- Size and Fabric Selectors Form -->
            <form method="POST" action="<?= BASE_URL; ?>/index.php?page=cart_add" id="cartForm" class="fade-up delay-3">
                <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                <input type="hidden" name="qty" id="formQty" value="1">
                
                <div class="row g-3 mb-4">
                    <!-- Size Radios -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-light" style="font-size: 0.9rem; letter-spacing: 0.5px;">SIZE</label>
                        <?php
                        $sizeStock = [];
                        if (!empty($product['size'])) {
                            $parts = explode(',', $product['size']);
                            foreach ($parts as $p) {
                                $p = trim($p);
                                if (empty($p)) continue;
                                $sub = explode(':', $p);
                                if (count($sub) === 2) {
                                    $sizeStock[trim($sub[0])] = (int)trim($sub[1]);
                                } else {
                                    $sizeStock[$p] = (int)$product['quantity'];
                                }
                            }
                        }

                        $defaultSize = '';
                        foreach ($sizeStock as $sz => $stk) {
                            if ($stk > 0) {
                                $defaultSize = $sz;
                                break;
                            }
                        }
                        ?>
                        <div class="d-flex flex-wrap gap-2" style="padding: 12px; background-color: rgba(255,255,255,0.05); border: 1px solid rgba(193, 154, 78, 0.3); border-radius: 12px;">
                            <?php foreach ($sizeStock as $sz => $stk): ?>
                                <label class="form-check form-check-inline mb-2" style="margin: 0;">
                                    <input class="form-check-input" type="radio" name="size" value="<?= htmlspecialchars($sz) ?>" <?= ($sz === $defaultSize ? 'checked' : '') ?> <?= ($stk <= 0 ? 'disabled' : '') ?> required>
                                    <span class="form-check-label" style="padding: 8px 14px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.15); <?= ($stk <= 0 ? 'opacity:0.5; cursor:not-allowed;' : '') ?> background: rgba(255,255,255,0.08); color: #fff;">
                                        <?= htmlspecialchars($sz) ?> <?php if ($stk <= 0): ?>(Out of stock)<?php endif; ?>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Quantity & Add to Cart -->
                <div class="d-flex align-items-center gap-3">
                    <div class="single-qty-control" style="background-color: rgba(255,255,255,0.05); border: 1px solid rgba(193, 154, 78, 0.3); border-radius: 12px; display: inline-flex; align-items: center; padding: 4px;">
                        <button class="qty-btn-single btn btn-link text-light text-decoration-none" type="button" onclick="changeQty(-1)" style="font-size: 1.5rem; font-weight: 300; padding: 0 15px; border: none; box-shadow: none;">−</button>
                        <input class="qty-input-single text-center text-light bg-transparent border-0" type="number" id="qty" value="1" min="1" max="99" readonly style="width: 50px; font-size: 1.1rem; font-weight: bold; pointer-events: none;">
                        <button class="qty-btn-single btn btn-link text-light text-decoration-none" type="button" onclick="changeQty(1)" style="font-size: 1.5rem; font-weight: 300; padding: 0 15px; border: none; box-shadow: none;">+</button>
                    </div>
                    
                    <div class="flex-grow-1">
                        <?php if ((int)$product['quantity'] <= 0): ?>
                            <button type="button" class="btn w-100 d-flex align-items-center justify-content-center disabled" style="background: #333; color: #777; border: 1px solid #444; border-radius: 12px; height: 52px; font-weight: bold; cursor: not-allowed;" disabled>
                                <i class="fas fa-times-circle me-2"></i> Out of Stock
                            </button>
                        <?php else: ?>
                            <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center cart" style="height: 52px; font-size: 1.05rem; font-weight: 700; border-radius: 12px;">
                                <i class="fas fa-shopping-bag me-2"></i> Add to Cart
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
 
          </div>
  </div>
</div>

          <!-- Trust Badges & Share -->
          <div class="mt-auto d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="trust-badges d-flex flex-wrap gap-2">
              <div class="trust-item"><i class="bi bi-truck fs-5"></i> Free Shipping over $50</div>
              <div class="trust-item"><i class="bi bi-arrow-left fs-5"></i> 30-Day Returns</div>
              <div class="trust-item"><i class="bi bi-shield fs-5"></i> 2-Year Warranty</div>
              <div class="trust-item"><i class="bi bi-lock fs-5"></i> Secure Checkout</div>
            </div>
            <div class="share-row d-flex gap-2 align-items-center">
              <span>Share:</span>
              <a href="https:/www.facebook.com"><i class="bi bi-facebook"></i></a>
              <a href="https:/www.x.com"><i class="bi bi-twitter"></i></a>
              <a href="https:/www.pinterest.com"><i class="bi bi-pinterest"></i></a>
              <a href="https:/www.whatsapp.com"><i class="bi bi-whatsapp"></i></a>
            </div>
          </div>

        </div>
      
   

    <!-- Product Tabs -->
    <div class="product-tabs mt-5">
      <ul class="nav nav-tabs" id="productTabs">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-desc">Description</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-specs">Specifications</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-reviews" id="reviewTab">Reviews (42)</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-shipping">Shipping</button></li>
      </ul>
      <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="tab-desc"><?= htmlspecialchars($product['description']); ?></div>
        <div class="tab-pane fade" id="tab-specs">
          <table class="specs-table table table-bordered mt-3">
            <tr><td>Size</td><td><?= htmlspecialchars($product['size']); ?></td></tr>
            <tr><td>Fabric Type</td><td><?= htmlspecialchars($product['Fabric_Type']); ?></td></tr>
            <tr><td>Design Type</td><td><?= htmlspecialchars($product['Designing']); ?></td></tr>
          </table>
        </div>
        <!-- Reviews -->
        <div class="tab-pane fade" id="tab-reviews">
          <?php if (!empty($_SESSION['review_success'])): ?>
            <div class="alert alert-success mb-3"><?= htmlspecialchars($_SESSION['review_success']); ?></div>
            <?php unset($_SESSION['review_success']); ?>
          <?php endif; ?>
          <?php if (!empty($_SESSION['review_error'])): ?>
            <div class="alert alert-danger mb-3"><?= htmlspecialchars($_SESSION['review_error']); ?></div>
            <?php unset($_SESSION['review_error']); ?>
          <?php endif; ?>

          <!-- Summary -->
          <div class="review-summary">
            <div>
              <div class="big-rating"><?= htmlspecialchars($reviewSummary['average'] ?: '0.0'); ?></div>
              <div class="big-stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <i class="<?= $i <= round($reviewSummary['average']) ? 'fas fa-star' : 'far fa-star'; ?>"></i>
                <?php endfor; ?>
              </div>
              <div class="big-count">Based on <?= htmlspecialchars($reviewSummary['count']); ?> review<?= $reviewSummary['count'] === 1 ? '' : 's'; ?></div>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-lg-8">
              <?php if (count($reviews) === 0): ?>
                <div class="review-card">
                  <p class="review-text">No reviews yet. Be the first to review this product.</p>
                </div>
              <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                  <div class="review-card">
                    <div class="reviewer-name"><?= htmlspecialchars($review['reviewer_name'] ?: 'Customer'); ?></div>
                    <div class="stars mb-1">
                      <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="<?= $i <= (int)$review['rating'] ? 'fas fa-star' : 'far fa-star'; ?>"></i>
                      <?php endfor; ?>
                    </div>
                    <div class="review-date"><?= date('F j, Y', strtotime($review['created_at'])); ?> · Verified Purchase</div>
                    <p class="review-text"><?= nl2br(htmlspecialchars($review['comment'])); ?></p>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

          <div class="review-form-section mt-4">
            <?php if (!empty($_SESSION['customer_id'])): ?>
              <?php if ($canReview): ?>
                <div class="card p-4 mb-4">
                  <h5>Leave a Review</h5>
                  <form method="POST" action="<?= BASE_URL ?>/index.php?page=product_review">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">
                    <div class="mb-3">
                      <label class="form-label">Rating</label>
                      <select name="rating" class="form-control" required>
                        <option value="">Choose rating</option>
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                          <option value="<?= $i; ?>"><?= $i; ?> star<?= $i > 1 ? 's' : ''; ?></option>
                        <?php endfor; ?>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Your Review</label>
                      <textarea name="comment" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                  </form>
                </div>
              <?php else: ?>
                <div class="alert alert-info mb-4"><?= htmlspecialchars($reviewNotice ?: 'You cannot submit a review for this product.'); ?></div>
              <?php endif; ?>
            <?php else: ?>
              <div class="alert alert-info mb-4">Please <a href="<?= BASE_URL ?>/index.php?page=customer_login">login</a> to submit a review.</div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Shipping -->
        <div class="tab-pane fade" id="tab-shipping">
          <div class="row">
            <div class="col-lg-7">
              <div class="desc-body">
                <h5>Shipping Options</h5>
                <table class="specs-table mt-3">
                  <tr><td>Standard Shipping</td><td>3–5 business days · Free over $50</td></tr>
                  <tr><td>Express Shipping</td><td>1–2 business days · $12.99</td></tr>
                  <tr><td>Overnight</td><td>Next business day · $24.99</td></tr>
                  <tr><td>International</td><td>7–14 business days · From $19.99</td></tr>
                </table>
                <h5 style="margin-top:28px;">Returns Policy</h5>
                <p>We offer free returns within 30 days of purchase. Items must be in original, unused condition with all packaging and accessories included. Initiate a return from your account or contact our support team.</p>
                <h5>Warranty</h5>
                <p>This product is covered by a 2-year international warranty against manufacturing defects. Extended warranty plans are available at checkout.</p>
              </div>
            </div>
          </div>
        </div>

 </div>
    </div>
 </div>
  </div>
</section>

<!-- ── RELATED PRODUCTS ── -->
<section class="related-section">
  <div class="container">
    <span class="section-tag">You Might Also Like</span>
    <h2 class="section-title">Related Products</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">

      <?php foreach($related_products as $rel): ?>
      <?php $relatedImage = strtok($rel['image_url'], ','); ?>
      <div class="col">
        <div class="product-card">
          <div class="product-img-wrap">
            <img src="<?= BASE_URL ?>/<?= htmlspecialchars(trim($relatedImage)); ?>" alt="<?= htmlspecialchars($rel['name']); ?>"/>
          </div>
          <div class="p-info">
            <div class="p-stars">
              <?php for($i=0; $i<5; $i++): ?>
                  <i class="<?= $i < 4 ? 'fas fa-star' : 'far fa-star'; ?>"></i>
              <?php endfor; ?>
              <span>(<?= rand(10,100); ?>)</span>
            </div>
            <p class="p-name"><?= htmlspecialchars($rel['name']); ?></p>
            <div class="p-price">$<?= htmlspecialchars($rel['price']); ?></div>

            <form method="POST" action="<?= BASE_URL; ?>/index.php?page=cart_add">
              <input type="hidden" name="product_id" value="<?= $rel['id']; ?>">
              <input type="number" name="qty" value="1" min="1" class="form-control w-25 mb-2">
              <button type="submit" class="btn-card-cart">
                <i class="fas fa-shopping-bag me-2"></i>Add to Cart
              </button>
            </form>

          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </div>
</section>






<?php include('footer.php');?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function changeQty(amount){
    let qtyInput = document.getElementById('qty');
    let formQty = document.getElementById('formQty');

    let current = parseInt(qtyInput.value) || 1;
    current += amount;

    if(current < 1) current = 1;
    if(current > 99) current = 99;

    qtyInput.value = current;
    formQty.value = current; // sync
}

// also sync manually typed value
document.getElementById('qty').addEventListener('input', function(){
    document.getElementById('formQty').value = this.value;
});

(function() {
    const galleryImages = <?= json_encode(array_values(array_filter(array_map('trim', explode(',', $product['image_url'] ?? ''))))) ?>;
    const mainImg = document.getElementById('mainImg');
    const prevBtn = document.getElementById('prevImgBtn');
    const nextBtn = document.getElementById('nextImgBtn');
    const thumbButtons = document.querySelectorAll('.thumb-button');
    let currentImageIndex = 0;
    let sliderInterval = null;

    function getImageUrl(path) {
        return "<?= BASE_URL ?>/" + path;
    }

    function setGalleryImage(index) {
        if (!galleryImages.length) return;
        if (index < 0) index = galleryImages.length - 1;
        if (index >= galleryImages.length) index = 0;
        currentImageIndex = index;
        if (mainImg) {
            mainImg.src = getImageUrl(galleryImages[currentImageIndex]);
        }
        thumbButtons.forEach(btn => btn.classList.toggle('active-thumb', parseInt(btn.dataset.index) === currentImageIndex));
    }

    function startGalleryAutoplay() {
        stopGalleryAutoplay();
        sliderInterval = setInterval(() => setGalleryImage(currentImageIndex + 1), 3000);
    }

    function stopGalleryAutoplay() {
        if (sliderInterval) {
            clearInterval(sliderInterval);
            sliderInterval = null;
        }
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            setGalleryImage(currentImageIndex - 1);
            startGalleryAutoplay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            setGalleryImage(currentImageIndex + 1);
            startGalleryAutoplay();
        });
    }

    thumbButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            setGalleryImage(parseInt(this.dataset.index));
            startGalleryAutoplay();
        });
    });

    if (galleryImages.length > 0) {
        setGalleryImage(0);
        startGalleryAutoplay();
    }
})();
</script>
</body>
</html>
