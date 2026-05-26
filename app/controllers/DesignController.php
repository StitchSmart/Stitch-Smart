<?php

require_once BASE_PATH.'/config/database.php';
require_once BASE_PATH.'/app/models/settings.php';
require_once BASE_PATH.'/app/models/Product.php';
require_once BASE_PATH.'/app/models/ad_category.php';

class DesignController {
 private $productModel;
    private $categoryModel;

    public function __construct(){
        $database = new Database();
        $db = $database->connect();

        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
    }
    public function index() {
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
        require BASE_PATH . '/app/views/designyourself/interface.php';
    }
     public function hoodie() {
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
        require BASE_PATH . '/app/views/designyourself/hoodie.php';
    }
    public function shorts() {
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
        require BASE_PATH . '/app/views/designyourself/shorts.php';
    }
    public function crewneck() {
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
        require BASE_PATH . '/app/views/designyourself/crewneck.php';
    }

 public function sweatpant() {
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
        require BASE_PATH . '/app/views/designyourself/sweatpant.php';
    }
}
