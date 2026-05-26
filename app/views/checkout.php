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
<style>
  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* Page container feel */
.checkout-wrapper {
    padding: 40px 0;
}

/* LEFT FORM CARD */
.checkout-form {
    background: var(--bg-card, #0a0a0a);
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    border: 1px solid rgba(193, 154, 78, 0.2);
}

.checkout-form h3 {
    font-weight: 700;
    margin-bottom: 25px;
    color: var(--accent-bronze, #c19a4e);
}

/* INPUT FIELDS */
.checkout-form .form-control {
    border-radius: 10px;
    padding: 12px 14px;
    border: 1px solid rgba(193, 154, 78, 0.3);
    transition: 0.3s;
    background: rgba(255,255,255,0.05);
    color: #fff;
}

.checkout-form .form-control:focus {
    border-color: var(--accent-bronze, #c19a4e);
    box-shadow: 0 0 0 0.15rem rgba(193, 154, 78, 0.2);
}

/* LABELS */
.checkout-form label {
    font-weight: 500;
    margin-bottom: 6px;
    color: var(--accent-bronze, #c19a4e);
}

/* PAYMENT SECTION */
.payment-box {
    background: rgba(255,255,255,0.03);
    padding: 15px;
    border-radius: 12px;
    border: 1px solid rgba(193, 154, 78, 0.2);
}

.form-check {
    margin-bottom: 10px;
}

/* BUTTON */
.checkout-btn {
    background: linear-gradient(135deg, #c19a4e 0%, #a67c37 100%);
    border: none;
    padding: 14px;
    font-weight: 600;
    color: #1a0f0a;
    border-radius: 12px;
    transition: 0.3s;
}

.checkout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(193, 154, 78, 0.3);
}

/* ORDER SUMMARY */
.order-card {
    background: var(--bg-card, #0a0a0a);
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    border: 1px solid rgba(193, 154, 78, 0.2);
    position: sticky;
    top: 20px;
}

.order-card h4 {
    font-weight: 700;
    margin-bottom: 20px;
}

.order-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
    color: rgba(255,255,255,0.7);
}

.order-total {
    display: flex;
    justify-content: space-between;
    font-size: 18px;
    font-weight: 700;
    margin-top: 15px;
}

/* RESPONSIVE TWEAK */
@media (max-width: 768px) {
    .order-card {
        position: static;
        margin-top: 20px;
    }
}

/* AUTH TABS */
.auth-nav .nav-link {
    color: #fff;
    border: 1px solid #c19a4e;
    border-radius: 0;
}
.auth-nav .nav-item:first-child .nav-link {
    border-radius: 8px 0 0 8px;
}
.auth-nav .nav-item:last-child .nav-link {
    border-radius: 0 8px 8px 0;
}
.auth-nav .nav-link.active {
    background-color: #c19a4e;
    color: #000;
    font-weight: bold;
}
</style>
</head>
<body>
<?php include('header.php'); ?>
<div class="container py-5">
  <div class="row g-5">

   
    <div class="col-lg-7">
      <h3 class="mb-4">Billing Details</h3>

      <?php if(isset($_SESSION['checkout_error'])): ?>
          <div class="alert alert-danger p-3 mb-4" style="border-radius: 12px; font-weight: 600;">
              <?= htmlspecialchars($_SESSION['checkout_error']); unset($_SESSION['checkout_error']); ?>
          </div>
      <?php endif; ?>

      <form method="POST" action="<?= BASE_URL; ?>/index.php?page=place_order">

        <div class="mb-3">
          <label>Name</label>
          <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($_SESSION['customer_name'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
          <label>Phone</label>
          <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($_SESSION['customer_phone'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_SESSION['customer_email'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
          <label>Address</label>
          <textarea name="address" class="form-control" required></textarea>
        </div>

        <!-- PAYMENT METHODS -->
        <h5 class="mt-4">Payment Method</h5>

        <div class="form-check">
          <input class="form-check-input" type="radio" name="payment_method" value="cod" checked>
          <label class="form-check-label">Cash on Delivery</label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="radio" name="payment_method" value="bank">
          <label class="form-check-label">Bank Transfer (Demo)</label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="radio" name="payment_method" value="card">
          <label class="form-check-label">Credit/Debit Card (Demo)</label>
        </div>

        <button class="btn btn-dark mt-4 w-100 checkout-btn">
          Place Order
        </button>

      </form>
    </div>

    <!-- RIGHT SIDE (CART SUMMARY & LOGIN) -->
    <div class="col-lg-5">

      <?php if(!isset($_SESSION['customer_logged_in'])): ?>
      <div class="card shadow-sm p-4 mb-4" style="background: var(--bg-card, #0a0a0a); border: 1px solid rgba(193, 154, 78, 0.2); border-radius: 16px;">
          <div class="d-flex justify-content-between align-items-center">
              <h4 class="mb-0" style="color: var(--accent-bronze, #c19a4e); font-weight: 700;">Account</h4>
              <button class="btn btn-sm btn-outline-warning" type="button" data-bs-toggle="collapse" data-bs-target="#loginCollapse" aria-expanded="false" aria-controls="loginCollapse" style="border-radius: 8px;">
                  Sign In / Sign Up
              </button>
          </div>
          
          <div class="collapse <?php echo (isset($_SESSION['login_error']) || isset($_SESSION['register_error'])) ? 'show' : ''; ?> mt-4" id="loginCollapse">
              
              <!-- Nav Tabs -->
              <ul class="nav nav-pills nav-justified mb-4 auth-nav" id="authTabs" role="tablist">
                  <li class="nav-item" role="presentation">
                      <button class="nav-link <?php echo isset($_SESSION['register_error']) ? '' : 'active'; ?>" id="signin-tab" data-bs-toggle="tab" data-bs-target="#signin" type="button" role="tab" aria-controls="signin" aria-selected="true">Sign In</button>
                  </li>
                  <li class="nav-item" role="presentation">
                      <button class="nav-link <?php echo isset($_SESSION['register_error']) ? 'active' : ''; ?>" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup" type="button" role="tab" aria-controls="signup" aria-selected="false">Sign Up</button>
                  </li>
              </ul>

              <!-- Tab Content -->
              <div class="tab-content" id="authTabsContent">
                  
                  <!-- Sign In Tab -->
                  <div class="tab-pane fade <?php echo isset($_SESSION['register_error']) ? '' : 'show active'; ?>" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                      <?php if(isset($_SESSION['login_error'])): ?>
                          <div class="alert alert-danger p-2 mb-3" style="font-size: 0.9rem; border-radius: 8px;"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
                      <?php endif; ?>

                      <form method="POST" action="<?= BASE_URL; ?>index.php?page=customer_login">
                          <input type="hidden" name="redirect" value="checkout">
                          <div class="mb-2">
                              <input type="email" name="email" class="form-control" placeholder="Email Address" required style="background: rgba(255,255,255,0.05); color: #fff; border-color: rgba(193, 154, 78, 0.3);">
                          </div>
                          <div class="mb-3">
                              <input type="password" name="password" class="form-control" placeholder="Password" required style="background: rgba(255,255,255,0.05); color: #fff; border-color: rgba(193, 154, 78, 0.3);">
                          </div>
                          <div class="d-flex justify-content-between align-items-center mb-3">
                              <button class="checkout-btn w-50" style="padding: 10px;">Sign In</button>
                              <a href="<?= BASE_URL; ?>index.php?page=customer_forgot_password" style="color: var(--accent-bronze, #c19a4e); font-size: 0.85rem; text-decoration: underline;">Forgot Password?</a>
                          </div>
                      </form>
                  </div>

                  <!-- Sign Up Tab -->
                  <div class="tab-pane fade <?php echo isset($_SESSION['register_error']) ? 'show active' : ''; ?>" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                      <?php if(isset($_SESSION['register_error'])): ?>
                          <div class="alert alert-danger p-2 mb-3" style="font-size: 0.9rem; border-radius: 8px;"><?= $_SESSION['register_error']; unset($_SESSION['register_error']); ?></div>
                      <?php endif; ?>

                      <form method="POST" action="<?= BASE_URL; ?>index.php?page=customer_register">
                          <input type="hidden" name="redirect" value="checkout">
                          <div class="mb-2">
                              <input type="text" name="name" class="form-control" placeholder="Full Name" required style="background: rgba(255,255,255,0.05); color: #fff; border-color: rgba(193, 154, 78, 0.3);">
                          </div>
                          <div class="mb-2">
                              <input type="text" name="phone" class="form-control" placeholder="Phone Number" style="background: rgba(255,255,255,0.05); color: #fff; border-color: rgba(193, 154, 78, 0.3);">
                          </div>
                          <div class="mb-2">
                              <input type="email" name="email" class="form-control" placeholder="Email Address" required style="background: rgba(255,255,255,0.05); color: #fff; border-color: rgba(193, 154, 78, 0.3);">
                          </div>
                          <div class="mb-3">
                              <input type="password" name="password" class="form-control" placeholder="Password" required style="background: rgba(255,255,255,0.05); color: #fff; border-color: rgba(193, 154, 78, 0.3);">
                          </div>
                          <button class="checkout-btn w-100" style="padding: 10px;">Create Account</button>
                      </form>
                  </div>

              </div>
          </div>
      </div>
      <?php else: ?>
      <div class="card shadow-sm p-4 mb-4" style="background: var(--bg-card, #0a0a0a); border: 1px solid rgba(193, 154, 78, 0.2); border-radius: 16px;">
          <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0" style="color: var(--accent-bronze, #c19a4e); font-weight: 700;">Welcome back, <br><span style="color: #fff; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['customer_name']); ?></span></h5>
              <a href="<?= BASE_URL; ?>index.php?page=customer_logout&redirect=checkout" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;">Sign Out</a>
          </div>
      </div>
      <?php endif; ?>

      <div class="card shadow-sm p-4 order-card">

        <h4 class="mb-3">Your Order 🛒</h4>

        <?php foreach($cart as $item): ?>
          <div class="d-flex justify-content-between mb-2">
            <div>
              <?= $item['name']; ?> × <?= $item['qty']; ?>
            </div>
            <div>
              Rs. <?= number_format($item['price'] * $item['qty']); ?>
            </div>
          </div>
        <?php endforeach; ?>

        <hr>

        <div class="d-flex justify-content-between">
          <strong>Total</strong>
          <strong>Rs. <?= number_format($total); ?></strong>
        </div>

      </div>
    </div>

  </div>
</div>
<?php include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
