<?php
/**
 * Stitch Smart — Database Connection
 *
 * Reads credentials from environment variables (loaded by config.php).
 * Always require config.php before this file.
 */

class Database
{
    private string $host;
    private string $username;
    private string $password;
    private string $dbname;
    private int    $port;

    public mysqli $conn;

    public function __construct()
    {
        $this->host     = env('DB_HOST', 'localhost');
        $this->port     = (int) env('DB_PORT', 3306);
        $this->username = env('DB_USER', 'root');
        $this->password = env('DB_PASS', '');
        $this->dbname   = env('DB_NAME', 'StitchSmart');
    }

    /**
     * Open and return a mysqli connection.
     * Terminates with an error message if the connection fails.
     */
    public function connect(): mysqli
    {
        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->dbname,
            $this->port
        );

        if ($this->conn->connect_error) {
            $msg = defined('APP_DEBUG') && APP_DEBUG
                ? 'Database connection failed: ' . $this->conn->connect_error
                : 'A database error occurred. Please try again later.';
            die($msg);
        }

        $this->conn->set_charset('utf8mb4');

        return $this->conn;
    }
}