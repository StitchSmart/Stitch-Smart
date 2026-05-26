<?php
$meta_description = trim($meta_description ?? 'StitchSmart - Tailoring quality products with fast shipping.');
$webmail = trim($webmail ?? 'info@stitchsmart.com');
$webcontact = trim($webcontact ?? 'StitchSmart');
$facebook = trim($facebook ?? '');
$instagram = trim($instagram ?? '');
$pinterest = trim($pinterest ?? '');
$linkdin = trim($linkdin ?? '');
$footer_categories = isset($categories) && is_array($categories) ? $categories : [];
if (!empty($hide_footer)) {
    return;
}
?>

<style>
    footer.footer {
        background: #000 !important;
        color: #e2e8f0 !important;
    }
    footer.footer .site-footer {
        background: #000 !important;
        border-top: 1px solid rgba(193,154,78,0.2) !important;
    }
    footer.footer .footer-col h6 {
        color: #c19a4e !important;
    }
    footer.footer .footer-col p,
    footer.footer .footer-col address,
    footer.footer .footer-col ul li a,
    footer.footer .social-icons a,
    footer.footer .footer-bottom p {
        color: #e2e8f0 !important;
    }
    footer.footer .footer-col ul li a:hover,
    footer.footer .social-icons a:hover {
        color: #c19a4e !important;
        padding-left: 5px;
        transition: all 0.3s ease;
    }
    footer.footer .help-banner {
        background: #000 !important;
    }
    footer.footer .btn-help {
        border: 2px solid #c19a4e !important;
        color: #c19a4e !important;
        background: transparent !important;
    }
    footer.footer .btn-help:hover {
        background: #c19a4e !important;
        color: #000 !important;
    }
</style>

<footer class="footer">
  <!-- ── Top section: 4 columns ── -->
  <div class="site-footer">
    <div class="container">
      <div class="row">

        <!-- Store Location -->
        <div class="col-12 col-sm-6 col-md-3 footer-col">
          <h6>Store Details</h6>
          <p class="footer-desc"><?= htmlspecialchars($meta_description); ?></p>
          <p>
            <a href="mailto:<?= htmlspecialchars($webmail); ?>"><?= htmlspecialchars($webmail); ?></a><br/>
            <?= htmlspecialchars($webcontact); ?>
          </p>
          <div class="social-icons">
            <?php if (!empty($facebook)): ?>
              <a href="<?= htmlspecialchars($facebook); ?>" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <?php endif; ?>
            <?php if (!empty($instagram)): ?>
              <a href="<?= htmlspecialchars($instagram); ?>" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <?php endif; ?>
            <?php if (!empty($pinterest)): ?>
              <a href="<?= htmlspecialchars($pinterest); ?>" aria-label="Pinterest"><i class="bi bi-pinterest"></i></a>
            <?php endif; ?>
            <?php if (!empty($linkdin)): ?>
              <a href="<?= htmlspecialchars($linkdin); ?>" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
            <?php endif; ?>
          </div>
        </div>

        <!-- Shop -->
        <div class="col-12 col-sm-6 col-md-2 footer-col">
          <h6>Shop</h6>
          <ul>
            <?php if (!empty($footer_categories)): ?>
              <?php foreach ($footer_categories as $cat): ?>
                <li><a href="<?= BASE_URL; ?>/index.php?page=products&category_id=<?= $cat['c_id']; ?>"><?= htmlspecialchars($cat['c_name']); ?></a></li>
              <?php endforeach; ?>
            <?php else: ?>
              <li><a href="<?= BASE_URL; ?>/index.php?page=products">Shop All</a></li>
            <?php endif; ?>
          </ul>
        </div>

        <!-- Customer Support -->
        <div class="col-12 col-md-5 footer-col mt-3 mt-md-0">
          <h6>Customer Support</h6>
          <ul class="footer-double-col">
            <li><a href="<?= BASE_URL ?>/index.php?page=contact">Contact Us</a></li>
            <?php $whatsapp_phone = preg_replace('/[^0-9]/', '', $webcontact); ?>
            <li><a href="https://wa.me/<?= $whatsapp_phone ?>" target="_blank" class="text-success"><i class="bi bi-whatsapp"></i> Help desk</a></li>
            <?php 
            require_once BASE_PATH.'/app/models/pages.php';
            $db = (new Database())->connect();
            $pModel = new Page($db);
            $footer_pages = $pModel->getAllPages();
            foreach($footer_pages as $fp): 
                // Skip policy-related pages, the merged help desk, and the legacy duplicate ourstory to avoid duplication in Customer Support
                $skip_slugs = ['shipping-and-delivery', 'return-and-refunds', 'terms-and-condition', 'how-to-order', 'help-desk', 'ourstory'];
                if (in_array($fp['slug'], $skip_slugs)) {
                    continue;
                }
            ?>
                <li><a href="<?= BASE_URL ?>index.php?page=page&slug=<?= $fp['slug'] ?>"><?= htmlspecialchars($fp['title']) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Policy -->
        <div class="col-12 col-sm-6 col-md-2 footer-col mt-3 mt-md-0">
          <h6>Policy</h6>
          <ul>
            <li><a href="<?= BASE_URL ?>index.php?page=shipping-and-delivery">Shipping &amp; Returns</a></li>
            <li><a href="<?= BASE_URL ?>index.php?page=terms-and-condition">Terms &amp; Conditions</a></li>
            <li><a href="<?= BASE_URL ?>index.php?page=how-to-order">FAQ</a></li>
          </ul>
        </div>

      </div>
    </div>
  </div>

  <!-- ── Bottom section: payment methods ── -->
  <div class="footer-bottom">
    <div class="container">
      <!-- Footer copyright removed as requested -->
    </div>
  </div>
</footer>

<?php if (empty($hide_chatbot)): ?>
<link rel="stylesheet" href="<?= BASE_URL ?>css/chatbot.css?v=<?= time() ?>">
<script src="<?= BASE_URL ?>js/chatbot.js?v=<?= time() ?>"></script>
<?php endif; ?>