<?php

require_once BASE_PATH.'/config/database.php';
require_once BASE_PATH.'/app/models/settings.php';
require_once BASE_PATH.'/app/models/Product.php';
require_once BASE_PATH.'/app/models/ad_category.php';

require BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class OrderController {

    private $conn;
     private $productModel;
  private $categoryModel;

    public function __construct(){
       $database = new Database();
        $db = $database->connect();
         $this->conn = $db;
         $this->productModel = new Product($db);
         $this->categoryModel = new Category($db);
    }

    public function checkout(){

   $settingsModel = new Settings();  
        $webSettings = $settingsModel->getWebSettings();

        $webname = $webSettings['web_name'] ?? '';
        $webmail = $webSettings['web_mail'] ?? '';
        $webcontact = $webSettings['web_contact'] ?? '';
        $facebook = $webSettings['facebook'] ?? '';
        $instagram = $webSettings['instagram'] ?? '';
        $pinterest = $webSettings['pinterest'] ?? '';
        $linkdin = $webSettings['linkdin'] ?? '';
        $meta_title = $webSettings['meta_title'] ?? '';
        $meta_description = $webSettings['meta_description'] ?? '';
        $global_theme = $webSettings['theme'] ?? 'theme-luxury';
        $meta_keywords = $webSettings['meta_keywords'] ?? '';


  // fetch data for homepage
        $products = $this->productModel->getAllProducts();
        $categories = $this->categoryModel->getCategoriesTree();
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $cart = $_SESSION['cart'] ?? [];

    if(empty($cart)){
        die("Cart is empty");
    }

    // calculate total
    $total = 0;
    foreach($cart as $item){
        $total += $item['price'] * $item['qty'];
    }

    require BASE_PATH . '/app/views/checkout.php';
}

 public function placeOrder()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        die("Cart is empty");
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $payment_method = $_POST['payment_method'] ?? 'cod';

    // Form Validation
    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        $_SESSION['checkout_error'] = "All billing details are required.";
        header("Location: " . BASE_URL . "index.php?page=checkout");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['checkout_error'] = "Please provide a valid email address.";
        header("Location: " . BASE_URL . "index.php?page=checkout");
        exit;
    }

    // total
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['qty'];
    }

    $user_id = $_SESSION['customer_id'] ?? null;

    // insert order
    $stmt = $this->conn->prepare(
        "INSERT INTO orders (user_id, customer_name, email, phone, address, total, status)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    $status = "Pending (" . $payment_method . ")";
    $stmt->bind_param("issssds", $user_id, $name, $email, $phone, $address, $total, $status);
    $stmt->execute();

    $order_id = $stmt->insert_id;

    // insert items
    foreach ($cart as $item) {

        $stmt = $this->conn->prepare(
            "INSERT INTO order_items (order_id, product_id, price, quantity)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "iidi",
            $order_id,
            $item['id'],
            $item['price'],
            $item['qty']
        );

        $stmt->execute();
    }

    // reduce stock
    $productModel = new Product($this->conn);

   foreach ($cart as $item) {

     $product = $productModel->getProductById($item['id']);

     if (!$product) continue;

     $oldQty = (int) $product['quantity'];
     $buyQty = (int) $item['qty'];
     $newQty = $oldQty - $buyQty;

     // reduce stock in DB
     $productModel->reduceStock($item['id'], $buyQty);

     // 🔔 trigger email when stock reaches 0 or remains at exactly 2 units
     if ($oldQty > 0 && $newQty <= 0) {
         $this->sendOutOfStockMail($product);
     } elseif ($oldQty > 2 && $newQty <= 2 && $newQty > 0) {
         $this->sendLowStockMail($product, $newQty);
     }
 }


    // ✅ SEND EMAIL (IMPORTANT: PASS CART)
    if (!empty($email)) {
        $this->sendOrderEmail($email, $name, $order_id, $total, $cart);
    }

    // clear cart
    unset($_SESSION['cart']);

    header("Location: " . BASE_URL . "/index.php?page=order_success&id=" . $order_id);
    exit;
}
private function sendOrderEmail($toEmail, $name, $order_id, $total, $cart)
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;

        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;

        $mail->SMTPSecure = MAIL_ENCRYPTION;
        $mail->Port = MAIL_PORT;

        $mail->setFrom(MAIL_USERNAME, 'Stitch Smart');
        $mail->addAddress($toEmail, $name);

        $mail->isHTML(true);
        $mail->Subject = "Order Confirmation #$order_id";

        // -----------------------------
        // BUILD ITEMS TABLE
        // -----------------------------
        $itemsHtml = "";

        foreach ($cart as $item) {

            $subtotal = $item['price'] * $item['qty'];

            $itemsHtml .= "
                <tr>
                    <td style='padding:8px;border:1px solid #ddd;'>
                        {$item['name']}
                    </td>
                    <td style='padding:8px;border:1px solid #ddd;text-align:center;'>
                        {$item['qty']}
                    </td>
                    <td style='padding:8px;border:1px solid #ddd;text-align:center;'>
                        Rs {$item['price']}
                    </td>
                    <td style='padding:8px;border:1px solid #ddd;text-align:center;'>
                        Rs {$subtotal}
                    </td>
                </tr>
            ";
        }

        // -----------------------------
        // EMAIL BODY
        // -----------------------------
        $mail->Body = "

        <div style='font-family:Arial;padding:20px'>

            <h2>Hello $name 👋</h2>

            <p>Your order has been placed successfully.</p>

            <p><b>Order ID:</b> #$order_id</p>

            <br>

            <table width='100%' style='border-collapse:collapse;'>

                <tr style='background:#f2f2f2;'>
                    <th style='padding:10px;border:1px solid #ddd;'>Product</th>
                    <th style='padding:10px;border:1px solid #ddd;'>Qty</th>
                    <th style='padding:10px;border:1px solid #ddd;'>Price</th>
                    <th style='padding:10px;border:1px solid #ddd;'>Subtotal</th>
                </tr>

                $itemsHtml

            </table>

            <br>

            <h3>Total: Rs $total</h3>

            <p>Status: Pending</p>

            <hr>

            <p>Thank you for shopping with Stitch Smart ❤️</p>

        </div>

        ";

        // fallback text
        $mail->AltBody = "Order #$order_id placed. Total: Rs $total";

        $mail->send();

    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        echo $mail->ErrorInfo;
    }
}
private function sendOutOfStockMail($product)
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = MAIL_ENCRYPTION;
        $mail->Port = MAIL_PORT;

        $mail->setFrom(MAIL_USERNAME, 'Stock Alert');

        // admin email
        $mail->addAddress(MAIL_USERNAME);

        $mail->isHTML(true);

        $mail->Subject = 'Product Out Of Stock';

        $mail->Body = "
            <h2>Inventory Alert ⚠️</h2>

            <p>The following product is now out of stock:</p>

            <ul>
                <li><strong>Product:</strong> {$product['name']}</li>
                <li><strong>Product ID:</strong> {$product['id']}</li>
                <li><strong>Remaining Quantity:</strong> 0</li>
            </ul>
        ";

        $mail->send();

    } catch (Exception $e) {

        error_log('Stock Mail Error: ' . $mail->ErrorInfo);
    }
}
private function sendLowStockMail($product, $remainingQty)
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = MAIL_ENCRYPTION;
        $mail->Port = MAIL_PORT;

        $mail->setFrom(MAIL_USERNAME, 'Stock Alert');

        // admin email
        $mail->addAddress(MAIL_USERNAME);

        $mail->isHTML(true);

        $mail->Subject = 'Product Low Stock Alert';

        $mail->Body = "
            <h2>Inventory Low Stock Alert ⚠️</h2>

            <p>The following product has dropped to low stock:</p>

            <ul>
                <li><strong>Product:</strong> {$product['name']}</li>
                <li><strong>Product ID:</strong> {$product['id']}</li>
                <li><strong>Remaining Quantity:</strong> {$remainingQty}</li>
            </ul>
        ";

        $mail->send();

    } catch (Exception $e) {

        error_log('Low Stock Mail Error: ' . $mail->ErrorInfo);
    }
}
public function success(){

    $cartItems = $_SESSION['cart'] ?? [];

    $productModel = new Product($this->conn);

    foreach ($cartItems as $item) {
        $productModel->reduceStock($item['id'], $item['qty']);
    }

    $order_id = $_GET['id'] ?? 0;

    require BASE_PATH . '/app/views/order-success.php';
}
public function customerOrders(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['customer_id'])) {
        header("Location: " . BASE_URL . "index.php?page=checkout");
        exit;
    }

    $userId = (int)$_SESSION['customer_id'];
    $stmt = $this->conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    // fetch recent chat snippet and recent searches for logged-in user
    $lastMessage = null;
    $recentSearches = [];
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    $userId = $_SESSION['customer_id'] ?? null;
    if ($userId) {
        // last chat message
        $stmt = $this->conn->prepare("SELECT role, message, created_at FROM user_chats WHERE user_id = ? ORDER BY id DESC LIMIT 1");
        if ($stmt) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $r = $stmt->get_result()->fetch_assoc();
            if ($r) $lastMessage = $r;
        }

        // recent searches
        $stmt = $this->conn->prepare("SELECT query, created_at FROM user_searches WHERE user_id = ? ORDER BY id DESC LIMIT 5");
        if ($stmt) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($sr = $res->fetch_assoc()) $recentSearches[] = $sr;
        }
    }

    // pass variables to view
    require BASE_PATH . '/app/views/customer_orders.php';
}

