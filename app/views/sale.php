<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sales| <?= APP_NAME ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
 <link rel="stylesheet" href="<?= BASE_URL ?>css/navbar.css">
 <link rel="stylesheet" href="<?= BASE_URL ?>css/colors.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/footer.css">
   <link href="<?= BASE_URL ?>/css/style.css" rel="stylesheet">
   <link rel="stylesheet" href="<?= BASE_URL ?>css/cat-product.css">
   <link href="<?= BASE_URL ?>css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">

</head>
<style>
 .sale-hero{
    background: linear-gradient(135deg, #1a0f0a 0%, #2d1a12 100%);
    color:#fff;
    min-height:320px;
    display:flex;
    align-items:center;
}

.sale-hero h1{
    font-size:4rem;
    font-weight:800;
    line-height:1;
    color: #c19a4e !important;
}

.sale-hero p{
    font-size:1.1rem;
    opacity:0.95;
}

.sale-strip{
    background: linear-gradient(135deg, #c19a4e 0%, #a67c37 100%);
    color:#1a0f0a;
    font-weight:700;
    text-align:center;
    padding:10px;
    letter-spacing:0.5px;
}
.page2 {
    background-color: var(--bg-dark, #000);
}
.product-card{
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    transition:0.3s ease;
    position:relative;
    height:100%;
}

.product-card:hover{
    transform:translateY(-7px);
    box-shadow:0 12px 24px rgba(0,0,0,0.08);
}

.sale-badge{
    position:absolute;
    top:12px;
    left:12px;
    background:#111;
    color:#fff;
    font-size:12px;
    padding:5px 10px;
    border-radius:20px;
    z-index:2;
}

.product-img{
    height:260px;
    overflow:hidden;
}

.product-img img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.product-info{
    padding:16px;
    text-align:center;
}

.product-title{
    font-size:15px;
    font-weight:600;
    min-height:42px;
}

.new-price{
    font-size:18px;
    font-weight:700;
    color:#c19a4e;
}

.old-price{
    color:#888;
    text-decoration:line-through;
    margin-left:8px;
    font-size:14px;
}

.btn-view{
    background: linear-gradient(135deg, #c19a4e 0%, #a67c37 100%);
    color:#1a0f0a;
    border:none;
    padding:10px 14px;
    border-radius:8px;
    width:100%;
    font-weight:700;
    margin-top:12px;
    transition:0.3s;
}

.btn-view:hover{
    background:#1a0f0a;
    color:#c19a4e;
}

.pagination .page-link{
    color:#c19a4e;
    background: transparent;
    border-color: rgba(193,154,78,0.3);
}

.pagination .active .page-link{
    background: linear-gradient(135deg, #c19a4e 0%, #a67c37 100%);
    border-color:#c19a4e;
    color: #1a0f0a;
}
</style>

<body>


</head>

<body>
 <?php include('header.php'); ?>
<section class="sale-hero">
    <div class="container text-center">
        <p class="mb-2 text-uppercase">Limited Time Offer</p>
        <h1>UP TO 80% OFF</h1>
        <p class="mt-3">Featured pieces selected for the season</p>
    </div>
</section>

<div class="sale-strip">
    FEATURED SALE ITEMS • SHOP NOW
</div>
<div class="main">
    
    <div class="page2">
<!--Best Sellers-->
<section class="py-3 ">
  <div class="container bg-light py-5">
    <h2 class="text-center">Best Sellers</h2>
   <div class="row py-5">

<?php foreach($products as $product): ?>
    <?php if($product['featured'] != 1) continue; ?>
  <?php
               $price = (float)$product['price'];

$oldPrice = $price;
$newPrice = $price * 0.80;

$discount = 20; 
            ?>
       <div class="col-md-6 col-lg-3">
                <div class="product-card">

                    <span class="sale-badge">-<?= $discount ?>%</span>

                    <a href="<?= BASE_URL; ?>index.php?page=product_show&id=<?= $product['id']; ?>" class="text-decoration-none text-dark">
                        <div class="product-img">
                            <?php $productImage = strtok($product['image_url'], ','); ?>
                            <img src="<?= BASE_URL ?>/<?= htmlspecialchars(trim($productImage)); ?>"
                                 alt="<?= htmlspecialchars($product['name']); ?>">
                        </div>
                    </a>

                        <div class="product-info">
                            <a href="<?= BASE_URL; ?>index.php?page=product_show&id=<?= $product['id']; ?>" class="text-decoration-none text-dark">
                                <div class="product-title">
                                    <?= htmlspecialchars($product['name']); ?>
                                </div>
                            </a>

                        <div class="mt-2">
                            <span class="new-price">$<?= number_format($newPrice, 2); ?></span>
                            <span class="old-price">$<?= number_format($oldPrice, 2); ?></span>
                        </div>

                        <a href="<?= BASE_URL; ?>index.php?page=product_show&id=<?= $product['id']; ?>">
                            <button class="btn-view">View Product</button>
                        </a>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>

        </div>

        <!-- PAGINATION -->
        <?php if($totalPages > 1): ?>
        <div class="d-flex justify-content-center mt-5">
            <nav>
                <ul class="pagination">

                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=sales&p=<?= $page - 1 ?>">
                            Previous
                        </a>
                    </li>

                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=sales&p=<?= $i ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=sales&p=<?= $page + 1 ?>">
                            Next
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
        <?php endif; ?>

    </div>
</section>

</div>


<?php include('footer.php'); ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
