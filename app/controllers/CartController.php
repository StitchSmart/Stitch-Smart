<?php

require_once BASE_PATH.'/config/database.php';
require_once BASE_PATH.'/app/models/Product.php';
require_once BASE_PATH.'/app/models/ad_category.php';
require_once BASE_PATH.'/app/models/settings.php';

require_once BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require_once BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require_once BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CartController {

    private $productModel;
    private $categoryModel;


    public function __construct(){
        $database = new Database();
        $db = $database->connect();

        $this->productModel = new Product($db);
         $this->categoryModel = new Category($db);
    }

    public function add(){

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $product_id = $_POST['product_id'] ?? null;
    $qty = (int)($_POST['qty'] ?? 1);
    $size = $_POST['size'] ?? '';
    $fabric = $_POST['fabric'] ?? '';

    if(!$product_id){
        die("Invalid Product");
    }

    $product = $this->productModel->getProductById($product_id);

    if(!$product){
        die("Product not found");
    }

    // Out of Stock check
    if ((int)$product['quantity'] <= 0) {
        $this->sendRestockRequestMail($product);
        $_SESSION['cart_error'] = "The product '" . $product['name'] . "' is currently out of stock. We have automatically notified the admin to restock it.";
        header("Location: " . BASE_URL . "/index.php?page=product_show&id=" . $product_id);
        exit;
    }

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }

    if(isset($_SESSION['cart'][$product_id])){
        $newQty = $_SESSION['cart'][$product_id]['qty'] + $qty;
        if($newQty > $product['quantity']){
            $_SESSION['cart_error'] = "We only have " . $product['quantity'] . " units in stock for this product.";
            header("Location: " . BASE_URL . "/index.php?page=product_show&id=" . $product_id);
            exit;
        }
        $_SESSION['cart'][$product_id]['qty'] = $newQty;
        if (!empty($size)) $_SESSION['cart'][$product_id]['size'] = $size;
        if (!empty($fabric)) $_SESSION['cart'][$product_id]['fabric'] = $fabric;
    } else {
        if($qty > $product['quantity']){
            $_SESSION['cart_error'] = "We only have " . $product['quantity'] . " units in stock for this product.";
            header("Location: " . BASE_URL . "/index.php?page=product_show&id=" . $product_id);
            exit;
        }
        $_SESSION['cart'][$product_id] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image_url'],
            'qty' => $qty,
            'size' => $size,
            'fabric' => $fabric
        ];
    }

    $_SESSION['cart_success'] = "Added '" . $product['name'] . "' to your cart successfully!";
    header("Location: " . BASE_URL . "/index.php?page=cart");
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
            <p>The following product has been flagged as <strong>Out of Stock</strong> because a user attempted to purchase it:</p>
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
        $_SESSION['notified_restock'][$product['id'] ] = true;
    } catch (Exception $e) {
        error_log('Restock Request Mail Error: ' . $mail->ErrorInfo);
    }
}

    public function index(){
        $categories = $this->categoryModel->getCategoriesTree();
        $settingsModel = new Settings();
        $ws = $settingsModel->getWebSettings();
        $webname = $ws['web_name'] ?? ''; $webcontact = $ws['web_contact'] ?? ''; $webmail = $ws['web_mail'] ?? '';
        $facebook = $ws['facebook'] ?? ''; $instagram = $ws['instagram'] ?? ''; $pinterest = $ws['pinterest'] ?? ''; $linkdin = $ws['linkdin'] ?? '';
        $meta_description = $ws['meta_description'] ?? '';
        $global_theme = $ws['theme'] ?? 'theme-luxury';

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $cart = $_SESSION['cart'] ?? [];

        require BASE_PATH . '/app/views/cart.php';
    }

    public function remove(){

        if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

        $id = $_GET['id'] ?? null;

        if($id && isset($_SESSION['cart'][$id])){
            unset($_SESSION['cart'][$id]);
        }

        header("Location: " . BASE_URL . "/index.php?page=cart");
        exit;
    }
    public function update(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id = $_GET['id'] ?? null;
        $action = $_GET['action'] ?? 'add';

        if($id && isset($_SESSION['cart'][$id])){
            $product = $this->productModel->getProductById($id);
            if($action === 'add'){
                if(($_SESSION['cart'][$id]['qty'] + 1) > $product['quantity']){
                     // Just don't increment if stock exceeded
                } else {
                    $_SESSION['cart'][$id]['qty']++;
                }
            } else if($action === 'minus'){
                $_SESSION['cart'][$id]['qty']--;
                if($_SESSION['cart'][$id]['qty'] <= 0){
                    unset($_SESSION['cart'][$id]);
                }
            }
        }

        header("Location: " . BASE_URL . "/index.php?page=cart");
        exit;
    }
}