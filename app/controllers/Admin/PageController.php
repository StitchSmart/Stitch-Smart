<?php
require_once BASE_PATH.'/app/models/pages.php';
require_once BASE_PATH.'/config/database.php';
require_once BASE_PATH.'/app/models/settings.php';
require_once BASE_PATH.'/app/models/Product.php';
require_once BASE_PATH.'/app/models/ad_category.php';
class PageController {

    private $pageModel;
  private $productModel;
    private $categoryModel;
   public function __construct(){
    $database = new Database();
    $db = $database->connect(); // returns mysqli connection

    $this->pageModel = new Page($db); // inject mysqli connection
     $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
}

    // Show all pages
    public function index() {
        $pages = $this->pageModel->getAllPages(); // use 'all()' from model
         $data = [
        'title' => 'Pages',
        'theme' => $_SESSION['theme'] ?? 'theme-luxury',
        'view' => 'admin/pages.php',
        'pages' => $pages
    ];

    extract($data);

    require BASE_PATH.'/app/views/admin/layout.php';
    }

    // Show add page form
    public function add() {
         $data = [
        'title' => 'Add Page',
        'theme' => $_SESSION['theme'] ?? 'theme-luxury',
        'view' => 'admin/add_page.php'
    ];

    extract($data);

    require BASE_PATH.'/app/views/admin/layout.php';
    }

    // Handle add page form
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $title = htmlspecialchars(trim($_POST['title']));
            $content = trim($_POST['content']);
            $meta_title = trim($_POST['meta_title'] ?? '');
            $meta_desc = trim($_POST['meta_desc'] ?? '');
            $meta_keywords = trim($_POST['meta_keywords'] ?? '');
            
            if (empty($title)) {
                $errors['title'] = "Fill the Title field.";
            }
            if (empty(strip_tags($content))) {
                $errors['content'] = "Fill the Content field.";
            }
            if (empty($meta_title)) {
                $errors['meta_title'] = "Fill the Meta Title field.";
            }
            if (empty($meta_desc)) {
                $errors['meta_desc'] = "Fill the Meta Description field.";
            }
            if (empty($meta_keywords)) {
                $errors['meta_keywords'] = "Fill the Meta Keywords field.";
            }
            
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = [
                    'title' => $_POST['title'] ?? '',
                    'content' => $_POST['content'] ?? '',
                    'meta_title' => $_POST['meta_title'] ?? '',
                    'meta_desc' => $_POST['meta_desc'] ?? '',
                    'meta_keywords' => $_POST['meta_keywords'] ?? ''
                ];
                header("Location: ".BASE_URL."/index.php?page=add_page");
                exit;
            }

            $data = [
                'title' => $title,
                'content' => $content,
                'meta_title' => $meta_title,
                'meta_description' => $meta_desc,
                'meta_keywords' => $meta_keywords
            ];

            $this->pageModel->createPage($data);

            header("Location: ".BASE_URL."/index.php?page=pages");
            exit;
        }
    }

    // Show edit form
    public function edit($id) {
        $page = $this->pageModel->getPageById($id);; // use 'find()' from model
        if (!$page) die("Page not found");

         $data = [
        'title' => 'Edit Page',
        'theme' => $_SESSION['theme'] ?? 'theme-luxury',
        'view' => 'admin/edit_page.php',
        'page' => $page
    ];

    extract($data);

    require BASE_PATH.'/app/views/admin/layout.php';
    }

    // Handle edit form submission
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $data = [
            'id' => $id, // OR $_POST['id']
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'meta_title' => $_POST['meta_title'],
            'meta_description' => $_POST['meta_desc'], // IMPORTANT mapping
            'meta_keywords' => $_POST['meta_keywords']
        ];

 $this->pageModel->updatePage($data);
            header("Location: ".BASE_URL."/index.php?page=pages");
            exit;
        }
    }
public function show($slug){
    $page = $this->pageModel->getPageBySlug($slug);
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
        $categories = $this->categoryModel->getMainCategories();

 
      

    if(!$page){
        require BASE_PATH.'/app/views/404.php';
        exit;
    }

    // 👇 ADD THIS
    $pages = $this->pageModel->getAllPages();

    require BASE_PATH.'/app/views/page.php';
}
    // Delete page
    public function delete($id) {
        $this->pageModel->deletePage($id); // use 'delete()' from model

        header("Location: ".BASE_URL."/index.php?page=pages");
        exit;
    }
}
