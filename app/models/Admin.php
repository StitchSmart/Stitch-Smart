<?php
require_once __DIR__ . '/../../config/database.php';

class Admin {
    private $conn;

    public function __construct($database) {
        $this->conn = $database->connect(); // mysqli connection
    }

    public function checkLogin($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        // Plain text password check
        if ($admin && $password === $admin['password']) {
            return $admin; // login success
        }

        return false; // login failed
    }

    public function getAdminByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows >= 1) {
            return $result->fetch_assoc();
        }
        return false;
    }

    public function updatePassword($email, $newPassword) {
        $stmt = $this->conn->prepare("UPDATE admin SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE email = ?");
        $stmt->bind_param("ss", $newPassword, $email);
        return $stmt->execute();
    }

    public function updateResetToken($email, $token, $expiry) {
        $stmt = $this->conn->prepare("UPDATE admin SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
        $stmt->bind_param("sis", $token, $expiry, $email);
        return $stmt->execute();
    }

    public function getAdminByResetToken($token) {
        $stmt = $this->conn->prepare("SELECT * FROM admin WHERE reset_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows >= 1) {
            return $result->fetch_assoc();
        }
        return false;
    }
}