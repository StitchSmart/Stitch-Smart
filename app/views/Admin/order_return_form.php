<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2>Return Processing for Order #<?= $order['id'] ?></h2>
            <p>
                Customer: <?= htmlspecialchars($order['customer_name']) ?><br>
                Phone: <?= htmlspecialchars($order['phone']) ?><br>
                Status: <?= htmlspecialchars($order['status']) ?>
            </p>
        </div>
    </div>

    <form action="<?= BASE_URL ?>/index.php?page=process_return" method="post">
        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">

        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Ordered Qty</th>
                        <th>Return Qty</th>
                        <th>Damage</th>
                        <th>Damage Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($items)): ?>
                        <tr><td colspan="5" class="text-center">No order items found.</td></tr>
                    <?php else: ?>
                        <?php foreach($items as $index => $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['product_name'] ?? 'Unknown') ?></td>
                                <td><?= (int)$item['quantity'] ?></td>
                                <td>
                                    <input type="hidden" name="return_item_id[]" value="<?= (int)$item['id'] ?>">
                                    <input type="number" name="return_quantity[]" class="form-control" min="0" max="<?= (int)$item['quantity'] ?>" value="0">
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="damage[<?= $index ?>]" value="1">
                                </td>
                                <td>
                                    <input type="text" name="damage_note[]" class="form-control" placeholder="Damage details (optional)">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Submit Return</button>
            <a href="<?= BASE_URL ?>/index.php?page=manage_orders" class="btn btn-secondary">Back to Orders</a>
        </div>
    </form>

    <?php if(!empty($returns)): ?>
        <div class="mt-5">
            <h4>Return History</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Returned Qty</th>
                            <th>Status</th>
                            <th>Damage Note</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($returns as $return): ?>
                            <tr>
                                <td><?= (int)$return['id'] ?></td>
                                <td><?= htmlspecialchars($return['product_name'] ?? 'Unknown') ?></td>
                                <td><?= (int)$return['quantity'] ?></td>
                                <td><?= htmlspecialchars($return['status']) ?></td>
                                <td><?= nl2br(htmlspecialchars($return['damage_note'])) ?></td>
                                <td><?= htmlspecialchars($return['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
