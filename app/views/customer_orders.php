<?php
$hide_header = true;
$hide_footer = true;
include('header.php');
?>

<style>
    .customer-orders-page {
        background: radial-gradient(circle at top left, rgba(193,154,78,0.18), transparent 20%),
                    radial-gradient(circle at bottom right, rgba(97,64,22,0.12), transparent 24%),
                    #090909;
    }
    .customer-orders-hero {
        background: linear-gradient(135deg, rgba(193,154,78,0.24), rgba(8,8,8,0.96));
        border-radius: 30px;
        padding: 48px 40px;
        margin-bottom: 36px;
        color: #fff;
        box-shadow: 0 30px 80px rgba(0,0,0,0.26);
        border: 1px solid rgba(193,154,78,0.18);
    }
    .customer-orders-hero h1 {
        font-size: 3rem;
        margin-bottom: 0.9rem;
        letter-spacing: -0.04em;
    }
    .customer-orders-hero p {
        color: rgba(255,255,255,0.72);
        font-size: 1.05rem;
        max-width: 720px;
    }
    .customer-orders-hero .hero-chip {
        display: inline-flex;
        align-items: center;
        padding: 0.7rem 1.05rem;
        border-radius: 999px;
        background: rgba(255,255,255,0.08);
        color: #f8e5b4;
        border: 1px solid rgba(255,255,255,0.12);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-top: 18px;
    }
    .summary-panel {
        margin-top: -28px;
        margin-bottom: 32px;
    }
    .summary-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 26px;
        padding: 24px 28px;
        box-shadow: 0 18px 40px rgba(0,0,0,0.12);
        color: #fff;
        min-height: 150px;
    }
    .summary-card .summary-title {
        color: rgba(255,255,255,0.72);
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-size: 0.78rem;
        margin-bottom: 0.8rem;
    }
    .summary-card .summary-value {
        font-size: 2.1rem;
        font-weight: 700;
    }
    .order-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 28px;
        padding: 30px;
        box-shadow: 0 18px 42px rgba(0,0,0,0.14);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .order-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.22);
    }
    .order-card .order-label {
        color: rgba(255,255,255,0.68);
        text-transform: uppercase;
        font-size: 0.78rem;
        letter-spacing: 0.16em;
        margin-bottom: 0.45rem;
    }
    .order-card .order-value {
        font-size: 2.3rem;
        font-weight: 800;
        color: #fff;
    }
    .order-card .order-meta,
    .customer-orders-page .text-muted {
        color: rgba(255,255,255,0.72) !important;
    }
    .customer-orders-page .fw-semibold {
        color: #fff !important;
    }
    .btn-view-order {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        background: linear-gradient(135deg, #c19a4e, #a67c37);
        border: none;
        color: #fff;
        padding: 0.82rem 1.45rem;
        border-radius: 999px;
        box-shadow: 0 16px 30px rgba(193,154,78,0.18);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        font-weight: 700;
        min-width: 170px;
    }
    .btn-view-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 22px 40px rgba(193,154,78,0.22);
    }
    .empty-state {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 130px;
        padding: 0.8rem 1rem;
        border-radius: 999px;
        font-weight: 700;
        letter-spacing: 0.04em;
        font-size: 0.8rem;
        text-transform: uppercase;
    }
    .status-pending { background: rgba(245,152,0,0.18); color: #f6c86d; }
    .status-delivered { background: rgba(40,167,69,0.18); color: #abe2a1; }
    .status-cancelled { background: rgba(220,53,69,0.18); color: #f5a9ae; }
    .status-processing { background: rgba(13,110,253,0.18); color: #9bb8ff; }
    .empty-state {
        background: rgba(255,255,255,0.03);
        border: 1px dashed rgba(255,255,255,0.16);
        border-radius: 26px;
        padding: 42px;
        color: rgba(255,255,255,0.78);
        text-align: center;
        box-shadow: 0 14px 28px rgba(0,0,0,0.14);
    }
    .empty-state h3 {
        font-size: 1.9rem;
        margin-bottom: 0.8rem;
    }
    .empty-state p {
        margin-bottom: 1.4rem;
        color: rgba(255,255,255,0.72);
    }
</style>

<section class="py-5 customer-orders-page">
    <div class="container">
        <div class="customer-orders-hero">
            <div class="row align-items-center gy-4">
                <div class="col-lg-8">
                    <span class="hero-chip">Premium order dashboard</span>
                    <h1>Your Order History</h1>
                    <p>Experience a polished order summary with clear status indicators, premium cards, and luxury styling.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?= BASE_URL ?>/index.php?page=home" class="btn btn-view-order">Continue Shopping</a>
                </div>
            </div>

            <?php if (!empty($lastMessage) || !empty($recentSearches)): ?>
                <div class="row g-4 mb-4">
                    <div class="col-lg-12">
                        <div class="order-card">
                            <h5>Activity & History</h5>
                            <div class="mt-3">
                                <?php if (!empty($lastMessage)): ?>
                                    <div class="mb-2 text-muted">Last conversation</div>
                                    <div class="mb-3 p-3" style="background: rgba(255,255,255,0.02); border-radius:12px;">
                                        <strong><?= htmlspecialchars(ucfirst($lastMessage['role'])); ?>:</strong>
                                        <span class="text-white-75"> <?= htmlspecialchars($lastMessage['message']); ?></span>
                                        <div class="small text-muted"><?= htmlspecialchars($lastMessage['created_at']); ?></div>
                                                <div class="mt-2"><a href="<?= BASE_URL ?>/index.php?page=home&open_chat=1" id="open-chat-history" class="btn btn-view-order btn-sm">Open Chat</a></div>
                                        <?php foreach ($recentSearches as $s): ?>
                                            <a href="<?= BASE_URL ?>/index.php?page=products&search=<?= urlencode($s['query']); ?>" class="btn btn-outline-light btn-sm"><?= htmlspecialchars($s['query']); ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-muted">No recent searches.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if (empty($orders)): ?>
            <div class="empty-state">
                <h3>Nothing here yet</h3>
                <p>Your order history will appear here once you complete a purchase. Until then, explore our curated collections.</p>
                <a href="<?= BASE_URL ?>/index.php?page=home" class="btn btn-view-order">Start Shopping</a>
            </div>
        <?php else: ?>
            <?php
                $orderCount = count($orders);
                $totalSpent = array_sum(array_column($orders, 'total'));
                $pendingCount = count(array_filter($orders, function($order) {
                    return stripos($order['status'] ?? '', 'pending') !== false;
                }));
            ?>
            <div class="row summary-panel g-4">
                <div class="col-md-4">
                    <div class="summary-card">
                        <div class="summary-title">Total Orders</div>
                        <div class="summary-value"><?= htmlspecialchars($orderCount); ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <div class="summary-title">Total Spent</div>
                        <div class="summary-value">Rs <?= number_format($totalSpent, 2); ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card">
                        <div class="summary-title">Pending Orders</div>
                        <div class="summary-value"><?= htmlspecialchars($pendingCount); ?></div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <?php foreach ($orders as $order): ?>
                    <?php
                        $status = strtolower(trim($order['status'] ?? 'pending'));
                        $statusClass = 'status-pending';
                        if (strpos($status, 'deliver') !== false) {
                            $statusClass = 'status-delivered';
                        } elseif (strpos($status, 'cancel') !== false) {
                            $statusClass = 'status-cancelled';
                        } elseif (strpos($status, 'processing') !== false) {
                            $statusClass = 'status-processing';
                        }
                    ?>
                    <div class="col-lg-6">
                        <div class="order-card">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                <div>
                                    <div class="order-label">Order #<?= htmlspecialchars($order['id']); ?></div>
                                    <div class="order-value">Rs <?= number_format($order['total'], 2); ?></div>
                                </div>
                                <span class="order-pill <?= $statusClass; ?>"><?= htmlspecialchars($order['status']); ?></span>
                            </div>
                            <div class="order-meta mb-3 text-white-50">Placed on <?= htmlspecialchars($order['created_at'] ?? 'N/A'); ?></div>
                            <?php if (!empty($order['tracking_id'])): ?>
                                <div class="mb-3" style="color: #0d6efd;">Tracking ID: <strong style="color: #a5d8ff;"><?= htmlspecialchars($order['tracking_id']); ?></strong></div>
                            <?php endif; ?>
                            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                                <div>
                                    <div class="text-muted">Customer</div>
                                    <div class="fw-semibold text-white"><?= htmlspecialchars($order['customer_name']); ?></div>
                                </div>
                                <a href="<?= BASE_URL ?>/index.php?page=customer_order_detail&id=<?= htmlspecialchars($order['id']); ?>" class="btn btn-view-order">View details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include('footer.php'); ?>
