<?php
require_once __DIR__ . '/../../models/settings.php';
require_once __DIR__ . '/../../../config/database.php';

require BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class DashboardController {
    public function index() {
        $settingsModel = new Settings();  
        $webSettings = $settingsModel->getWebSettings();

        // Get dashboard counts
        $database = new Database();
        $conn = $database->connect();
        $counts = [];
        $counts['products'] = $conn->query("SELECT COUNT(*) as c FROM product")->fetch_assoc()['c'];
        $counts['categories'] = $conn->query("SELECT COUNT(*) as c FROM category")->fetch_assoc()['c'];
        $counts['orders'] = $conn->query("SELECT COUNT(*) as c FROM orders")->fetch_assoc()['c'];
        $counts['blogs'] = 0;

        $lowStockThreshold = 10;
        $counts['low_stock'] = (int) $conn->query("SELECT COUNT(*) as c FROM product WHERE quantity > 0 AND quantity <= {$lowStockThreshold}")->fetch_assoc()['c'];
        $counts['out_of_stock'] = (int) $conn->query("SELECT COUNT(*) as c FROM product WHERE quantity = 0")->fetch_assoc()['c'];
        $counts['healthy_stock'] = max(0, $counts['products'] - $counts['low_stock'] - $counts['out_of_stock']);

        $lowStockProducts = [];
        $resLowStock = $conn->query("SELECT id, article_number, name, quantity FROM product WHERE quantity > 0 AND quantity <= {$lowStockThreshold} ORDER BY quantity ASC, name ASC LIMIT 20");
        while ($row = $resLowStock->fetch_assoc()) {
            $lowStockProducts[] = $row;
        }

        $outOfStockProducts = [];
        $resOutOfStock = $conn->query("SELECT id, article_number, name, quantity FROM product WHERE quantity = 0 ORDER BY name ASC LIMIT 20");
        while ($row = $resOutOfStock->fetch_assoc()) {
            $outOfStockProducts[] = $row;
        }

        // Fetch data for the graph (last 7 days)
        $graphData = [];
        $res = $conn->query("SELECT DATE(created_at) as date, COUNT(*) as count FROM orders GROUP BY DATE(created_at) ORDER BY date DESC LIMIT 7");
        while($row = $res->fetch_assoc()) {
            $graphData[] = $row;
        }
        $graphData = array_reverse($graphData);

        $data = [
            'title' => 'Dashboard',
            'theme' => $_SESSION['theme'] ?? 'theme-luxury',
            'view'  => 'admin/dashbaord.php',
            'counts' => $counts,
            'graphData' => $graphData,
            'lowStockProducts' => $lowStockProducts,
            'outOfStockProducts' => $outOfStockProducts,
            'webname' => $webSettings['web_name'] ?? '',
            'webmail' => $webSettings['web_mail'] ?? '',
            'webcontact' => $webSettings['web_contact'] ?? '',
            'facebook' => $webSettings['facebook'] ?? '',
            'instagram' => $webSettings['instagram'] ?? '',
            'pinterest' => $webSettings['pinterest'] ?? '',
            'linkdin' => $webSettings['linkdin'] ?? '',
            'meta_title' => $webSettings['meta_title'] ?? '',
            'meta_description' => $webSettings['meta_description'] ?? '',
            'meta_keywords' => $webSettings['meta_keywords'] ?? ''
        ];

        extract($data);
        require BASE_PATH . '/app/views/admin/layout.php';
    }

    public function salesReport() {
        $database = new Database();
        $conn = $database->connect();

        // Get customers who haven't ordered in the last 7 days
        // We select unique customers who have orders, but none in the last 7 days
        $sql = "SELECT DISTINCT customer_name, email, phone, created_at 
                FROM orders 
                WHERE customer_name NOT IN (
                    SELECT customer_name FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                )
                ORDER BY created_at DESC";
        
        $res = $conn->query($sql);
        $inactiveCustomers = [];
        while($row = $res->fetch_assoc()) {
            $inactiveCustomers[] = $row;
        }

        $data = [
            'title' => 'Sales Report',
            'theme' => $_SESSION['theme'] ?? 'theme-luxury',
            'view'  => 'admin/sales_report.php',
            'inactiveCustomers' => $inactiveCustomers
        ];
        extract($data);
        require BASE_PATH . '/app/views/admin/layout.php';
    }

    public function downloadReport() {
        $period = $_GET['period'] ?? '7days';
        $database = new Database();
        $conn = $database->connect();

        $interval = "7 DAY";
        if ($period == '1month') $interval = "1 MONTH";
        if ($period == '6month') $interval = "6 MONTH";

        $sql = "SELECT * FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL $interval) ORDER BY created_at DESC";
        $res = $conn->query($sql);
        $orders = [];
        while($row = $res->fetch_assoc()) {
            $orders[] = $row;
        }

        // Load a clean printable view
        require BASE_PATH . '/app/views/admin/print_report.php';
    }
    public function saveSettings()
    {
        require_once BASE_PATH . '/config/database.php';
        $database = new Database();
        $conn = $database->connect();

        if(isset($_POST['save_contact_info'])) {
            $webname = trim($_POST['webname'] ?? '');
            $webmail = filter_var($_POST['webmail'] ?? '', FILTER_VALIDATE_EMAIL);
            $webcontact = trim($_POST['webcontact'] ?? '');

            if (!$webname || !$webmail || !$webcontact) {
                $_SESSION['error'] = "All contact fields are required and must be valid.";
                header("Location: " . BASE_URL . "index.php?page=admin");
                exit;
            }

            $stmt = $conn->prepare("UPDATE web_settings SET web_name=?, web_mail=?, web_contact=? WHERE id=1");
            $stmt->bind_param("sss", $webname, $webmail, $webcontact);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Contact information updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update contact information.";
            }
            header("Location: " . BASE_URL . "index.php?page=admin");
            exit;
        }

        if(isset($_POST['save_meta_info'])) {
            $meta_title = trim($_POST['meta_title'] ?? '');
            $meta_description = trim($_POST['meta_description'] ?? '');
            $meta_keywords = trim($_POST['meta_keywords'] ?? '');

            if (!$meta_title) {
                $_SESSION['error'] = "Meta Title is required for SEO.";
                header("Location: " . BASE_URL . "index.php?page=homepage");
                exit;
            }

            $stmt = $conn->prepare("UPDATE web_settings SET meta_title=?, meta_description=?, meta_keywords=? WHERE id=1");
            $stmt->bind_param("sss", $meta_title, $meta_description, $meta_keywords);
            if ($stmt->execute()) {
                $_SESSION['success'] = "SEO settings updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update SEO settings.";
            }
            header("Location: " . BASE_URL . "index.php?page=homepage");
            exit;
        }
    }

    public function sendRetentionEmail() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = $_GET['email'] ?? '';
        $name = $_GET['name'] ?? 'Valued Customer';

        if (empty($email)) {
            $_SESSION['error'] = "Customer email is required.";
            header("Location: " . BASE_URL . "index.php?page=sales_report");
            exit;
        }

        $mail = new PHPMailer(true);

        try {
            // SMTP Settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'stitchsmartofficial@gmail.com';
            $mail->Password   = 'cicm rbor wvif odaq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // From / To
            $mail->setFrom('stitchsmartofficial@gmail.com', 'Stitch Smart');
            $mail->addAddress($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'We miss you at Stitch Smart! ❤️';
            
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e5e7eb; border-radius: 12px; background-color: #ffffff; color: #111827;'>
                    <div style='text-align: center; margin-bottom: 20px;'>
                        <h2 style='color: #c19a4e; font-size: 24px; margin-top: 0;'>Hello " . htmlspecialchars($name) . " 👋</h2>
                    </div>
                    <p style='font-size: 16px; line-height: 1.5; color: #374151;'>We noticed you haven't shopped with us in a while, and we truly miss your presence!</p>
                    <p style='font-size: 16px; line-height: 1.5; color: #374151;'>To welcome you back, we've updated our collection with premium new custom designs. Designing your perfect apparel is now smoother and faster than ever!</p>
                    
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='" . BASE_URL . "index.php?page=homepage' style='display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #c19a4e 0%, #8b5a2b 100%); color: #ffffff; text-decoration: none; font-weight: 700; border-radius: 50px; text-transform: uppercase; box-shadow: 0 4px 15px rgba(193, 154, 78, 0.3); font-size: 14px;'>Explore New Designs ✨</a>
                    </div>
                    
                    <hr style='border: 0; border-top: 1px solid #e5e7eb; margin: 25px 0;'>
                    <p style='font-size: 13px; text-align: center; color: #6b7280; margin-bottom: 0;'>Thank you for being a cherished part of Stitch Smart.</p>
                </div>
            ";

            $mail->AltBody = "Hello {$name}, we miss you at Stitch Smart! Check out our new premium custom designs at " . BASE_URL;

            $mail->send();
            $_SESSION['success'] = "Re-engagement email successfully sent to " . htmlspecialchars($name) . "!";
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed to send email. Mailer Error: " . $mail->ErrorInfo;
        }

        header("Location: " . BASE_URL . "index.php?page=sales_report");
        exit;
    }
}
