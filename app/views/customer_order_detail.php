<?php
$hide_header = true;
$hide_footer = true;
$hide_chatbot = true;
include('header.php');
?>

<style>
    .order-detail-page {
        background: radial-gradient(circle at top right, rgba(193,154,78,0.16), transparent 22%),
                    radial-gradient(circle at bottom left, rgba(255,255,255,0.06), transparent 18%),
                    #090909;
    }
    .order-detail-hero {
        background: linear-gradient(135deg, rgba(193,154,78,0.24), rgba(12,12,12,0.96));
        border-radius: 32px;
        padding: 46px 40px;
        margin-bottom: 32px;
        border: 1px solid rgba(193,154,78,0.18);
        box-shadow: 0 32px 70px rgba(0,0,0,0.24);
        color: #fff;
    }
    .order-detail-hero h1 {
        font-size: 2.8rem;
        letter-spacing: -0.04em;
    }
    .order-detail-meta {
        color: rgba(255,255,255,0.78);
        font-size: 1rem;
    }
    .badge-status {
        display: inline-flex;
        align-items: center;
        padding: 0.55rem 1rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        background: rgba(255,255,255,0.08);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.14);
    }
    .order-insights {
        margin-top: 26px;
    }
    .insight-card {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 24px;
        padding: 22px 24px;
        box-shadow: 0 18px 38px rgba(0,0,0,0.14);
    }
    .insight-card span {
        display: block;
        color: rgba(255,255,255,0.72);
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-size: 0.75rem;
        margin-bottom: 0.7rem;
    }
    .insight-card strong {
        font-size: 1.65rem;
        color: #fff;
    }
    .order-summary-card,
    .order-items-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 28px;
        box-shadow: 0 18px 40px rgba(0,0,0,0.15);
    }
    .order-summary-card h5,
    .order-items-card h5 {
        color: #fff;
        font-size: 1.15rem;
        margin-bottom: 1.2rem;
    }
    .order-summary-card .label {
        color: rgba(255,255,255,0.72);
    }
    .order-summary-card .fw-semibold {
        color: #fff;
    }
    .order-items-card table thead th {
        border-bottom: 1px solid rgba(255,255,255,0.12);
        color: rgba(255,255,255,0.8);
        font-weight: 600;
    }
    .order-items-card table tbody tr {
        border-top: 1px solid rgba(255,255,255,0.06);
    }
    .order-items-card table tbody td {
        color: rgba(255,255,255,0.84);
        vertical-align: middle;
    }
    .order-items-card img {
        width: 72px;
        height: 72px;
        object-fit: cover;
        border-radius: 18px;
    }
    .order-summary-row {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 22px;
        margin-top: 24px;
    }
    .order-summary-row .label {
        color: rgba(255,255,255,0.72);
    }
    .order-summary-row .amount {
        color: #fff;
        font-weight: 700;
    }
    .text-muted {
        color: rgba(255,255,255,0.7) !important;
    }
    .order-detail-hero .hero-top-row {
        align-items: flex-start;
    }
    .order-detail-hero .hero-badge-row {
        margin-top: 1.5rem;
    }
    .btn-back-orders {
        background: linear-gradient(135deg, #c9a569, #a77c38);
        border: none;
        color: #1d120d;
        padding: 0.85rem 1.35rem;
        border-radius: 999px;
        font-weight: 700;
        box-shadow: 0 18px 34px rgba(193,154,78,0.18);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn-back-orders:hover {
        transform: translateY(-2px);
        box-shadow: 0 22px 40px rgba(193,154,78,0.22);
    }
</style>

<section class="py-5 order-detail-page">
    <div class="container">
        <div class="order-detail-hero">
            <div class="row hero-top-row align-items-start gy-3">
                <div class="col-lg-8">
                    <h1>Order #<?= htmlspecialchars($order['id']); ?></h1>
                    <p class="order-detail-meta mb-2">Placed on <?= htmlspecialchars($order['created_at'] ?? 'N/A'); ?> · <span class="badge-status"><?= htmlspecialchars($order['status']); ?></span></p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?= BASE_URL ?>/index.php?page=customer_orders" class="btn btn-back-orders">Back to Orders</a>
                </div>
                <div class="col-12 hero-badge-row">
                    <div class="badge-status" style="background: rgba(255,255,255,0.1); color: #f7df9d;">Free shipping on orders over $50</div>
                </div>
            </div>
            <div class="row order-insights mt-4 g-3">
                <div class="col-md-4">
                    <div class="insight-card">
                        <span>Items</span>
                        <strong><?= htmlspecialchars(count($items)); ?></strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="insight-card">
                        <span>Order total</span>
                        <strong>Rs <?= number_format($order['total'], 2); ?></strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="insight-card">
                        <span>Payment method</span>
                        <strong><?= htmlspecialchars(strtoupper($order['payment_method'] ?? 'COD')); ?></strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="order-items-card p-4">
                    <h5>Order Items</h5>
                    <?php if (empty($items)): ?>
                        <p class="text-muted">This order has no saved items.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th style="min-width: 260px;">Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <?php $productImage = strtok($item['product_image'] ?? '', ','); ?>
                                                    <?php if ($productImage): ?>
                                                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars(trim($productImage)); ?>" alt="<?= htmlspecialchars($item['product_name'] ?? 'Product'); ?>" class="rounded-3">
                                                    <?php endif; ?>
                                                    <div>
                                                        <div class="fw-semibold text-white"><?= htmlspecialchars($item['product_name'] ?? 'Product'); ?></div>
                                                        <div class="text-muted small">SKU: <?= htmlspecialchars($item['product_id'] ?? 'N/A'); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted">Rs <?= number_format($item['price'], 2); ?></td>
                                            <td class="text-muted"><?= htmlspecialchars($item['quantity']); ?></td>
                                            <td class="fw-semibold text-white">Rs <?= number_format($item['price'] * $item['quantity'], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="order-summary-card p-4">
                    <h5>Order Summary</h5>
                    <div class="mb-4">
                        <div class="label">Customer</div>
                        <div class="fw-semibold text-white"><?= htmlspecialchars($order['customer_name']); ?></div>
                    </div>
                    <div class="mb-4">
                        <div class="label">Email</div>
                        <div class="fw-semibold text-white"><?= htmlspecialchars($order['email']); ?></div>
                    </div>
                    <div class="mb-4">
                        <div class="label">Phone</div>
                        <div class="fw-semibold text-white"><?= htmlspecialchars($order['phone']); ?></div>
                    </div>
                    <div class="mb-4">
                        <div class="label">Shipping Address</div>
                        <div class="fw-semibold text-white" style="white-space: pre-line;"><?= nl2br(htmlspecialchars($order['address'])); ?></div>
                    </div>
                    <?php if (!empty($order['tracking_id'])): ?>
                        <div class="mb-4">
                            <div class="label">Tracking ID</div>
                            <div class="fw-semibold text-white"><?= htmlspecialchars($order['tracking_id']); ?></div>
                        </div>
                    <?php endif; ?>
                    <div class="order-summary-row">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="label">Order Total</span>
                            <span class="amount">Rs <?= number_format($order['total'], 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="label">Payment Status</span>
                            <span class="amount"><?= htmlspecialchars($order['status']); ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="label">Shipping</span>
                            <span class="amount">Express</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>
