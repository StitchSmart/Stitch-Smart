

<div class="table-responsive mt-3">

<table class="table text-center">

<thead>
<tr>
    <th>Order ID</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Total</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php foreach($orders as $order): ?>

<tr>
    <td><?= $order['id'] ?></td>
    <td><?= htmlspecialchars($order['customer_name']) ?></td>
    <td><?= htmlspecialchars($order['phone']) ?></td>
    <td><?= $order['total'] ?></td>
    <td><?= $order['status'] ?></td>

    <td>
        <?php if($order['status'] !== 'Delivered'): ?>
            <?php if(empty($order['tracking_id'])): ?>
                <button type="button" class="btn btn-warning btn-sm toggle-dispatch" data-order-id="<?= $order['id'] ?>">
                    Dispatch
                </button>
            <?php else: ?>
                <span class="badge bg-info text-dark mb-1">Tracking: <?= htmlspecialchars($order['tracking_id']); ?></span>
                <button type="button" class="btn btn-warning btn-sm toggle-dispatch" data-order-id="<?= $order['id'] ?>">
                    Update
                </button>
            <?php endif; ?>
            <div class="dispatch-form d-none mt-2" id="dispatch-form-<?= $order['id'] ?>">
                <form action="<?= BASE_URL ?>/index.php?page=save_tracking" method="post" class="d-flex gap-2">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <input type="text" name="tracking_id" class="form-control form-control-sm" placeholder="Enter tracking ID" value="<?= htmlspecialchars($order['tracking_id'] ?? '') ?>" required>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </form>
            </div>
        <?php endif; ?>

        <?php if(stripos($order['status'], 'delivered') !== false): ?>
        <a href="<?= BASE_URL ?>/index.php?page=return_form&order_id=<?= $order['id'] ?>"
           class="btn btn-info btn-sm mt-2">
           Process Return
        </a>
        <?php endif; ?>
        <?php if($order['status'] !== 'Delivered'): ?>
        <a href="<?= BASE_URL ?>/index.php?page=mark_delivered&id=<?= $order['id'] ?>"
           class="btn btn-success btn-sm mt-2">
           Delivered
        </a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/index.php?page=delete_order&id=<?= $order['id'] ?>"
           class="btn btn-danger btn-sm mt-2"
           onclick="return confirm('Delete this order?')">
           Delete
        </a>
    </td>
</tr>

<?php endforeach; ?>

</tbody>
</table>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-dispatch').forEach(function(button) {
            button.addEventListener('click', function() {
                var orderId = this.getAttribute('data-order-id');
                var form = document.getElementById('dispatch-form-' + orderId);
                if (form) {
                    form.classList.toggle('d-none');
                }
            });
        });
    });
</script>