public function customerOrderDetail(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['customer_id'])) {
        header("Location: " . BASE_URL . "index.php?page=checkout");
        exit;
    }

    $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $userId = (int)$_SESSION['customer_id'];

    $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ? LIMIT 1");
    $stmt->bind_param("ii", $orderId, $userId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    if (!$order) {
        header("Location: " . BASE_URL . "index.php?page=customer_orders");
        exit;
    }

    $stmt = $this->conn->prepare(
        "SELECT oi.*, p.name AS product_name, p.image_url AS product_image
         FROM order_items oi
         LEFT JOIN product p ON p.id = oi.product_id
         WHERE oi.order_id = ?"
    );
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    require BASE_PATH . '/app/views/customer_order_detail.php';
}

public function manageOrders(){

    $result = $this->conn->query("SELECT * FROM orders ORDER BY id DESC");

    $orders = [];
    while($row = $result->fetch_assoc()){
        $orders[] = $row;
    }

    $data = [
        'title' => 'Manage Orders',
        'theme' => $_SESSION['theme'] ?? 'theme-luxury',
        'view'  => 'admin/manage_orders.php',
        'orders' => $orders
    ];

    extract($data);

    require BASE_PATH.'/app/views/admin/layout.php';
}
public function deleteOrder(){

    if(isset($_GET['id'])){

        $id = (int)$_GET['id'];

        // delete order items first (important FK safety)
        $stmt = $this->conn->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // delete order
        $stmt = $this->conn->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        header("Location: " . BASE_URL . "/index.php?page=manage_orders");
        exit;
    }
}

