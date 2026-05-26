<!-- design -->
<nav class="logo-nav py-3">
    <div class="container d-flex justify-content-between align-items-center">

        <!-- Logo -->
        <a class="navbar-brand" href="<?= BASE_URL ?>/index.php?page=home">
            Stitch<span>Smart</span>
        </a>

        <!-- Right Side -->
        <div class="d-flex align-items-center gap-4">

            <!-- Search removed as per request -->

            <!-- Cart -->
            <a href="<?= BASE_URL; ?>/index.php?page=cart" class="position-relative cart-icon fs-5">
                <i class="bi bi-cart"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-cart">
                    0
                </span>
            </a>
           
        </div>
    </div>
</nav>
