<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report - <?= ucfirst($period) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff; padding: 50px; }
        .report-header { border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .total-box { background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 30px; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="container">
        <div class="report-header d-flex justify-content-between align-items-center">
            <div>
                <h1>Sales Report</h1>
                <p class="text-muted mb-0">Period: <?= ucfirst($period) ?></p>
                <p class="text-muted">Generated on: <?= date('Y-m-d H:i') ?></p>
            </div>
            <div class="text-end">
                <h3>Stitch Smart</h3>
                <p>Official Sales Documentation</p>
            </div>
        </div>

        <div class="total-box">
            <div class="row text-center">
                <div class="col-6">
                    <h4>Total Orders</h4>
                    <h2 class="text-success"><?= count($orders) ?></h2>
                </div>
                <div class="col-6">
                    <h4>Total Revenue</h4>
                    <h2 class="text-primary">Rs <?= number_format(array_sum(array_column($orders, 'total')), 2) ?></h2>
                </div>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order): ?>
                <tr>
                    <td>#<?= $order['id'] ?></td>
                    <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                    <td><?= $order['status'] ?></td>
                    <td class="text-end">Rs <?= number_format($order['total'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($orders)): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">No orders found for this period.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="mt-5 text-center text-muted small">
            <p>This is a computer-generated report and does not require a signature.</p>
        </div>

        <div class="no-print text-center mt-5">
            <button onclick="window.print()" class="btn btn-primary">Print / Save as PDF</button>
            <button onclick="window.close()" class="btn btn-secondary">Close</button>
        </div>
    </div>

</body>
</html>
