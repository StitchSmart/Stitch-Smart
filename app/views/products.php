<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= APP_NAME ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
 <link rel="stylesheet" href="<?= BASE_URL ?>css/navbar.css">
 <link rel="stylesheet" href="<?= BASE_URL ?>css/colors.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/footer.css">
   <link rel="stylesheet" href="<?= BASE_URL ?>css/cat-product.css">
   <link href="<?= BASE_URL ?>css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">

</head>
<body>
 <?php include('header.php'); ?>

<!-- ── BREADCRUMB ── -->
<div class="breadcrumb-bar">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Shop</a></li>
    <?php if (isset($_GET['search'])): ?>
    <li class="breadcrumb-item active"><?= htmlspecialchars($_GET['search']); ?></li>
   <?php endif; ?> 
<?php if($category_name): ?>
    <li class="breadcrumb-item active"><?= $category_name ?></li>
<?php endif; ?>
    </ol>
  </div>
</div>

<!-- ── MAIN LAYOUT ── -->
<div class="shop-layout">
  <div class="container">
    <div class="row g-4">

      <!-- ── SIDEBAR ── -->
      <?php include('sidebar.php'); ?>

      <!-- ── PRODUCTS GRID ── -->
      <div class="col-lg-9">

        <!-- Header row -->
       <div class="products-header d-flex justify-content-between align-items-center">

    <p class="products-count">
        <?= $total_products ?> products
    </p>

    <!-- Sort Dropdown -->
    <form method="GET">
        <input type="hidden" name="page" value="products">

        <?php if(isset($_GET['category_id'])): ?>
            <input type="hidden" name="category_id" value="<?= $_GET['category_id']; ?>">
        <?php endif; ?>

        <?php if(isset($_GET['search'])): ?>
            <input type="hidden" name="search" value="<?= $_GET['search']; ?>">
        <?php endif; ?>

        <select name="sort" class="sort-select" onchange="this.form.submit()">

            <option value="">Sort by: Recommended</option>

            <option value="low" <?= ($_GET['sort'] ?? '') == 'low' ? 'selected' : '' ?>>
                Price: Low to High
            </option>

            <option value="high" <?= ($_GET['sort'] ?? '') == 'high' ? 'selected' : '' ?>>
                Price: High to Low
            </option>

            <option value="stock" <?= ($_GET['sort'] ?? '') == 'stock' ? 'selected' : '' ?>>
                In Stock
            </option>

        </select>
    </form>

</div>
 <?php if(isset($_GET['search'])): ?>
    <h5>
        Showing results for: 
        "<strong><?= htmlspecialchars($_GET['search']); ?></strong>"
    </h5>
<?php endif; ?>
        <!-- Products -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3">

          <!-- Card -->
        <?php foreach($products as $product): ?>
          <div class="col">
            <div class="product-card">
              <span class="product-badge new">New</span>
              <div class="product-img-wrap">
                <?php $productImage = strtok($product['image_url'], ','); ?>
                <img src="<?= BASE_URL ?>/<?= htmlspecialchars(trim($productImage)) ?>" alt="Laptop"/>
              </div>
              <div class="product-info">
                <div class="stars">
                  <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                  <span>(42)</span>
                </div>
                <p class="product-name"><?= $product['name']; ?></p>
                <div class="product-price"><?= $product['price']; ?></div>
                <a href="<?= BASE_URL; ?>index.php?page=product_show&id=<?= $product['id']; ?>"><button class="btn-add-cart">View Product</button></a>
              </div>
            </div>
          </div>
<?php endforeach; ?>
         


        </div>

        <!-- Pagination -->
        <div class="pagination-wrap">
          <nav>
            <ul class="pagination">
              <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-left" style="font-size:0.7rem;"></i></a></li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right" style="font-size:0.7rem;"></i></a></li>
            </ul>
          </nav>
        </div>

      </div>
    </div>
  </div>
</div>


<?php include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Mobile sidebar toggle
  function toggleFilter() {
    const wrapper = document.getElementById('sidebarWrapper');
    wrapper.classList.toggle('open');
  }

  // Active category highlight
 document.querySelectorAll('.sidebar-nav li a').forEach(link => {
  link.addEventListener('click', function() {
    document.querySelectorAll('.sidebar-nav li').forEach(li => li.classList.remove('active'));
    this.closest('li').classList.add('active');
  });
  });
</script>
</body>
</html>