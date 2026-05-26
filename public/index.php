<?php
session_start(); // start session for admin login or user login

// Load config and database
require_once "../config/config.php";
require_once "../config/database.php";
// public/index.php
define('BASE_PATH', realpath(__DIR__ . '/..'));  // points to project root FYP-UMT
// Get page from URL (default to 'home')
$page = $_GET['page'] ?? 'home';

// Frontend Pages
$frontendPages = [
    'home' => ['controller' => 'HomeController', 'method' => 'index', 'file' => '../app/controllers/HomeController.php'],
        'sale' => ['controller' => 'HomeController', 'method' => 'sales', 'file' => '../app/controllers/HomeController.php'],
        'allproducts' => ['controller' => 'HomeController', 'method' => 'allproducts', 'file' => '../app/controllers/HomeController.php'],
    'products' => ['controller' => 'ProductController', 'method' => 'index', 'file' => '../app/controllers/ProductController.php'],
    'product' => ['controller' => 'ProductController', 'method' => 'show', 'file' => '../app/controllers/ProductController.php'],
    'product_show' => ['controller' => 'ProductController','method' => 'show','file' => '../app/controllers/ProductController.php'],
    'cart_add' => [ 'controller' => 'CartController', 'method' => 'add', 'file' => '../app/controllers/CartController.php'
],
'contact_send' => [
    'controller' => 'ContactController',
    'method' => 'send',
    'file' => '../app/controllers/ContactController.php'
],
'live_search' => [
    'controller' => 'ProductController',
    'method' => 'liveSearch',
    'file' => '../app/controllers/ProductController.php'
],
'product_review' => [
    'controller' => 'ProductController',
    'method' => 'saveReview',
    'file' => '../app/controllers/ProductController.php'
],
'cart' => [
    'controller' => 'CartController',
    'method' => 'index',
    'file' => '../app/controllers/CartController.php'
],
'checkout' => [
    'controller' => 'OrderController',
    'method' => 'checkout',
    'file' => '../app/controllers/OrderController.php'
],

'place_order' => [
    'controller' => 'OrderController',
    'method' => 'placeOrder',
    'file' => '../app/controllers/OrderController.php'
],
'order_success' => [
    'controller' => 'OrderController',
    'method' => 'success',
    'file' => '../app/controllers/OrderController.php'
],
'cart_remove' => [
    'controller' => 'CartController',
    'method' => 'remove',
    'file' => '../app/controllers/CartController.php'
],
'cart_update' => [
    'controller' => 'CartController',
    'method' => 'update',
    'file' => '../app/controllers/CartController.php'
],
'design' => ['controller' => 'DesignController', 'method' => 'index', 'file' => '../app/controllers/DesignController.php'],
'hoodie' => ['controller' => 'DesignController', 'method' => 'hoodie', 'file' => '../app/controllers/DesignController.php'],
'shorts' => ['controller' => 'DesignController', 'method' => 'shorts', 'file' => '../app/controllers/DesignController.php'],
'crewneck' => ['controller' => 'DesignController', 'method' => 'crewneck', 'file' => '../app/controllers/DesignController.php'],
'sweatpant' => ['controller' => 'DesignController', 'method' => 'sweatpant', 'file' => '../app/controllers/DesignController.php'],

'contact' => ['controller' => 'PageController', 'method' => 'index', 'file' => '../app/controllers/PageController.php'],
'page' => [
    'controller' => 'PageController',
    'method' => 'show',
    'file' => '../app/controllers/Admin//PageController.php'
],
'customer_login' => [
    'controller' => 'CustomerController',
    'method' => 'login',
    'file' => '../app/controllers/CustomerController.php'
],
'customer_register' => [
    'controller' => 'CustomerController',
    'method' => 'register',
    'file' => '../app/controllers/CustomerController.php'
],
'customer_logout' => [
    'controller' => 'CustomerController',
    'method' => 'logout',
    'file' => '../app/controllers/CustomerController.php'
],
'customer_forgot_password' => [
    'controller' => 'CustomerController',
    'method' => 'forgotPasswordForm',
    'file' => '../app/controllers/CustomerController.php'
],
'customer_forgot_password_process' => [
    'controller' => 'CustomerController',
    'method' => 'processForgotPassword',
    'file' => '../app/controllers/CustomerController.php'
],
'customer_orders' => [
    'controller' => 'OrderController',
    'method' => 'customerOrders',
    'file' => '../app/controllers/OrderController.php'
],
'customer_order_detail' => [
    'controller' => 'OrderController',
    'method' => 'customerOrderDetail',
    'file' => '../app/controllers/OrderController.php'
]
];
$frontendPages['user_chat_send'] = [
    'controller' => 'ChatController',
    'method' => 'send',
    'file' => '../app/controllers/ChatController.php'
];

