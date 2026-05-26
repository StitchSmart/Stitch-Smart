<!-- order-success.php -->
<link href="<?= BASE_URL ?>/css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">
<section class="order-success-section">
  <div class="container">
    <div class="success-card">
      <div class="success-icon">
        <i class="fas fa-check-circle"></i>
      </div>
      <h2>🎉 Order Placed Successfully!</h2>
      <p class="order-id">Your Order ID: <strong>#<?= $order_id; ?></strong></p>
      <p class="thank-you">Thank you for shopping with us! Your order is being processed and you will receive a confirmation email shortly.</p>

      <div class="success-actions">
        <a href="<?= BASE_URL; ?>" class="btn btn-primary">Continue Shopping</a>
      </div>

      <div class="trust-badges">
        <div class="badge"><i class="fas fa-shipping-fast"></i> Free Shipping</div>
        <div class="badge"><i class="fas fa-undo"></i> 30-Day Returns</div>
        <div class="badge"><i class="fas fa-lock"></i> Secure Payment</div>
      </div>
    </div>
  </div>
</section>

<style>
.order-success-section {
  padding: 60px 20px;
  background: #f9f9f9;
  min-height: 70vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.success-card {
  background: #fff;
  padding: 40px 30px;
  max-width: 600px;
  width: 100%;
  text-align: center;
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.success-icon {
  font-size: 60px;
  color: #28a745;
  margin-bottom: 20px;
}

h2 {
  font-size: 28px;
  margin-bottom: 10px;
  color: #333;
}

.order-id {
  font-size: 18px;
  color: #555;
  margin-bottom: 20px;
}

.thank-you {
  color: #666;
  font-size: 16px;
  margin-bottom: 30px;
}

.success-actions .btn {
  margin: 5px;
  padding: 10px 25px;
  font-size: 16px;
  border-radius: 6px;
  text-decoration: none;
}

.success-actions .btn-primary {
  background: #007bff;
  color: #fff;
  border: none;
}

.success-actions .btn-primary:hover {
  background: #0056b3;
}

.success-actions .btn-outline-secondary {
  background: transparent;
  color: #6c757d;
  border: 2px solid #6c757d;
}

.success-actions .btn-outline-secondary:hover {
  background: #6c757d;
  color: #fff;
}

.trust-badges {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-top: 30px;
  flex-wrap: wrap;
}

.trust-badges .badge {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #555;
  font-size: 14px;
}

.trust-badges .badge i {
  color: #007bff;
}
</style>

<!-- Make sure Font Awesome is loaded -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
