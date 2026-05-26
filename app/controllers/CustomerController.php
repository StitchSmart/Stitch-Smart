<?php
require_once '../app/models/User.php';
require_once '../config/database.php';
require_once '../app/libraries/PHPMailer/src/Exception.php';
require_once '../app/libraries/PHPMailer/src/PHPMailer.php';
require_once '../app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CustomerController {
    private $userModel;

    public function __construct() {
        $db = new Database();
        $this->userModel = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            // Optional redirect target
            $redirect = $_POST['redirect'] ?? 'home';

            if (empty($email) || empty($password)) {
                $_SESSION['login_error'] = "Please enter both email and password.";
                header("Location: " . BASE_URL . "index.php?page=" . $redirect);
                exit;
            }

            $user = $this->userModel->login($email, $password);

            if ($user) {
                $_SESSION['customer_logged_in'] = true;
                $_SESSION['customer_id'] = $user['id'];
                $_SESSION['customer_name'] = $user['name'];
                $_SESSION['customer_email'] = $user['email'];
                $_SESSION['customer_phone'] = $user['phone'];

                header("Location: " . BASE_URL . "index.php?page=" . $redirect);
                exit;
            } else {
                // Return to checkout with error
                $_SESSION['login_error'] = "Invalid email or password.";
                header("Location: " . BASE_URL . "index.php?page=" . $redirect);
                exit;
            }
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $redirect = $_POST['redirect'] ?? 'home';

            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['register_error'] = "Please fill in all required fields.";
                header("Location: " . BASE_URL . "index.php?page=" . $redirect);
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['register_error'] = "Please provide a valid email address.";
                header("Location: " . BASE_URL . "index.php?page=" . $redirect);
                exit;
            }

            if (strlen($password) < 6) {
                $_SESSION['register_error'] = "Password must be at least 6 characters long.";
                header("Location: " . BASE_URL . "index.php?page=" . $redirect);
                exit;
            }

            // Check if email exists
            if ($this->userModel->getUserByEmail($email)) {
                $_SESSION['register_error'] = "An account with this email already exists.";
                header("Location: " . BASE_URL . "index.php?page=" . $redirect);
                exit;
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $userId = $this->userModel->register($name, $phone, $email, $passwordHash);

            if ($userId) {
                // Auto login
                $_SESSION['customer_logged_in'] = true;
                $_SESSION['customer_id'] = $userId;
                $_SESSION['customer_name'] = $name;
                $_SESSION['customer_email'] = $email;
                $_SESSION['customer_phone'] = $phone;

                header("Location: " . BASE_URL . "index.php?page=" . $redirect);
                exit;
            } else {
                $_SESSION['register_error'] = "Something went wrong. Please try again.";
                header("Location: " . BASE_URL . "index.php?page=" . $redirect);
                exit;
            }
        }
    }

    public function logout() {
        // Unset customer specific session variables
        unset($_SESSION['customer_logged_in']);
        unset($_SESSION['customer_id']);
        unset($_SESSION['customer_name']);
        unset($_SESSION['customer_email']);
        unset($_SESSION['customer_phone']);
        
        $redirect = $_GET['redirect'] ?? 'home';
        header("Location: " . BASE_URL . "index.php?page=" . $redirect);
        exit;
    }

    public function forgotPasswordForm() {
        // Fetch current theme for branding if needed
        $db = new Database();
        $conn = $db->connect();
        $theme_res = $conn->query("SELECT theme, web_name FROM web_settings WHERE id = 1");
        $theme_data = $theme_res->fetch_assoc();
        $webname = $theme_data['web_name'] ?? 'Stitch Smart';
        
        // Default step to 'request' if not set
        if (!isset($_SESSION['reset_step_customer'])) {
            $_SESSION['reset_step_customer'] = 'request';
        }

        require_once '../app/views/customer_forgot_password.php';
    }

    public function processForgotPassword() {
        if (isset($_GET['action']) && $_GET['action'] === 'cancel') {
            unset($_SESSION['reset_step_customer']);
            unset($_SESSION['reset_email_customer']);
            unset($_SESSION['reset_otp_customer']);
            unset($_SESSION['reset_otp_expiry_customer']);
            unset($_SESSION['otp_verified_customer']);
            unset($_SESSION['debug_otp_customer']);
            header("Location: " . BASE_URL . "index.php?page=customer_forgot_password");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $step = $_SESSION['reset_step_customer'] ?? 'request';

            if ($step === 'request') {
                $email = trim($_POST['email'] ?? '');
                $user = $this->userModel->getUserByEmail($email);

                if ($user) {
                    // Generate 6-digit OTP
                    $otp = rand(100000, 999999);
                    $_SESSION['reset_email_customer'] = $email;
                    $_SESSION['reset_otp_customer'] = $otp;
                    $_SESSION['reset_otp_expiry_customer'] = time() + 600; // 10 minutes expiry
                    $_SESSION['debug_otp_customer'] = $otp; // Subtle helper for quick testing

                    // Send OTP via PHPMailer
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
                        $mail->addAddress($email, $user['name']);

                        $mail->isHTML(true);
                        $mail->Subject = "One-Time Password (OTP) for Password Reset";
                        $mail->Body = "
                        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 30px; border: 1px solid #c19a4e; border-radius: 16px; background-color: #0a0a0a; color: #ffffff;'>
                            <h2 style='color: #c19a4e; text-align: center; font-size: 24px; margin-bottom: 20px;'>Stitch Smart Password Reset</h2>
                            <p style='font-size: 16px; line-height: 1.6; color: #cccccc;'>Hello <strong>{$user['name']}</strong>,</p>
                            <p style='font-size: 16px; line-height: 1.6; color: #cccccc;'>You recently requested to reset your password for Stitch Smart. Please use the following One-Time Password (OTP) to verify your account:</p>
                            <div style='text-align: center; margin: 30px 0;'>
                                <span style='display: inline-block; font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #c19a4e; padding: 15px 30px; border: 2px dashed #c19a4e; border-radius: 8px; background: rgba(193,154,78,0.1);'>{$otp}</span>
                            </div>
                            <p style='font-size: 14px; color: #999999; text-align: center;'>This OTP is valid for <strong>10 minutes</strong>. If you did not make this request, please ignore this email or contact support.</p>
                            <hr style='border-color: rgba(193,154,78,0.2); margin: 30px 0;'>
                            <p style='font-size: 14px; color: #777777; text-align: center; margin-bottom: 0;'>Thank you,<br><strong>Stitch Smart Team</strong></p>
                        </div>
                        ";
                        $mail->AltBody = "Hello {$user['name']}, your OTP for password reset is {$otp}. It is valid for 10 minutes.";

                        $mail->send();
                        $_SESSION['forgot_success'] = "One-Time Password (OTP) has been sent to your email.";
                    } catch (Exception $e) {
                        // Keep OTP generated for debug/demo/fallback case
                        $_SESSION['forgot_success'] = "One-Time Password (OTP) has been generated. (Email system simulation fallback enabled)";
                    }
                    $_SESSION['reset_step_customer'] = 'verify_otp';
                } else {
                    $_SESSION['forgot_error'] = "No account found with that email address.";
                }

                header("Location: " . BASE_URL . "index.php?page=customer_forgot_password");
                exit;

            } elseif ($step === 'verify_otp') {
                $enteredOtp = trim($_POST['otp'] ?? '');
                $savedOtp = $_SESSION['reset_otp_customer'] ?? '';
                $expiry = $_SESSION['reset_otp_expiry_customer'] ?? 0;

                if (empty($enteredOtp)) {
                    $_SESSION['forgot_error'] = "Please enter the OTP.";
                } elseif (time() > $expiry) {
                    $_SESSION['forgot_error'] = "The OTP has expired. Please request a new one.";
                    $_SESSION['reset_step_customer'] = 'request';
                } elseif ($enteredOtp == $savedOtp) {
                    $_SESSION['otp_verified_customer'] = true;
                    $_SESSION['reset_step_customer'] = 'reset_password';
                    $_SESSION['forgot_success'] = "OTP verified successfully. Please choose a new password.";
                } else {
                    $_SESSION['forgot_error'] = "Invalid OTP code. Please try again.";
                }

                header("Location: " . BASE_URL . "index.php?page=customer_forgot_password");
                exit;

            } elseif ($step === 'reset_password') {
                if (!isset($_SESSION['otp_verified_customer']) || $_SESSION['otp_verified_customer'] !== true) {
                    $_SESSION['forgot_error'] = "Unauthorized access. Please start over.";
                    $_SESSION['reset_step_customer'] = 'request';
                    header("Location: " . BASE_URL . "index.php?page=customer_forgot_password");
                    exit;
                }

                $password = $_POST['password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';

                if (strlen($password) < 4) {
                    $_SESSION['forgot_error'] = "Password must be at least 4 characters long.";
                } elseif ($password !== $confirmPassword) {
                    $_SESSION['forgot_error'] = "Passwords do not match.";
                } else {
                    $email = $_SESSION['reset_email_customer'] ?? '';
                    $user = $this->userModel->getUserByEmail($email);

                    if ($user) {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        if ($this->userModel->updatePassword($user['id'], $hashedPassword)) {
                            // Cleanup
                            unset($_SESSION['reset_step_customer']);
                            unset($_SESSION['reset_email_customer']);
                            unset($_SESSION['reset_otp_customer']);
                            unset($_SESSION['reset_otp_expiry_customer']);
                            unset($_SESSION['otp_verified_customer']);
                            unset($_SESSION['debug_otp_customer']);

                            $_SESSION['login_success'] = "Password has been successfully updated. You can now login.";
                            header("Location: " . BASE_URL . "index.php?page=checkout");
                            exit;
                        } else {
                            $_SESSION['forgot_error'] = "Failed to update password. Please try again.";
                        }
                    } else {
                        $_SESSION['forgot_error'] = "User account not found.";
                    }
                }

                header("Location: " . BASE_URL . "index.php?page=customer_forgot_password");
                exit;
            }
        }
    }
}
?>