$frontendPages['user_chat_save'] = [
    'controller' => 'ChatController',
    'method' => 'saveChat',
    'file' => '../app/controllers/ChatController.php'
];

$frontendPages['user_chat_history'] = [
    'controller' => 'ChatController',
    'method' => 'getChatHistory',
    'file' => '../app/controllers/ChatController.php'
];

$frontendPages['user_search_save'] = [
    'controller' => 'ChatController',
    'method' => 'saveSearch',
    'file' => '../app/controllers/ChatController.php'
];

$frontendPages['user_search_history'] = [
    'controller' => 'ChatController',
    'method' => 'getSearchHistory',
    'file' => '../app/controllers/ChatController.php'
];

$frontendPages['user_similar_products'] = [
    'controller' => 'ChatController',
    'method' => 'similarProducts',
    'file' => '../app/controllers/ChatController.php'
];
// Admin Pages
$adminPages = [
       'admin_login' => ['controller'=>'LoginController','method'=>'login','file'=>'../app/controllers/Admin/LoginController.php'],
       'admin_forgot_password' => ['controller'=>'LoginController','method'=>'forgotPassword','file'=>'../app/controllers/Admin/LoginController.php'],
       'admin_confirm_reset' => ['controller'=>'LoginController','method'=>'confirmReset','file'=>'../app/controllers/Admin/LoginController.php'],
    'admin_logout' => ['controller'=>'LoginController','method'=>'logout','file'=>'../app/controllers/Admin/LoginController.php'],
    'admin' => ['controller' => 'DashboardController', 'method' => 'index', 'file' => '../app/controllers/Admin/DashboardController.php'],
     'homepage' => ['controller' => 'HomeController', 'method' => 'index', 'file' => '../app/controllers/Admin/HomeController.php'],
     'banner_add' => ['controller'=>'BannerController','method'=>'add','file'=>'../app/controllers/Admin/BannerController.php'],
   'edit_banner' => ['controller'=>'BannerController','method'=>'edit','file'=>'../app/controllers/Admin/BannerController.php'],
'switch_theme' => [
    'controller' => 'HomeController',
    'method' => 'switchTheme',
    'file' => '../app/controllers/Admin/HomeController.php'
],
'delete_banner' => ['controller'=>'BannerController','method'=>'delete','file'=>'../app/controllers/Admin/BannerController.php'],
     'admin_products' => ['controller' => 'ProductController', 'method' => 'index', 'file' => '../app/controllers/Admin/ProductController.php'],
 'admin_sale_products' => ['controller' => 'ProductController', 'method' => 'saleIndex', 'file' => '../app/controllers/Admin/ProductController.php'],
 'add_product' => [
'controller' => 'ProductController','method' => 'create','file' => '../app/controllers/Admin/ProductController.php'],
  'edit_product'    => ['controller'=>'ProductController','method'=>'edit','file'=>'../app/controllers/Admin/ProductController.php'],
'update_product'  => ['controller'=>'ProductController','method'=>'update','file'=>'../app/controllers/Admin/ProductController.php'],
'store_product' => ['controller' => 'ProductController','method' => 'store','file' => '../app/controllers/Admin/ProductController.php'],
 'exportJSON' => [
    'controller' => 'ProductController',
    'method' => 'exportJSON',
    'file' => '../app/controllers/Admin/ProductController.php'
],
     'delete_product'=>['controller'=>'ProductController','method'=>'delete','file'=>'../app/controllers/Admin/ProductController.php'],
     'manage_orders' => [
    'controller' => 'OrderController',
    'method' => 'manageOrders',
    'file' => '../app/controllers/OrderController.php'
],
'return_form' => [
    'controller' => 'OrderController',
    'method' => 'returnForm',
    'file' => '../app/controllers/OrderController.php'
],
'process_return' => [
    'controller' => 'OrderController',
    'method' => 'processReturn',
    'file' => '../app/controllers/OrderController.php'
],
'return_report' => [
    'controller' => 'OrderController',
    'method' => 'returnReport',
    'file' => '../app/controllers/OrderController.php'
],
'return_trash' => [
    'controller' => 'OrderController',
    'method' => 'returnTrash',
    'file' => '../app/controllers/OrderController.php'
],
'feature_product' => [
    'controller' => 'ProductController',
    'method' => 'feature',
    'file' => '../app/controllers/Admin/ProductController.php'
],
'toggle_sale_product' => [
    'controller' => 'ProductController',
    'method' => 'toggleSale',
    'file' => '../app/controllers/Admin/ProductController.php'
],
'delete_order' => [
    'controller' => 'OrderController',
    'method' => 'deleteOrder',
    'file' => '../app/controllers/OrderController.php'
],
'mark_delivered' => [
    'controller' => 'OrderController',
    'method' => 'markDelivered',
    'file' => '../app/controllers/OrderController.php'
],
'save_tracking' => [
    'controller' => 'OrderController',
    'method' => 'saveTracking',
    'file' => '../app/controllers/OrderController.php'
],
 
 'admin_categories' => ['controller' => 'CategoryController','method' => 'index','file' => '../app/controllers/Admin/CategoryController.php'
],

'add_category' => ['controller' => 'CategoryController','method' => 'create','file' => '../app/controllers/Admin/CategoryController.php'
],

'store_category' => ['controller' => 'CategoryController','method' => 'store','file' => '../app/controllers/Admin/CategoryController.php'
],
'edit_category' => ['controller'=>'CategoryController','method'=>'edit','file'=>'../app/controllers/Admin/CategoryController.php'
],

'update_category' => ['controller'=>'CategoryController','method'=>'update','file'=>'../app/controllers/Admin/CategoryController.php'],

'delete_category' => ['controller' => 'CategoryController','method' => 'delete','file' => '../app/controllers/Admin/CategoryController.php'
],
'pages' => [
    'controller' => 'PageController',
    'method' => 'index',
    'file' => '../app/controllers/Admin/PageController.php'
],

'add_page' => [
    'controller' => 'PageController',
    'method' => 'add',
    'file' => '../app/controllers/Admin/PageController.php'
],

'store_page' => [
    'controller' => 'PageController',
    'method' => 'store',
    'file' => '../app/controllers/Admin/PageController.php'
],

'edit_page' => [
    'controller' => 'PageController',
    'method' => 'edit',
    'file' => '../app/controllers/Admin/PageController.php'
],

'update_page' => [
    'controller' => 'PageController',
    'method' => 'update',
    'file' => '../app/controllers/Admin/PageController.php'
],

'delete_page' => [
    'controller' => 'PageController',
    'method' => 'delete',
    'file' => '../app/controllers/Admin/PageController.php'
],
    'admin_blogs' => ['controller' => 'DashboardController', 'method' => 'index', 'file' => '../app/controllers/Admin/DashboardController.php'],
    'admin_save_settings' => ['controller' => 'DashboardController', 'method' => 'saveSettings', 'file' => '../app/controllers/Admin/DashboardController.php'],
    'sales_report' => ['controller' => 'DashboardController', 'method' => 'salesReport', 'file' => '../app/controllers/Admin/DashboardController.php'],
    'download_report' => ['controller' => 'DashboardController', 'method' => 'downloadReport', 'file' => '../app/controllers/Admin/DashboardController.php'],
    'send_retention_email' => ['controller' => 'DashboardController', 'method' => 'sendRetentionEmail', 'file' => '../app/controllers/Admin/DashboardController.php'],
];

