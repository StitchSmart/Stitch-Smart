<div class="container mt-5">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header rounded-top-4 py-3">
            <h4 class="mb-0 text-center">Sales Report Generator</h4>
        </div>
        <div class="card-body p-5">
            <p class="text-center text-muted mb-5">Select a period to generate and download your sales report.</p>
            
            <div class="row g-4 justify-content-center">
                <!-- 7 Days -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-4 report-card">
                        <i class="bi bi-calendar-event text-success mb-3" style="font-size: 3rem;"></i>
                        <h5>Last 7 Days</h5>
                        <p class="small text-muted">Brief overview of recent weekly performance.</p>
                        <a href="<?= BASE_URL ?>index.php?page=download_report&period=7days" target="_blank" class="btn btn-outline-success mt-auto">Download PDF</a>
                    </div>
                </div>

                <!-- 1 Month -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-4 report-card">
                        <i class="bi bi-calendar-month text-primary mb-3" style="font-size: 3rem;"></i>
                        <h5>Last 30 Days</h5>
                        <p class="small text-muted">Monthly sales trends and order breakdown.</p>
                        <a href="<?= BASE_URL ?>index.php?page=download_report&period=1month" target="_blank" class="btn btn-outline-primary mt-auto">Download PDF</a>
                    </div>
                </div>

                <!-- 6 Months -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-4 report-card">
                        <i class="bi bi-calendar-range text-danger mb-3" style="font-size: 3rem;"></i>
                        <h5>Last 6 Months</h5>
                        <p class="small text-muted">Comprehensive half-year sales analysis.</p>
                        <a href="<?= BASE_URL ?>index.php?page=download_report&period=6month" target="_blank" class="btn btn-outline-danger mt-auto">Download PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inactive Customers (No order in last 7 days) -->
    <div class="card border-0 shadow-lg rounded-4 mt-5 mb-5" style="background: rgba(0,0,0,0.05);">
        <div class="card-header bg-warning text-dark rounded-top-4 py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Retention Alert: Inactive Customers</h4>
            <span class="badge bg-dark">No orders in last 7 days</span>
        </div>
        <div class="card-body p-4">
            <p class="text-muted small mb-4">The following customers have placed orders previously but have not made a purchase in the last 7 days. Consider sending a re-engagement email.</p>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Customer Name</th>
                            <th>Contact Info</th>
                            <th>Last Order Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($inactiveCustomers)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted italic">All active customers have ordered recently!</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($inactiveCustomers as $customer): ?>
                                <tr>
                                    <td class="fw-bold"><?= htmlspecialchars($customer['customer_name']) ?></td>
                                    <td><?= htmlspecialchars($customer['phone']) ?></td>
                                    <td><?= date('M d, Y', strtotime($customer['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>index.php?page=send_retention_email&email=<?= urlencode($customer['email']) ?>&name=<?= urlencode($customer['customer_name']) ?>" class="btn btn-sm btn-outline-dark">
                                            <i class="bi bi-envelope-at-fill"></i> Send Mail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.report-card {
    transition: transform 0.3s ease;
    border: 1px solid #eee !important;
}
.report-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
</style>
