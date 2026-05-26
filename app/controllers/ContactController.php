<?php

require BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController
{
    public function send()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if (empty($name) || empty($email) || empty($message)) {
                $_SESSION['error'] = "All fields are required.";
                header("Location: " . BASE_URL . "/index.php?page=contact");
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Please provide a valid email address.";
                header("Location: " . BASE_URL . "/index.php?page=contact");
                exit;
            }

            $mail = new PHPMailer(true);

            try {

                // SMTP SETTINGS
                $mail->isSMTP();
                $mail->Host       = MAIL_HOST;
                $mail->SMTPAuth   = true;
                $mail->Username   = MAIL_USERNAME;
                $mail->Password   = MAIL_PASSWORD;
                $mail->SMTPSecure = MAIL_ENCRYPTION;
                $mail->Port       = MAIL_PORT;

                // FROM
                $mail->setFrom(MAIL_USERNAME, 'Website Contact');

                // TO
                $mail->addAddress(MAIL_USERNAME);

                // REPLY TO USER
                $mail->addReplyTo($email, $name);

                // EMAIL CONTENT
                $mail->isHTML(true);
                $mail->Subject = 'New Contact Form Message';

                $mail->Body = "
                    <h3>New Contact Message</h3>

                    <p><strong>Name:</strong> {$name}</p>

                    <p><strong>Email:</strong> {$email}</p>

                    <p><strong>Message:</strong><br>{$message}</p>
                ";

                $mail->send();

                $_SESSION['success'] = "Message sent successfully!";

                header("Location: " . BASE_URL . "/index.php?page=contact");
                exit;

            } catch (Exception $e) {

                $_SESSION['error'] = "Mailer Error: " . $mail->ErrorInfo;

                header("Location: " . BASE_URL . "/index.php?page=contact");
                exit;
            }
        }
    }
}
