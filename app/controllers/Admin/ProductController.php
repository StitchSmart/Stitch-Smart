<?php

require_once BASE_PATH.'/config/database.php';
require_once BASE_PATH.'/app/models/Product.php';
require_once BASE_PATH.'/app/models/ad_category.php';
require_once BASE_PATH.'/app/services/ApiService.php';

class ProductController{

    private $productModel;
      private $categoryModel; // make sure this is declared
  

    public function __construct(){

        $database = new Database();
        $db = $database->connect();

        $this->productModel = new Product($db);
         $this->categoryModel = new Category($db); // initialize it
    }

   public function index(){

    $products = $this->productModel->getAllProducts();

    $data['title'] = 'Products';
    $data['theme'] = $_SESSION['theme'] ?? 'theme-luxury';
    $data['view'] = 'admin/admin_products.php';
    $data['products'] = $products;

    extract($data); 

    require BASE_PATH.'/app/views/admin/layout.php';
}
public function feature()
{
    if (!isset($_GET['id'])) {
        header("Location: " . BASE_URL . "/index.php?page=admin_products");
        exit;
    }

    $id = (int) $_GET['id'];

    $product = $this->productModel->getProductById($id);

    if (!$product) {
        die("Product not found");
    }

    // toggle featured
    $newStatus = ($product['featured'] == 1) ? 0 : 1;

    $this->productModel->toggleFeatured($id, $newStatus);

    // optional message system
    $_SESSION['flash'] = $newStatus ? "Product marked as Featured ⭐" : "Product removed from Featured ❌";

    header("Location: " . BASE_URL . "/index.php?page=admin_products");
    exit;
}

    public function saleIndex()
    {
        $products = $this->productModel->getAllProducts();

        $data['title'] = 'Sale Products';
        $data['theme'] = $_SESSION['theme'] ?? 'theme-luxury';
        $data['view'] = 'admin/admin_sale_products.php';
        $data['products'] = $products;

        extract($data);
        require BASE_PATH . '/app/views/admin/layout.php';
    }

