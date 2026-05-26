<div class="container mt-5 mb-5">
    <div class="card border-0 rounded-4">

        <!-- Header -->
        <div class="card-header rounded-top-4 py-3">
            <h4 class="mb-0 text-center">Edit Product</h4>
        </div>

        <div class="card-body px-4 py-4">
            <form action="<?= BASE_URL ?>/index.php?page=update_product" method="post" enctype="multipart/form-data">
                
                <input type="hidden" name="id" value="<?= $product['id'] ?>">

                <!-- Product Info -->
                <h5 class="text-muted mb-3">Product Information</h5>
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="pname" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Article Number</label>
                        <input type="text" name="art" class="form-control" value="<?= htmlspecialchars($product['article_number']) ?>">
                    </div>

                    <div class="col-6">
                        <label class="form-label">Description</label>
                        <textarea name="pdesc" class="form-control" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Details</label>
                        <textarea name="details" class="form-control" rows="3"><?= htmlspecialchars($product['details']) ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Product Images</label>
                        <input type="file" name="bimage[]" class="form-control" accept="image/*" multiple>

                        <?php if(!empty($product['image_url'])): ?>
                            <div class="mt-2">
                                <small class="text-muted d-block mb-1">Current Images</small>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach(array_filter(array_map('trim', explode(',', $product['image_url']))) as $imgPath): ?>
                                        <?php if(!empty($imgPath)): ?>
                                            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($imgPath) ?>" 
                                                 class="img-thumbnail rounded" 
                                                 style="max-width:120px;">
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

                <hr class="my-4">

                <!-- Inventory -->
                <h5 class="text-muted mb-3">Inventory & Pricing</h5>
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Size</label>
                        <input type="text" name="size" class="form-control" value="<?= htmlspecialchars($product['size']) ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" value="<?= htmlspecialchars($product['price']) ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" value="<?= htmlspecialchars($product['quantity']) ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Category</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- Select Category --</option>

                            <?php foreach($top_categories as $top_cat): ?>
                                <?php $selected = ($top_cat['c_id'] == $product['parent_cat']) ? "selected" : ""; ?>
                                <option value="<?= $top_cat['c_id'] ?>" <?= $selected ?>>
                                    <?= $top_cat['c_name'] ?>
                                </option>

                                <?php
                                $subcategories = $this->categoryModel->getSubCategories($top_cat['c_id']);
                                foreach($subcategories as $sub):
                                    $selected = ($sub['c_id'] == $product['parent_cat']) ? "selected" : "";
                                ?>
                                    <option value="<?= $sub['c_id'] ?>" <?= $selected ?>>
                                        &nbsp;&nbsp;- <?= $sub['c_name'] ?>
                                    </option>

                                    <?php
                                    $sub_sub = $this->categoryModel->getSubCategories($sub['c_id']);
                                    foreach($sub_sub as $subsub):
                                        $selected = ($subsub['c_id'] == $product['parent_cat']) ? "selected" : "";
                                    ?>
                                        <option value="<?= $subsub['c_id'] ?>" <?= $selected ?>>
                                            &nbsp;&nbsp;&nbsp;&nbsp;-- <?= $subsub['c_name'] ?>
                                        </option>
                                    <?php endforeach; ?>

                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <hr class="my-4">

                <!-- SEO -->
                <h5 class="text-muted mb-3">SEO Settings</h5>
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($product['meta_title']) ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control" value="<?= htmlspecialchars($product['meta_keywords']) ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_desc" class="form-control" rows="3"><?= htmlspecialchars($product['meta_description']) ?></textarea>
                    </div>

                </div>

                <!-- Submit -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-dark px-4 py-2 rounded-3">
                        Update Product
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>