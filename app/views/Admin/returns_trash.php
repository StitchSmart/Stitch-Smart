<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-12">
            <h2>Return Trash Report</h2>
            <p>All returned items marked as damaged and sent to trash.</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Damage Note</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($returns)): ?>
                    <tr><td colspan="7" class="text-center">No trashed returns yet.</td></tr>
                <?php else: ?>
                    <?php foreach($returns as $return): ?>
                        <tr>
                            <td><?= (int)$return['id'] ?></td>
                            <td>#<?= (int)$return['order_id'] ?> (<?= htmlspecialchars($return['order_status'] ?? '') ?>)</td>
                            <td><?= htmlspecialchars($return['customer_name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($return['product_name'] ?? 'Unknown') ?></td>
                            <td><?= (int)$return['quantity'] ?></td>
                            <td><?= nl2br(htmlspecialchars($return['damage_note'])) ?></td>
                            <td><?= htmlspecialchars($return['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