public function markDelivered(){
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $stmt = $this->conn->prepare("UPDATE orders SET status = 'Delivered' WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Order #$id marked as Delivered!";
        } else {
            $_SESSION['error'] = "Failed to update order status.";
        }
        header("Location: " . BASE_URL . "/index.php?page=manage_orders");
        exit;
    }
}

public function saveTracking()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . BASE_URL . "/index.php?page=manage_orders");
        exit;
    }

    $orderId = isset($_POST['order_id']) ? (int) $_POST['order_id'] : 0;
    $trackingId = trim($_POST['tracking_id'] ?? '');

    if ($orderId <= 0 || $trackingId === '') {
        $_SESSION['error'] = 'Please provide a valid tracking ID.';
        header("Location: " . BASE_URL . "/index.php?page=manage_orders");
        exit;
    }

    $columnExists = $this->conn->query("SHOW COLUMNS FROM orders LIKE 'tracking_id'");
    if ($columnExists && $columnExists->num_rows === 0) {
        $this->conn->query("ALTER TABLE orders ADD COLUMN tracking_id VARCHAR(100) NULL AFTER status");
    }

    $stmt = $this->conn->prepare(
        "UPDATE orders
         SET tracking_id = ?,
             status = IF(status = 'Delivered', status, 'Dispatched')
         WHERE id = ?"
    );

    if ($stmt === false) {
        error_log("OrderController::saveTracking prepare failed: " . $this->conn->error);
        $_SESSION['error'] = 'Database error while saving tracking. Please check your orders table schema.';
        header("Location: " . BASE_URL . "/index.php?page=manage_orders");
        exit;
    }

    $stmt->bind_param("si", $trackingId, $orderId);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Tracking ID saved for order #$orderId.";
    } else {
        error_log("OrderController::saveTracking execute failed: " . $stmt->error);
        $_SESSION['error'] = "Unable to save tracking ID.";
    }

    header("Location: " . BASE_URL . "/index.php?page=manage_orders");
    exit;
}

private function ensureReturnTableExists()
{
    $result = $this->conn->query("SHOW TABLES LIKE 'return_requests'");
    if ($result && $result->num_rows === 0) {
        $this->conn->query(
            "CREATE TABLE return_requests (
                id INT AUTO_INCREMENT PRIMARY KEY,
                order_id INT NOT NULL,
                order_item_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL,
                status VARCHAR(50) NOT NULL,
                damage_note TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
                FOREIGN KEY (order_item_id) REFERENCES order_items(id) ON DELETE CASCADE,
                FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );
    }
}

