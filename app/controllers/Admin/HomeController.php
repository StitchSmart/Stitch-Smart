<?php
require_once __DIR__ . '/../../models/settings.php';

class HomeController {
    public function index() {
        $settingsModel = new Settings();  
        $webSettings = $settingsModel->getWebSettings();

       

 $bannerModel = new Banner();
        $banners = $bannerModel->getAllBanners();
         $data = [
        'title' => 'Website Settings',
        'theme' => $_SESSION['theme'] ?? 'theme-luxury',
        'view' => 'admin/homepage.php',

        'webname' => $webSettings['web_name'] ?? '',
        'webmail' => $webSettings['web_mail'] ?? '',
        'webcontact' => $webSettings['web_contact'] ?? '',
        'facebook' => $webSettings['facebook'] ?? '',
        'instagram' => $webSettings['instagram'] ?? '',
        'pinterest' => $webSettings['pinterest'] ?? '',
        'linkdin' => $webSettings['linkdin'] ?? '',
        'meta_title' => $webSettings['meta_title'] ?? '',
        'meta_description' => $webSettings['meta_description'] ?? '',
        'meta_keywords' => $webSettings['meta_keywords'] ?? '',
        'banners' => $banners
    ];

    extract($data);

    require BASE_PATH . '/app/views/admin/layout.php';
      
    }
    public function saveSettings()
{
    require_once BASE_PATH . '/config/database.php';

    $database = new Database();
    $conn = $database->connect();



   

    }
    public function switchTheme()
    {
        if (isset($_GET['theme'])) {
            $newTheme = $_GET['theme'];
            
            // Save to session for immediate fallback
            $_SESSION['theme'] = $newTheme;
            
            // Save globally in the database
            require_once BASE_PATH . '/config/database.php';
            $database = new Database();
            $conn = $database->connect();
            
            $stmt = $conn->prepare("UPDATE web_settings SET theme = ? WHERE id = 1");
            $stmt->bind_param("s", $newTheme);
            $stmt->execute();
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}


