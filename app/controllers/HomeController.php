<?php

require_once BASE_PATH.'/config/database.php';
require_once BASE_PATH.'/app/models/settings.php';
require_once BASE_PATH.'/app/models/Product.php';
require_once BASE_PATH.'/app/models/ad_category.php';

class HomeController {

    private $productModel;
    private $categoryModel;

    public function __construct(){
        $database = new Database();
        $db = $database->connect();

        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
    }

    
    public function index(){
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
        $meta_keywords = $webSettings['meta_keywords'] ?? '';
        $global_theme = $webSettings['theme'] ?? 'theme-luxury';
        // fetch data for homepage
        $products = $this->productModel->getAllProducts();
        $categories = $this->categoryModel->getCategoriesTree();

 $bannerModel = new Banner();
        $banners = $bannerModel->getAllBanners();
      

        require BASE_PATH.'/app/views/home.php';
    }
    public function allproducts(){

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
    $meta_keywords = $webSettings['meta_keywords'] ?? '';
    $global_theme = $webSettings['theme'] ?? 'theme-luxury';

    // Pagination logic
    $limit = 8;
    $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
    $page = max($page, 1);
    $offset = ($page - 1) * $limit;

   
   $totalProducts = $this->productModel->getAllProductsCount();
   $totalPages = ceil($totalProducts / $limit);

   $products = $this->productModel->getAllProductsPaginated($limit, $offset);
   $allProducts = $this->productModel->getAllProductsForAI(); // Fetch all products with categories for client-side slider & category filters
   $categories = $this->categoryModel->getCategoriesTree();

   require BASE_PATH.'/app/views/allproducts.php';
}
public function sales(){

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
    $meta_keywords = $webSettings['meta_keywords'] ?? '';
    $global_theme = $webSettings['theme'] ?? 'theme-luxury';

       $limit = 8;
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

$totalProducts = $this->productModel->getFeaturedProductsCount();
$totalPages = ceil($totalProducts / $limit);

$products = $this->productModel->getFeaturedProducts($limit, $offset);
 $categories = $this->categoryModel->getCategoriesTree();

require BASE_PATH.'/app/views/sale.php';
}
}