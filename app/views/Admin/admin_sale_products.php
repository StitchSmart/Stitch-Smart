<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="text-white mb-0">Sale Products</h2>
        <p class="text-muted mb-0">Mark products as sale items and preview sale pricing automatically.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>/index.php?page=admin_products" class="btn btn-primary px-4 rounded-pill">
            View Products
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="p-4 rounded-4 bg-light bg-opacity-10 border border-secondary border-opacity-10">
            <div class="row align-items-center gy-3">
                <div class="col-md-6">
                    <h5 class="mb-1 text-white">Sale Discount Preview</h5>
                    <p class="text-muted mb-0">Enter a discount percentage and the sale prices update for all sale items below.</p>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-dark text-white">%</span>
                        <input id="sale-discount" type="number" min="0" max="100" step="1" value="20" class="form-control">
                    </div>
                </div>
                <div class="col-md-3 text-md-end">
                    <button id="apply-sale-discount" type="button" class="btn btn-outline-primary rounded-pill px-4">Preview Sale</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="table-responsive">
        <table class="table text-center align-middle">
            <thead>
                <tr>
                    <th>PID</th>
                    <th>Article No.</th>
                    <th>Name</th>
                    <th>Product Image</th>
                    <th>QTY</th>
                    <th>Price</th>
                    <th>Sale Price</th>
                    <th>Sale Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $prod): ?>
                <tr>
                    <td><?= htmlspecialchars($prod['id']) ?></td>
                    <td><?= htmlspecialchars($prod['article_number']) ?></td>
                    <td><?= htmlspecialchars($prod['name']) ?></td>
                    <td>
                        <?php $productImage = strtok($prod['image_url'], ','); ?>
                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars(trim($productImage)) ?>" width="70">
                    </td>
                    <td><?= htmlspecialchars($prod['quantity']) ?></td>
                    <td>$<?= number_format($prod['price'], 2) ?></td>
                    <td class="sale-price-cell">
                        <?php if ($prod['featured'] == 1): ?>
                            $<?= number_format($prod['price'] * 0.8, 2) ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($prod['featured'] == 1): ?>
                            <span class="badge bg-success">On Sale</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Not on Sale</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>/index.php?page=toggle_sale_product&id=<?= $prod['id'] ?>" class="btn btn-sm <?= $prod['featured'] == 1 ? 'btn-warning' : 'btn-info' ?> rounded-pill">
                            <?= $prod['featured'] == 1 ? '✕ Remove Sale' : '⭐ Add Sale' ?>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const discountInput = document.getElementById('sale-discount');
    const applyDiscountButton = document.getElementById('apply-sale-discount');

    const updateSalePreview = () => {
        const discount = Math.min(Math.max(parseFloat(discountInput.value) || 0, 0), 100);
        document.querySelectorAll('tbody tr').forEach(row => {
            const saleStatus = row.querySelector('.badge');
            const salePriceCell = row.querySelector('.sale-price-cell');
            const priceCell = row.children[6];
            const price = parseFloat(priceCell.textContent.replace(/[^0-9.]/g, '')) || 0;
            if (saleStatus && saleStatus.textContent.trim() === 'On Sale') {
                const salePrice = price * (1 - discount / 100);
                salePriceCell.textContent = `$${salePrice.toFixed(2)}`;
            } else {
                salePriceCell.textContent = '-';
            }
        });
    };

    if (discountInput && applyDiscountButton) {
        applyDiscountButton.addEventListener('click', updateSalePreview);
        discountInput.addEventListener('input', updateSalePreview);
        updateSalePreview();
    }
</script>
