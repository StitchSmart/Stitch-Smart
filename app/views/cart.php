<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= APP_NAME ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= BASE_URL ?>css/navbar.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>css/footer.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/colors.css">
  <link href="<?= BASE_URL ?>css/single-product.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">

</head>
<body class="theme-aware-body">
<?php include('header.php'); ?>
<!-- ── BREADCRUMB ── -->
<div class="breadcrumb-bar mt-4">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active"><a href="#">Cart</a></li>

    </ol>
  </div>
</div>
<main>
<div class="container py-5" >
    <h2 class="mb-4 text-center">Your Cart</h2>

    <?php if(empty($_SESSION['cart'])): ?>
        <div class="alert alert-warning">
            Your cart is empty
        </div>
    <?php else: ?>

        <?php $total = 0; ?>

        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($_SESSION['cart'] as $id => $item): 
                    $itemTotal = $item['price'] * $item['qty'];
                    $total += $itemTotal;
                ?>
                <tr>
                    <td>
                        <strong style="color: var(--text-main, #3d241c); font-size: 1.05rem;"><?= htmlspecialchars($item['name']); ?></strong>
                        <?php if(!empty($item['size'])): ?>
                            <div style="font-size: 0.85rem; margin-top: 4px; color: var(--accent-bronze, #CD9A48);">
                                <span class="badge" style="background-color: rgba(193, 154, 78, 0.12); color: var(--accent-bronze, #CD9A48); border: 1px solid rgba(193, 154, 78, 0.2);">Size: <?= htmlspecialchars($item['size']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($item['fabric'])): ?>
                            <div style="font-size: 0.85rem; margin-top: 4px; color: var(--text-muted, #5c3c26);">
                                <span class="badge" style="background-color: rgba(92, 60, 38, 0.08); color: var(--text-muted, #5c3c26); border: 1px solid rgba(92, 60, 38, 0.15);">Fabric: <?= htmlspecialchars($item['fabric']); ?></span>
                            </div>
                        <?php endif; ?>
                    </td>

                    <td>
                       <img src="<?= BASE_URL ?>/<?= htmlspecialchars($item['image']) ?>" width="80px"/>
                             
                    </td>

                    <td>$(USD) <?= number_format($item['price']); ?></td>

                    <td>
                        <div class="qty-control">
                            <a href="<?= BASE_URL; ?>/index.php?page=cart_update&id=<?= $id; ?>&action=minus" class="qty-btn"><i class="bi bi-dash"></i></a>
                            <span class="qty-val"><?= $item['qty']; ?></span>
                            <a href="<?= BASE_URL; ?>/index.php?page=cart_update&id=<?= $id; ?>&action=add" class="qty-btn"><i class="bi bi-plus"></i></a>
                        </div>
                    </td>

                    <td>$(USD) <?= number_format($itemTotal); ?></td>

                    <td>
                        <a href="<?= BASE_URL; ?>/index.php?page=cart_remove&id=<?= $id; ?>" 
                           class="btn btn-danger btn-sm">
                            Remove
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Grand Total -->
        <div class="text-end">
            <h4>Total: Rs. <?= number_format($total); ?></h4>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between mt-4">
            <a href="<?= BASE_URL; ?>/index.php?page=products" class="btn btn-secondary">
                Continue Shopping
            </a>

         <a href="<?= BASE_URL; ?>/index.php?page=checkout" class="btn btn-success">
                Checkout 
            </a>
        </div>

    <?php endif; ?>
</div>
                </main>
<?php include('footer.php'); ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
