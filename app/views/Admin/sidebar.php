<?php
$currentPage = $_GET['page'] ?? 'admin';
?>
<div class="col-xl-3 col-sm-4">
    <div class="sidebar rounded-top h-100">
        <table class="table table-hover mb-0">
            <thead class="text-center">
                <tr>
                    <th>
                        <h5 class="mb-0 py-2">Content</h5>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <a href="<?php echo BASE_URL ?>index.php?page=homepage" class="nav-link <?= ($currentPage === 'homepage') ? 'active' : '' ?>">
                            <i class="bi bi-house-door me-2"></i> Home
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>
                        <a href="<?php echo BASE_URL ?>index.php?page=admin" class="nav-link <?= ($currentPage === 'admin') ? 'active' : '' ?>">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>
                        <a href="<?php echo BASE_URL ?>index.php?page=admin_products" class="nav-link <?= in_array($currentPage, ['admin_products', 'add_product', 'edit_product']) ? 'active' : '' ?>">
                            <i class="bi bi-box-seam me-2"></i> Manage Products
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="<?php echo BASE_URL ?>index.php?page=admin_sale_products" class="nav-link <?= ($currentPage === 'admin_sale_products') ? 'active' : '' ?>">
                            <i class="bi bi-tag me-2"></i> Sale Products
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>
                        <a href="<?php echo BASE_URL ?>index.php?page=admin_categories" class="nav-link <?= in_array($currentPage, ['admin_categories', 'add_category', 'edit_category']) ? 'active' : '' ?>">
                            <i class="bi bi-tags me-2"></i> Manage Categories
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>
                        <a href="<?php echo BASE_URL ?>index.php?page=pages" class="nav-link <?= in_array($currentPage, ['pages', 'add_page', 'edit_page']) ? 'active' : '' ?>">
                            <i class="bi bi-file-earmark-text me-2"></i> Manage Pages
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="<?php echo BASE_URL ?>index.php?page=sales_report" class="nav-link <?= ($currentPage === 'sales_report') ? 'active' : '' ?>">
                            <i class="bi bi-graph-up me-2"></i> Sales Report
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="<?php echo BASE_URL ?>index.php?page=return_report" class="nav-link <?= ($currentPage === 'return_report') ? 'active' : '' ?>">
                            <i class="bi bi-arrow-repeat me-2"></i> Returns Report
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="<?php echo BASE_URL ?>index.php?page=return_trash" class="nav-link <?= ($currentPage === 'return_trash') ? 'active' : '' ?>">
                            <i class="bi bi-trash me-2"></i> Return Trash
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="<?php echo BASE_URL ?>index.php?page=manage_orders" class="nav-link <?= ($currentPage === 'manage_orders') ? 'active' : '' ?>">
                            <i class="bi bi-cart-check me-2"></i> View Orders
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="<?php echo BASE_URL ?>logout.php" class="nav-link logout-link">
                            <i class="bi bi-box-arrow-left me-2"></i> Logout
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
