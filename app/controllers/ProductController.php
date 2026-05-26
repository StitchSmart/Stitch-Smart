<?php

require_once BASE_PATH.'/config/database.php';
require_once BASE_PATH.'/app/models/settings.php';
require_once BASE_PATH.'/app/models/Product.php';
require_once BASE_PATH.'/app/models/ad_category.php';

require_once BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require_once BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require_once BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ProductController {

    private $productModel;
    private $categoryModel;

    public function __construct(){
        $database = new Database();
        $db = $database->connect();

        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
    }

    
private function loadWebSettings() {
    $settingsModel = new Settings();
    $ws = $settingsModel->getWebSettings();
    return $ws;
}

public function index() {
    $search = $_GET['search'] ?? null;
    $sort = $_GET['sort'] ?? null;
    $category_id = $_GET['category_id'] ?? null;

    // Web settings
    $ws = $this->loadWebSettings();
    $webname = $ws['web_name'] ?? '';
    $webcontact = $ws['web_contact'] ?? '';
    $webmail = $ws['web_mail'] ?? '';
    $facebook = $ws['facebook'] ?? '';
    $instagram = $ws['instagram'] ?? '';
    $pinterest = $ws['pinterest'] ?? '';
    $linkdin = $ws['linkdin'] ?? '';
    $meta_description = $ws['meta_description'] ?? '';
    $global_theme = $ws['theme'] ?? 'theme-luxury';

    $category_name = null; 

    // Fetch products
    if ($search) {
        $products = $this->productModel->searchProducts($search, $sort);
    } elseif ($category_id) {
        $products = $this->productModel->getProductsByCategory($category_id);

        // Fetch category name safely
        $category = $this->categoryModel->getCategoryById($category_id);
        $category_name = $category['c_name'] ?? null;
    } else {
        $products = $this->productModel->getAllProducts();
    }

    // Total products
    $total_products = count($products);

    // Related products: only for single-product pages (don't mix here)
    $related_products = []; // leave empty for products listing

    // Categories for sidebar/filter
    $categories = $this->categoryModel->getCategoriesTree();

    // Load products view
    require BASE_PATH . '/app/views/products.php';
}
public function liveSearch(){

    $keyword = $_GET['q'] ?? '';

    // Save search for logged-in users
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    $userId = $_SESSION['customer_id'] ?? null;
    if ($userId && trim($keyword) !== '') {
        try {
            $database = new Database();
            $db = $database->connect();
            $col = $db->query("SHOW COLUMNS FROM orders LIKE 'tracking_id'"); // simple probe to keep DB alive
            // ensure table exists (create if missing)
            $res = $db->query("SHOW TABLES LIKE 'user_searches'");
            if ($res && $res->num_rows === 0) {
                $db->query("CREATE TABLE user_searches (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    user_id INT(11) NOT NULL,
                    query VARCHAR(255) NOT NULL,
                    created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
                    PRIMARY KEY(id),
                    KEY user_id_idx (user_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
            }

            $stmt = $db->prepare("INSERT INTO user_searches (user_id, query) VALUES (?, ?)");
            if ($stmt) {
                $stmt->bind_param('is', $userId, $keyword);
                $stmt->execute();
            }
        } catch (Exception $e) {
            // ignore silently
        }
    }

    $products = $this->productModel->searchProducts($keyword, null);

    $results = [];

    foreach($products as $p){
        $results[] = [
            'id' => $p['id'],
            'name' => $p['name'],
            'image' => $p['image_url'],
            'type' => 'product'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($results);
    exit;
}
public function show(){
    // Load web settings
    $ws = $this->loadWebSettings();
    $webname = $ws['web_name'] ?? ''; 
    $webcontact = $ws['web_contact'] ?? ''; 
    $webmail = $ws['web_mail'] ?? '';
    $facebook = $ws['facebook'] ?? ''; 
    $instagram = $ws['instagram'] ?? ''; 
    $pinterest = $ws['pinterest'] ?? ''; 
    $linkdin = $ws['linkdin'] ?? '';
    $meta_description = $ws['meta_description'] ?? '';
    $global_theme = $ws['theme'] ?? 'theme-luxury';

    // Categories for sidebar/menu
    $categories = $this->categoryModel->getCategoriesTree();

    // Get product ID from URL
    $id = $_GET['id'] ?? null;
    if(!$id){
        die("Product not found");
    }

    // Fetch single product (by ID first, fallback to article number)
    $product = $this->productModel->getProductById($id);
    if(!$product){
        $product = $this->productModel->getProductByArticleNumber($id);
    }
    if(!$product){
        die("Product not found in database");
    }

    if ((int)$product['quantity'] <= 0) {
        $this->sendRestockRequestMail($product);
    }

    // Get category name
    $category = $this->categoryModel->getCategoryById($product['parent_cat']);
    $category_name = $category['c_name'] ?? 'Unknown Category';

    // Fetch related products: 4 random products from same category, excluding current
    $related_products = $this->productModel->getRelatedProducts($product['parent_cat'], $product['id']);

    // Review data
    $reviews = $this->productModel->getProductReviews($product['id']);
    $reviewSummary = $this->productModel->getProductReviewSummary($product['id']);

    $canReview = false;
    $reviewNotice = null;
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $userId = $_SESSION['customer_id'] ?? null;
    if ($userId) {
        $purchased = $this->productModel->userHasPurchasedProduct($userId, $product['id']);
        $alreadyReviewed = $this->productModel->userHasReviewedProduct($userId, $product['id']);
        if ($purchased && !$alreadyReviewed) {
            $canReview = true;
        } elseif (!$purchased) {
            $reviewNotice = "Only customers who purchased this product can leave a review.";
        } else {
            $reviewNotice = "You have already submitted a review for this product.";
        }
    }

    // Load single product view
    require BASE_PATH . '/app/views/single-product.php';
}

public function saveReview()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . BASE_URL . "/index.php?page=home");
        exit;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = $_SESSION['customer_id'] ?? null;
    if (empty($userId)) {
        $_SESSION['review_error'] = "Please login to submit a product review.";
        header("Location: " . BASE_URL . "/index.php?page=customer_login");
        exit;
    }

    $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $comment = trim($_POST['comment'] ?? '');

    if ($productId <= 0 || $rating < 1 || $rating > 5 || $comment === '') {
        $_SESSION['review_error'] = "Please provide a valid rating and comment.";
        header("Location: " . BASE_URL . "/index.php?page=product_show&id=" . $productId);
        exit;
    }

    if (!$this->productModel->userHasPurchasedProduct($userId, $productId)) {
        $_SESSION['review_error'] = "Only customers who bought this product can submit a review.";
        header("Location: " . BASE_URL . "/index.php?page=product_show&id=" . $productId);
        exit;
    }

    if ($this->productModel->userHasReviewedProduct($userId, $productId)) {
        $_SESSION['review_error'] = "You have already submitted a review for this product.";
        header("Location: " . BASE_URL . "/index.php?page=product_show&id=" . $productId);
        exit;
    }

    if ($this->productModel->addProductReview($userId, $productId, $rating, $comment)) {
        $_SESSION['review_success'] = "Thank you! Your review has been submitted.";
    } else {
        $_SESSION['review_error'] = "Unable to save your review. Please try again later.";
    }

    header("Location: " . BASE_URL . "/index.php?page=product_show&id=" . $productId);
    exit;
}

private function sendRestockRequestMail($product)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Prevent sending duplicate emails per session
    if (isset($_SESSION['notified_restock'][$product['id']])) {
        return;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'stitchsmartofficial@gmail.com';
        $mail->Password = 'cicm rbor wvif odaq';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('stitchsmartofficial@gmail.com', 'Stock Restock Alert');
        $mail->addAddress('stitchsmartofficial@gmail.com', 'Stitch Smart Admin');

        $mail->isHTML(true);
        $mail->Subject = "Restock Needed: " . $product['name'] . " (Out of Stock)";

        $mail->Body = "
        <div style='font-family:Arial;padding:20px;line-height:1.6;'>
            <h2 style='color:#c52c1e;'>Inventory Alert: Out of Stock ⚠️</h2>
            <p>Hello Admin,</p>
            <p>The following product has been flagged as <strong>Out of Stock</strong> because a user attempted to view or purchase it:</p>
            <table style='width:100%;border-collapse:collapse;margin-top:15px;margin-bottom:15px;'>
                <tr style='background:#f9f9f9;'>
                    <td style='padding:8px;border:1px solid #ddd;font-weight:bold;width:150px;'>Product Name:</td>
                    <td style='padding:8px;border:1px solid #ddd;'>{$product['name']}</td>
                </tr>
                <tr>
                    <td style='padding:8px;border:1px solid #ddd;font-weight:bold;'>Article Number:</td>
                    <td style='padding:8px;border:1px solid #ddd;'>{$product['article_number']}</td>
                </tr>
                <tr style='background:#f9f9f9;'>
                    <td style='padding:8px;border:1px solid #ddd;font-weight:bold;'>Product ID:</td>
                    <td style='padding:8px;border:1px solid #ddd;'>{$product['id']}</td>
                </tr>
                <tr>
                    <td style='padding:8px;border:1px solid #ddd;font-weight:bold;'>Price:</td>
                    <td style='padding:8px;border:1px solid #ddd;'>Rs. " . number_format($product['price']) . "</td>
                </tr>
                <tr style='background:#f9f9f9;'>
                    <td style='padding:8px;border:1px solid #ddd;font-weight:bold;'>Sizes Configured:</td>
                    <td style='padding:8px;border:1px solid #ddd;'>{$product['size']}</td>
                </tr>
            </table>
            <p>Please log in to the Admin Dashboard and restock this item as soon as possible to avoid losing potential sales.</p>
            <hr style='border:none;border-top:1px solid #eee;margin-top:20px;margin-bottom:20px;'>
            <p style='font-size:11px;color:#999;'>Stitch Smart Automatic Inventory System</p>
        </div>
        ";

        $mail->send();
        $_SESSION['notified_restock'][$product['id']] = true;
    } catch (Exception $e) {
        error_log('Restock Request Mail Error: ' . $mail->ErrorInfo);
    }
}
public function getProductById($id){

    $stmt = $this->conn->prepare("SELECT * FROM product WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}
}