    public function toggleSale()
    {
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "/index.php?page=admin_sale_products");
            exit;
        }

        $id = (int) $_GET['id'];
        $product = $this->productModel->getProductById($id);

        if (!$product) {
            die("Product not found");
        }

        $newStatus = ($product['featured'] == 1) ? 0 : 1;
        $this->productModel->toggleFeatured($id, $newStatus);
        $_SESSION['flash'] = $newStatus ? "Product added to Sale ✅" : "Product removed from Sale ✅";

        header("Location: " . BASE_URL . "/index.php?page=admin_sale_products");
        exit;
    }

    public function store() {
        $details = trim($_POST['details'] ?? '');
        $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
        $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : 0;
        
        // Handle Sizes and Quantities
        $qty_xs = (int)($_POST['qty_xs'] ?? 0);
        $qty_s = (int)($_POST['qty_s'] ?? 0);
        $qty_l = (int)($_POST['qty_l'] ?? 0);
        $qty_xl = (int)($_POST['qty_xl'] ?? 0);
        
        $total_qty = $qty_xs + $qty_s + $qty_l + $qty_xl;
        $sizes_str = "XS:{$qty_xs}, S:{$qty_s}, L:{$qty_l}, XL:{$qty_xl}";
        
        // Handle Design Yourself toggle
        $designing = isset($_POST['Designing']) ? 'Yes' : 'No';

        if (empty($name)) {
            $errors['pname'] = "Fill the Product Name field.";
        }
        if (empty($art)) {
            $errors['art'] = "Fill the Article Number field.";
        } elseif (!preg_match('/^[a-zA-Z0-9-]+$/', $art)) {
            $errors['art'] = "Article Number must be alphanumeric.";
        } elseif (!$this->productModel->isArticleNumberUnique($art)) {
            $errors['art'] = "Article Number already exists.";
        }
        
        if (empty($desc)) {
            $errors['pdesc'] = "Fill the Description field.";
        }
        if (empty($details)) {
            $errors['details'] = "Fill the Details field.";
        }
        if ($price === false || $price <= 0) {
            $errors['price'] = "Price must be a positive number.";
        }
        if ($parent_id <= 0) {
            $errors['parent_id'] = "Select a category.";
        }

        $hasImageUpload = false;
        if (isset($_FILES['bimage']['name'])) {
            $fileNames = is_array($_FILES['bimage']['name']) ? $_FILES['bimage']['name'] : [$_FILES['bimage']['name']];
            $hasImageUpload = count(array_filter(array_map('trim', $fileNames))) > 0;
        }

        if ($hasImageUpload) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
            $uploadDir = BASE_PATH . '/public/pictures/products/';
            $files = $_FILES['bimage'];

            $names = is_array($files['name']) ? $files['name'] : [$files['name']];
            $types = is_array($files['type']) ? $files['type'] : [$files['type']];
            $tmpNames = is_array($files['tmp_name']) ? $files['tmp_name'] : [$files['tmp_name']];
            $errorsArr = is_array($files['error']) ? $files['error'] : [$files['error']];
            $sizes = is_array($files['size']) ? $files['size'] : [$files['size']];

            $validUploads = [];
            foreach ($names as $index => $fileName) {
                if (empty($fileName)) {
                    continue;
                }

                $fileType = $types[$index] ?? '';
                $fileSize = $sizes[$index] ?? 0;
                $fileError = $errorsArr[$index] ?? UPLOAD_ERR_NO_FILE;
                $tmpName = $tmpNames[$index] ?? '';

                if (!in_array($fileType, $allowed_types)) {
                    $errors['bimage'] = "Invalid image type for {$fileName}. Only JPG, JPEG, and PNG are allowed.";
                    continue;
                }
                if ($fileSize > 10 * 1024 * 1024) {
                    $errors['bimage'] = "Image size for {$fileName} must be less than 10MB.";
                    continue;
                }
                if ($fileError !== UPLOAD_ERR_OK) {
                    $errors['bimage'] = "Error uploading {$fileName}.";
                    continue;
                }

                $validUploads[] = [
                    'name' => $fileName,
                    'tmp_name' => $tmpName
                ];
            }

            if (count($validUploads) < 3) {
                $errors['bimage'] = "Please upload at least 3 product images.";
            }

            if (empty($errors)) {
                foreach ($validUploads as $upload) {
                    $imageName = time() . '_' . uniqid() . '_' . basename($upload['name']);
                    $relativePath = 'pictures/products/' . $imageName;
                    if (move_uploaded_file($upload['tmp_name'], $uploadDir . $imageName)) {
                        $imagePaths[] = $relativePath;
                    } else {
                        $errors['bimage'] = "Failed to save image {$upload['name']}";
                    }
                }
            }

            if (empty($errors)) {
                $image = implode(',', $imagePaths);
            }
        } else {
            $errors['bimage'] = "Please upload at least 3 product images.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header("Location: " . BASE_URL . "index.php?page=add_product");
            exit;
        }

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        
        $data = [
            'article_number' => $art,
            'name' => $name,
            'description' => $desc,
            'details' => $_POST['details'],
            'image_url' => $image,
            'size' => $sizes_str,
            'Fabric_Type' => '', // Removed from form
            'Designing' => $designing,
            'price' => $price,
            'parent_cat' => $parent_id,
            'meta_title' => $_POST['meta_title'],
            'meta_description' => $_POST['meta_desc'],
            'meta_keywords' => $_POST['meta_keywords'],
            'quantity' => $total_qty,
            'slug' => $slug
        ];

        $this->productModel->createProduct($data);
        
        $productData = $this->productModel->getProductBySlug($slug);
        if ($productData) {
            $data['id'] = $productData['id'];
            ApiService::syncProduct($data);
        }

        header("Location: " . BASE_URL . "index.php?page=admin_products");
        exit;
    }

