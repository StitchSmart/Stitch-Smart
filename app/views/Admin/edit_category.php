


<div class="d-flex justify-content-center align-items-center mt-5">


    <form class="w-75 p-4 border rounded" method="POST" enctype="multipart/form-data" action="<?= BASE_URL ?>/index.php?page=update_category">
    <div class="card-header py-3">
        <h3 class="text-center mb-0">Edit Category</h3>
    </div>
    <input type="hidden" name="id" value="<?= $category['c_id'] ?>">
        <input type="hidden" name="old_banner" value="<?= $category['c_img2'] ?>">
        <input type="hidden" name="old_image" value="<?= $category['c_image'] ?>">

        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="cat_name" class="form-control" value="<?= htmlspecialchars($category['c_name']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Category Description</label>
            <textarea name="cat_desc" class="form-control"><?= htmlspecialchars($category['c_description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Parent Category (Optional)</label>
            <select name="parent_id" class="form-control">
                <option value="0">-- None (Top Level) --</option>
                <?php foreach($parents as $parent): ?>
                    <?php if($parent['c_id'] != $category['c_id']): // Prevent circular reference ?>
                        <option value="<?= $parent['c_id'] ?>" <?= ($parent['c_id'] == $category['parent_id']) ? 'selected' : '' ?>>
                            <?= str_repeat('&nbsp;&nbsp;', $parent['level']) ?>
                            <?= ($parent['level'] > 0 ? '↳ ' : '') ?>
                            <?= htmlspecialchars($parent['c_name']) ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>



        <div class="mb-3">
            <label>Category Image</label><br>
            <?php if($category['c_image']): ?>
                <img src="<?= BASE_URL ?>/<?= $category['c_image'] ?>" width="100"><br>
            <?php endif; ?>
            <input type="file" name="cimage" class="form-control">
        </div>
<h4 class="text-center bg-success text-white p-2">
Add Meta Info
</h4>
        <h4>Meta Info</h4>
        <div class="mb-3">
            <label>Meta Title</label>
            <textarea name="meta_title" class="form-control"><?= htmlspecialchars($category['meta_title']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Meta Description</label>
            <textarea name="meta_desc" class="form-control"><?= htmlspecialchars($category['meta_description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Meta Keywords</label>
            <textarea name="meta_keywords" class="form-control"><?= htmlspecialchars($category['meta_keywords']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Update Category</button>
    </form>
</div>

