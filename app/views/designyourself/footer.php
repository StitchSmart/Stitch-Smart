<!-- Help Banner removed as per request -->

<footer>
  <!-- ── Top section: 4 columns ── -->
  <div class="site-footer">
    <div class="container">
      <div class="row">

        <!-- Store Details -->
        <div class="col-12 col-sm-6 col-lg-3 footer-col">
          <h6>Stitch<span>Smart</span></h6>
          <p class="small text-muted">
             <?= htmlspecialchars($meta_description) ?>
          </p>
          <div class="contact-info small">
             <i class="bi bi-envelope me-2"></i> <?= htmlspecialchars($webmail) ?><br/>
             <i class="bi bi-telephone me-2"></i> <?= htmlspecialchars($webcontact) ?>
          </div>
          
          <div class="social-icons">
            <a href="<?= $facebook ?>" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="<?= $instagram ?>" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="<?= $pinterest ?>" aria-label="Pinterest"><i class="bi bi-pinterest"></i></a>
            <a href="<?= $linkdin ?>" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <!-- Shop -->
        <div class="col-12 col-sm-6 col-lg-3 footer-col">
          <h6>Shop Collections</h6>
          <ul>
            <li><a href="<?= BASE_URL; ?>/index.php?page=allproducts">Shop All</a></li>
            <?php foreach($categories as $cat): ?>
              <li><a href="<?= BASE_URL; ?>/index.php?page=products&category_id=<?= $cat['c_id']; ?>">
                <?= htmlspecialchars($cat['c_name']); ?>
              </a></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Customer Support -->
        <div class="col-12 col-sm-6 col-lg-3 footer-col">
          <h6>Customer Support</h6>
          <ul>
            <li><a href="<?= BASE_URL; ?>/index.php?page=contact">Contact Us</a></li>
            <li><a href="<?= BASE_URL; ?>/index.php?page=about">About Us</a></li>
            <li><a href="<?= BASE_URL; ?>/index.php?page=design">Design Yourself</a></li>
          </ul>
        </div>

        <!-- Policy -->
        <div class="col-12 col-sm-6 col-lg-3 footer-col">
          <h6>Policy & FAQ</h6>
          <ul>
            <li><a href="<?= BASE_URL; ?>/index.php?page=shipping-and-delivery">Shipping & Returns</a></li>
            <li><a href="<?= BASE_URL; ?>/index.php?page=terms-and-condition">Terms & Conditions</a></li>
            <li><a href="<?= BASE_URL; ?>/index.php?page=how-to-order">How to Order</a></li>
          </ul>
        </div>

      </div>
    </div>
  </div>

  <!-- ── Bottom section ── -->
  <div class="footer-bottom">
    <div class="container">
      <p>© 2026 StitchSmart Luxury Tailoring. All rights reserved.</p>
    </div>
  </div>
</footer> 

<link rel="stylesheet" href="<?= BASE_URL ?>/css/chatbot.css">
<script src="<?= BASE_URL ?>/js/chatbot.js"></script>