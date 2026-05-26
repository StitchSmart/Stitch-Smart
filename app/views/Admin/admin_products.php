


<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-white mb-0">Products Inventory</h2>
    <a href="<?= BASE_URL ?>/index.php?page=add_product" class="btn btn-primary px-4 rounded-pill">
        + Add New Product
    </a>
</div>

<div class="row mt-5">

<div class="table-responsive">

<table class="table text-center">

<thead>

<tr>
<th>PID</th>
<th>Article No.</th>
<th>Name</th>
<th>Product Image</th>
<th>QTY</th>
<th>Featured</th>
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
<td>

<a href="<?= BASE_URL ?>/index.php?page=feature_product&id=<?= $prod['id'] ?>" class="btn btn-sm <?= $prod['featured'] == 1 ? 'btn-warning' : 'btn-info' ?> rounded-pill">
    <?= $prod['featured'] == 1 ? '🌟 Unfeature' : '⭐ Make Featured' ?>
</a>

</td>

<td>

<a href="<?= BASE_URL ?>/index.php?page=edit_product&id=<?= $prod['id'] ?>" class="btn btn-primary btn-sm">
Edit
</a>

<a href="<?= BASE_URL ?>/index.php?page=delete_product&id=<?= $prod['id'] ?>" class="btn btn-danger btn-sm">
Delete
</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>



</div>

