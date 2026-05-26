<div class="col-lg-3">

        <!-- Mobile filter toggle -->
        <button class="btn-mobile-filter mb-3 w-100" onclick="toggleFilter()">
          <i class="fas fa-sliders-h me-2"></i> Filter & Browse
        </button>

        <div class="sidebar-wrapper" id="sidebarWrapper">
          <div class="sidebar">

            <h2 class="sidebar-title">Browse by</h2>
            <ul class="sidebar-nav">
              <li><a href="<?= BASE_URL ?>/index.php?page=products">
    All Products
</a></li>
              
              <?php foreach($categories as $cat): ?>
              <li class="active"><a href="<?= BASE_URL; ?>/index.php?page=products&category_id=<?= $cat['c_id']; ?>"><strong>  <?= htmlspecialchars($cat['c_name']); ?></strong></a></li>
 
              <?php endforeach; ?>
            </ul>

            <!-- Price Filter -->
            

            
          </div>
        </div>
      </div>