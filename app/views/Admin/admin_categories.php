<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-white mb-0">Categories Portal</h2>
    <a href="<?= BASE_URL ?>/index.php?page=add_category" class="btn btn-primary px-4 rounded-pill">
        + Add New Category
    </a>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="accordion luxury-accordion" id="categoryAccordion">
            <?php foreach($categories as $index => $cat): ?>
                <div class="accordion-item mb-3 border-0 bg-transparent">
                    <h2 class="accordion-header position-relative" id="heading-<?= $cat['c_id'] ?>">
                        <button class="accordion-button collapsed rounded-4 py-3 pe-5" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapse-<?= $cat['c_id'] ?>" 
                                aria-expanded="false" 
                                aria-controls="collapse-<?= $cat['c_id'] ?>"
                                style="background: rgba(193, 154, 78, 0.05); border: 1px solid rgba(193, 154, 78, 0.2); color: #fff;">
                            
                            <div class="d-flex align-items-center w-100 pe-5">
                                <div class="cid-badge me-3 p-2 rounded-circle text-center" 
                                     style="width: 40px; height: 40px; background: var(--accent-bronze); color: #000; font-weight: 800; font-size: 0.8rem; line-height: 24px;">
                                    <?= $cat['c_id'] ?>
                                </div>
                                <img src="<?= BASE_URL ?>/<?= !empty($cat['c_image']) ? htmlspecialchars($cat['c_image']) : 'pictures/home/cat1.webp' ?>" 
                                     class="rounded me-3" 
                                     style="width: 50px; height: 50px; object-fit: cover; border: 1px solid var(--accent-bronze);">
                                
                                <div class="flex-grow-1">
                                    <span class="fs-5 fw-bold text-uppercase mb-0 d-block" style="letter-spacing: 1.5px; color: var(--accent-bronze);">
                                        <?= htmlspecialchars($cat['c_name']) ?>
                                    </span>
                                    <small class="text-muted"><?= count($cat['subs'] ?? []) ?> Subcategories</small>
                                </div>
                            </div>
                        </button>
                        
                        <!-- Actions outside button to prevent HTML violation & misclicks -->
                        <div class="position-absolute top-50 translate-middle-y z-3" style="right: 90px;">
                            <a href="<?= BASE_URL ?>/index.php?page=edit_category&id=<?= $cat['c_id'] ?>" 
                               class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2" style="position: relative; z-index: 10;">Edit</a>
                            <a href="<?= BASE_URL ?>/index.php?page=delete_category&id=<?= $cat['c_id'] ?>" 
                               class="btn btn-sm btn-outline-danger rounded-pill px-3"
                               onclick="return confirm('Delete this main category?')" style="position: relative; z-index: 10;">Delete</a>
                        </div>
                    </h2>
                    
                    <div id="collapse-<?= $cat['c_id'] ?>" 
                         class="accordion-collapse collapse" 
                         aria-labelledby="heading-<?= $cat['c_id'] ?>" 
                         data-bs-parent="#categoryAccordion">
                        
                        <div class="accordion-body p-0 mt-2 rounded-4 overflow-hidden" style="background: rgba(0,0,0,0.2); border: 1px solid rgba(193, 154, 78, 0.1);">
                            <table class="table table-hover table-dark mb-0 align-middle">
                                <thead style="background: rgba(193, 154, 78, 0.05);">
                                    <tr>
                                        <th class="ps-4 py-3 text-muted small" style="width: 100px;">CID</th>
                                        <th class="py-3 text-muted small">Subcategory Name</th>
                                        <th class="py-3 text-muted small text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($cat['subs'])): ?>
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted">No subcategories found.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach($cat['subs'] as $sub): ?>
                                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                                <td class="ps-4">
                                                    <small class="text-muted">#<?= $sub['c_id'] ?></small>
                                                </td>
                                                <td>
                                                    <span class="text-white-50"><?= htmlspecialchars($sub['c_name']) ?></span>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <a href="<?= BASE_URL ?>/index.php?page=edit_category&id=<?= $sub['c_id'] ?>" 
                                                       class="btn btn-sm btn-link text-primary text-decoration-none px-3">Edit</a>
                                                    <a href="<?= BASE_URL ?>/index.php?page=delete_category&id=<?= $sub['c_id'] ?>" 
                                                       class="btn btn-sm btn-link text-danger text-decoration-none px-3"
                                                       onclick="return confirm('Delete this subcategory?')">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
/* Accordion Luxury Customizations */
.accordion-button::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffd700'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
    background-size: 1.5rem !important;
    width: 1.5rem !important;
    height: 1.5rem !important;
    transition: transform 0.3s ease-in-out;
}

.accordion-button:not(.collapsed)::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffd700'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
    transform: rotate(-180deg);
}

.accordion-button:not(.collapsed) {
    background: rgba(193, 154, 78, 0.15) !important;
    box-shadow: inset 0 -1px 0 rgba(193, 154, 78, 0.2);
    color: var(--accent-bronze) !important;
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(193, 154, 78, 0.1);
}

.main-category-row:hover {
    background: rgba(193, 154, 78, 0.1) !important;
}

.accordion-item {
    transition: transform 0.2s ease;
}

.accordion-item:hover {
    transform: translateX(5px);
}
</style>