// show edit form
    public function edit($id){
        $product = $this->productModel->getProductById($id);
        if(!$product){
            die("Product not found");
        }
$top_categories = $this->categoryModel->getMainCategories();

        $data['title'] = 'Edit Product';
$data['theme'] = $_SESSION['theme'] ?? 'theme-luxury';
$data['view'] = 'admin/edit_product.php';
$data['product'] = $product;
$data['top_categories'] = $top_categories;
extract($data); 
require BASE_PATH.'/app/views/admin/layout.php';
    }

    // update product
    public function update(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $id = (int)$_POST['id'];
            $errors = [];
            
            // Basic Info
            $name = htmlspecialchars(trim($_POST['pname']));
            $art = htmlspecialchars(trim($_POST['art']));
            $desc = htmlspecialchars(trim($_POST['pdesc']));
            $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
            $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : 0;
            
            // Sizes & Qty
            $qty_xs = (int)($_POST['qty_xs'] ?? 0);
            $qty_s = (int)($_POST['qty_s'] ?? 0);
            $qty_l = (int)($_POST['qty_l'] ?? 0);
            $qty_xl = (int)($_POST['qty_xl'] ?? 0);
            $total_qty = $qty_xs + $qty_s + $qty_l + $qty_xl;
            $sizes_str = "XS:{$qty_xs}, S:{$qty_s}, L:{$qty_l}, XL:{$qty_xl}";

            $product = $this->productModel->getProductById($id);
            if(!$product) die("Product not found");

            // Validation
            if (empty($name)) $errors[] = "Product Name is required.";
            if (empty($art)) $errors[] = "Article Number is required.";
            if ($price === false || $price <= 0) $errors[] = "Price must be a positive number.";
            if ($parent_id <= 0) $errors[] = "Category is required.";

            // Unique Article Number check (only if changed)
            if ($art !== $product['article_number']) {
                if (!$this->productModel->isArticleNumberUnique($art)) {
                    $errors[] = "Article Number already exists.";
                }
            }

            $image = $product['image_url'];
            $hasImageUpload = false;
            if (isset($_FILES['bimage']['name'])) {
                $fileNames = is_array($_FILES['bimage']['name']) ? $_FILES['bimage']['name'] : [$_FILES['bimage']['name']];
                $hasImageUpload = count(array_filter(array_map('trim', $fileNames))) > 0;
            }

            // handle new image upload
            if ($hasImageUpload) {
                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                $uploadDir = BASE_PATH . '/public/pictures/products/';
                $files = $_FILES['bimage'];

                $names = is_array($files['name']) ? $files['name'] : [$files['name']];
                $types = is_array($files['type']) ? $files['type'] : [$files['type']];
                $tmpNames = is_array($files['tmp_name']) ? $files['tmp_name'] : [$files['tmp_name']];
                $errorsArr = is_array($files['error']) ? $files['error'] : [$files['error']];
                $sizes = is_array($files['size']) ? $files['size'] : [$files['size']];

                $validUploads = [];
                foreach ($names as $index => $fileName) {
                    if (empty($fileName)) {
                        continue;
                    }

                    $fileType = $types[$index] ?? '';
                    $fileSize = $sizes[$index] ?? 0;
                    $fileError = $errorsArr[$index] ?? UPLOAD_ERR_NO_FILE;
                    $tmpName = $tmpNames[$index] ?? '';

                    if (!in_array($fileType, $allowed_types)) {
                        $errors[] = "Invalid image type for {$fileName}. JPG, PNG, and WEBP allowed.";
                        continue;
                    }
                    if ($fileSize > 10 * 1024 * 1024) {
                        $errors[] = "Image size for {$fileName} must be less than 10MB.";
                        continue;
                    }
                    if ($fileError !== UPLOAD_ERR_OK) {
                        $errors[] = "Error uploading {$fileName}.";
                        continue;
                    }

                    $validUploads[] = [
                        'name' => $fileName,
                        'tmp_name' => $tmpName
                    ];
                }

                if (!empty($validUploads) && count($validUploads) < 3) {
                    $errors[] = "Please upload at least 3 product images when replacing the gallery.";
                }

                if (empty($errors) && !empty($validUploads)) {
                    $imagePaths = [];
                    foreach ($validUploads as $upload) {
                        $imageName = time() . '_' . uniqid() . '_' . basename($upload['name']);
                        $relativePath = 'pictures/products/' . $imageName;
                        if (move_uploaded_file($upload['tmp_name'], $uploadDir . $imageName)) {
                            $imagePaths[] = $relativePath;
                        } else {
                            $errors[] = "Failed to save image {$upload['name']}.";
                        }
                    }

                    if (empty($errors)) {
                        $oldImages = array_filter(array_map('trim', explode(',', $image)));
                        foreach ($oldImages as $oldImage) {
                            if ($oldImage && file_exists(BASE_PATH . '/public/' . $oldImage)) {
                                @unlink(BASE_PATH . '/public/' . $oldImage);
                            }
                        }
                        $image = implode(',', $imagePaths);
                    }
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: " . BASE_URL . "index.php?page=edit_product&id=" . $id);
                exit;
            }

            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

            $data = [
                'id' => $id,
                'article_number' => $art,
                'name' => $name,
                'description' => $desc,
                'details' => $_POST['details'],
                'image_url' => $image,
                'size' => $sizes_str,
                'Fabric_Type' => $_POST['Fabric_Type'] ?? '',
                'Designing' => $_POST['Designing'] ?? 'No',
                'price' => $price,
                'parent_cat' => $parent_id,
                'meta_title' => $_POST['meta_title'],
                'meta_description' => $_POST['meta_desc'],
                'meta_keywords' => $_POST['meta_keywords'],
                'quantity' => $total_qty,
                'slug' => $slug,
                'color_id' => $_POST['color_id'] ?? 0
            ];

            $this->productModel->updateProduct($data);
            ApiService::syncProduct();

            $_SESSION['success'] = "Product updated successfully!";
            header("Location: ".BASE_URL."/index.php?page=admin_products");
            exit;
        }
    }
// JSON QUERY
    public function exportJSON(){

    $products = $this->productModel->getAllProductsForAI();

    header('Content-Type: application/json');
    echo json_encode($products, JSON_PRETTY_PRINT);

    exit;
}

    // delete product
    public function delete(){

        if(isset($_GET['id'])){

            $id=$_GET['id'];

            $this->productModel->deleteProduct($id);

            ApiService::syncProduct();

            header("Location: ".BASE_URL."/index.php?page=admin_products");
        }
    }

}