public function returnForm()
{
    $orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
    if ($orderId <= 0) {
        header("Location: " . BASE_URL . "/index.php?page=manage_orders");
        exit;
    }

    $this->ensureReturnTableExists();

    $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    if (!$order) {
        $_SESSION['error'] = "Order not found.";
        header("Location: " . BASE_URL . "/index.php?page=manage_orders");
        exit;
    }

    $stmt = $this->conn->prepare(
        "SELECT oi.*, p.name AS product_name, p.quantity AS stock_quantity
         FROM order_items oi
         LEFT JOIN product p ON p.id = oi.product_id
         WHERE oi.order_id = ?"
    );
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $result = $this->conn->prepare(
        "SELECT rr.*, oi.quantity AS ordered_quantity, p.name AS product_name
         FROM return_requests rr
         LEFT JOIN order_items oi ON rr.order_item_id = oi.id
         LEFT JOIN product p ON p.id = rr.product_id
         WHERE rr.order_id = ?
         ORDER BY rr.created_at DESC"
    );
    $result->bind_param("i", $orderId);
    $result->execute();
    $returns = $result->get_result()->fetch_all(MYSQLI_ASSOC);

    $data = [
        'title' => 'Process Return',
        'theme' => $_SESSION['theme'] ?? 'theme-luxury',
        'view'  => 'admin/order_return_form.php',
        'order' => $order,
        'items' => $items,
        'returns' => $returns
    ];
    extract($data);
    require BASE_PATH.'/app/views/admin/layout.php';
}

public function processReturn()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . BASE_URL . "/index.php?page=manage_orders");
        exit;
    }

    $this->ensureReturnTableExists();

    $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
    $itemIds = $_POST['return_item_id'] ?? [];
    $quantities = $_POST['return_quantity'] ?? [];
    $damages = $_POST['damage'] ?? [];
    $notes = $_POST['damage_note'] ?? [];

    if ($orderId <= 0 || empty($itemIds)) {
        $_SESSION['error'] = 'Please select items to return.';
        header("Location: " . BASE_URL . "/index.php?page=return_form&order_id=$orderId");
        exit;
    }

    $created = false;
    foreach ($itemIds as $index => $itemId) {
        $itemId = (int) $itemId;
        $quantity = isset($quantities[$index]) ? (int) $quantities[$index] : 0;
        if ($quantity <= 0) {
            continue;
        }

        $damage = isset($damages[$index]) ? 1 : 0;
        $note = trim($notes[$index] ?? '');
        $status = $damage ? 'trashed' : 'restocked';

        $stmt = $this->conn->prepare(
            "SELECT order_id, product_id, quantity FROM order_items WHERE id = ? LIMIT 1"
        );
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $item = $stmt->get_result()->fetch_assoc();

        if (!$item || $item['order_id'] != $orderId) {
            continue;
        }

        $returnQty = min($quantity, (int) $item['quantity']);
        if ($returnQty <= 0) {
            continue;
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO return_requests (order_id, order_item_id, product_id, quantity, status, damage_note)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("iiiiss", $orderId, $itemId, $item['product_id'], $returnQty, $status, $note);
        $stmt->execute();

        if (!$damage) {
            $this->productModel->increaseStock($item['product_id'], $returnQty);
        }

        $created = true;
    }

    if ($created) {
        $_SESSION['success'] = 'Return request processed successfully.';
    } else {
        $_SESSION['error'] = 'No valid return quantities were provided.';
    }

    header("Location: " . BASE_URL . "/index.php?page=return_form&order_id=$orderId");
    exit;
}

public function returnReport()
{
    $this->ensureReturnTableExists();

    $result = $this->conn->query(
        "SELECT rr.*, o.customer_name, o.status AS order_status, p.name AS product_name, oi.quantity AS ordered_quantity
         FROM return_requests rr
         LEFT JOIN orders o ON o.id = rr.order_id
         LEFT JOIN product p ON p.id = rr.product_id
         LEFT JOIN order_items oi ON oi.id = rr.order_item_id
         ORDER BY rr.created_at DESC"
    );

    $returns = [];
    while ($row = $result->fetch_assoc()) {
        $returns[] = $row;
    }

    $data = [
        'title' => 'Return Requests',
        'theme' => $_SESSION['theme'] ?? 'theme-luxury',
        'view'  => 'admin/returns_report.php',
        'returns' => $returns
    ];
    extract($data);
    require BASE_PATH.'/app/views/admin/layout.php';
}

public function returnTrash()
{
    $this->ensureReturnTableExists();

    $result = $this->conn->query(
        "SELECT rr.*, o.customer_name, o.status AS order_status, p.name AS product_name, oi.quantity AS ordered_quantity
         FROM return_requests rr
         LEFT JOIN orders o ON o.id = rr.order_id
         LEFT JOIN product p ON p.id = rr.product_id
         LEFT JOIN order_items oi ON oi.id = rr.order_item_id
         WHERE rr.status = 'trashed'
         ORDER BY rr.created_at DESC"
    );

    $returns = [];
    while ($row = $result->fetch_assoc()) {
        $returns[] = $row;
    }

    $data = [
        'title' => 'Return Trash',
        'theme' => $_SESSION['theme'] ?? 'theme-luxury',
        'view'  => 'admin/returns_trash.php',
        'returns' => $returns
    ];
    extract($data);
    require BASE_PATH.'/app/views/admin/layout.php';
}
}
