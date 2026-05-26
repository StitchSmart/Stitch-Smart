<!DOCTYPE html>
<?php
$newOrderCount = 0;
if (class_exists('Database')) {
    $db = new Database();
    $conn = $db->connect();
    $result = $conn->query("SELECT COUNT(*) as c FROM orders WHERE status LIKE 'Pending%'");
    if ($result) {
        $newOrderCount = (int) $result->fetch_assoc()['c'];
    }
}
?>
<html>
<head>
    <title><?= $title ?? 'Admin' ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
<link href="<?= BASE_URL ?>/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/base.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/<?= $theme ?>.css">
</head>

<body>

<header>
    <div class="head">
        <div class="container-fluid text-light">
            <div class="box">
                <h4 class="mt-4">Stitch<span>Smart</span></h4>
                <div class="mt-3 d-flex gap-3 align-items-center justify-content-between">
                    <div class="d-flex gap-3 align-items-center">
                        <a href="<?= BASE_URL ?>/index.php?page=switch_theme&theme=theme-default" 
                           style="
                               display: inline-block;
                               padding: 6px 20px;
                               border-radius: 30px;
                               text-decoration: none;
                               font-weight: 600;
                               font-size: 0.9rem;
                               transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                               border: 2px solid #ccc;
                               <?= ($theme === 'theme-default') ? 'background: #fff; color: #000;' : 'background: transparent; color: #ccc;' ?>
                           "
                           onmouseover="this.style.transform='scale(1.05) translateY(-2px)'; <?= ($theme === 'theme-default') ? '' : 'this.style.borderColor=\'#fff\'; this.style.color=\'#fff\';' ?>"
                           onmouseout="this.style.transform='scale(1) translateY(0)'; <?= ($theme === 'theme-default') ? '' : 'this.style.borderColor=\'#ccc\'; this.style.color=\'#ccc\';' ?>"
                           >
                            <i class="bi bi-palette2 me-1"></i> Default
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?page=switch_theme&theme=theme-luxury" 
                           style="
                               display: inline-block;
                               padding: 6px 20px;
                               border-radius: 30px;
                               text-decoration: none;
                               font-weight: 600;
                               font-size: 0.9rem;
                               transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                               border: 2px solid var(--accent-bronze, #c19a4e);
                               <?= ($theme === 'theme-luxury') ? 'background: linear-gradient(135deg, #c19a4e 0%, #8b5a2b 100%); color: #000;' : 'background: transparent; color: #c19a4e;' ?>
                           "
                           onmouseover="this.style.transform='scale(1.05) translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(193, 154, 78, 0.4)';"
                           onmouseout="this.style.transform='scale(1) translateY(0)'; this.style.boxShadow='none';"
                           >
                            <i class="bi bi-stars me-1"></i> Luxury ✨
                        </a>
                    </div>
                    <a href="<?= BASE_URL ?>/index.php?page=manage_orders" class="order-bell" title="View pending orders">
                        <i class="bi bi-bell-fill"></i>
                        <?php if ($newOrderCount > 0): ?>
                            <span class="notif-badge"><?= $newOrderCount ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                <h1 class="text-center"><?= $title ?? 'Admin' ?></h1>
                <p class="text-center">Manage content, products, categories, and orders of E-commerce store.</p>
            </div>
        </div>
    </div>
</header>

<main>
    <div class="row mt-5 mx-0 px-3">
        
        <?php include '../app/views/admin/sidebar.php'; ?>

        <div class="col-xl-9 col-sm-8">

            <!-- Global Notifications -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['errors'])): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Please correct the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach ($_SESSION['errors'] as $err): ?>
                            <li><?= $err ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-x-circle-fill me-2"></i> <?= $_SESSION['error'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php require_once "../app/views/" . $view; ?>

        </div>

    </div>
</main>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

</body>
</html>