// Determine if page exists
if (isset($frontendPages[$page])) {
    $route = $frontendPages[$page];
} elseif (isset($adminPages[$page])) {
   
    // Admin pages except login can only be accessed if logged in
if ($page !== 'admin_login' && $page !== 'admin_logout' && $page !== 'admin_forgot_password' && $page !== 'admin_confirm_reset' && !isset($_SESSION['admin_logged_in'])) {
    header("Location: ".BASE_URL."index.php?page=admin_login");
    exit;
}
    $route = $adminPages[$page];
} else {
    // Treat unknown frontend routes as page slug
    require_once '../app/controllers/Admin/PageController.php';

    $controller = new PageController();
    $controller->show($page); // pass slug

    exit;
}
// Load the controller and call the method
require_once $route['file'];
$controllerName = $route['controller'];
$method = $route['method'];

$controller = new $controllerName();

// List of pages that require ID
$pagesWithId = ['product', 'edit_product', 'delete_product', 'edit_category', 
'delete_category', 'edit_banner', 'delete_banner', 'cart_remove', 'edit_page',
'update_page', 'delete_page'];

if ($page === 'page') {
    $slug = $_GET['slug'] ?? '';
    $controller->$method($slug);
} elseif (in_array($page, $pagesWithId)) {
    if (!isset($_GET['id'])) {
        die("ID missing for this action.");
    }
    $controller->$method((int)$_GET['id']);
} else {
    $controller->$method();
}

?>