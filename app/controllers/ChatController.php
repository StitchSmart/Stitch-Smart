<?php
require_once BASE_PATH.'/app/services/ApiService.php';
require_once BASE_PATH.'/config/database.php';

class ChatController {
    private $apiService;

    public function __construct() {
        $this->apiService = new ApiService();
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Called by AJAX when user sends a message
    public function send() {
        header('Content-Type: application/json');
        
        $userMessage = $_POST['message'] ?? '';
        if(!$userMessage) {
            echo json_encode(['response' => 'Please type a message.']);
            return;
        }

        $sessionId = session_id() ?: 'default';
        $response = $this->apiService->sendMessageToChatbot($userMessage, $sessionId);
        
        if(isset($response['error'])) {
            echo json_encode(['response' => 'Sorry, the assistant is currently unavailable. Please try again later.']);
            return;
        }
        
        echo json_encode(['response' => $response['response'] ?? 'No response received.']);
    }

    // Called by AJAX when user clicks a product
    public function similarProducts() {
        header('Content-Type: application/json');
        
        $productId = $_POST['product_id'] ?? 0;
        if(!$productId) {
            echo json_encode(['error' => 'Product ID missing']);
            return;
        }

        $response = $this->apiService->getSimilarProducts($productId);
        echo json_encode($response);
    }

    private function ensureHistoryTables()
    {
        // create user_chats if missing
        $res = $this->conn->query("SHOW TABLES LIKE 'user_chats'");
        if ($res && $res->num_rows === 0) {
            $this->conn->query("CREATE TABLE user_chats (
                id INT(11) NOT NULL AUTO_INCREMENT,
                user_id INT(11) NOT NULL,
                role VARCHAR(10) NOT NULL,
                message TEXT NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY(id),
                KEY user_id_idx (user_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        $res2 = $this->conn->query("SHOW TABLES LIKE 'user_searches'");
        if ($res2 && $res2->num_rows === 0) {
            $this->conn->query("CREATE TABLE user_searches (
                id INT(11) NOT NULL AUTO_INCREMENT,
                user_id INT(11) NOT NULL,
                query VARCHAR(255) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY(id),
                KEY user_id_idx (user_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }
    }

    // Save a chat message (role: 'user'|'bot') — only for logged-in users
    public function saveChat()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['customer_id'] ?? null;
        if (!$userId) {
            echo json_encode(['error' => 'Not logged in']);
            return;
        }

        $role = $_POST['role'] ?? 'user';
        $message = trim($_POST['message'] ?? '');
        if ($message === '') {
            echo json_encode(['error' => 'Empty message']);
            return;
        }

        $this->ensureHistoryTables();

        $stmt = $this->conn->prepare("INSERT INTO user_chats (user_id, role, message) VALUES (?, ?, ?)");
        if ($stmt === false) {
            echo json_encode(['error' => 'DB prepare failed']);
            return;
        }
        $stmt->bind_param('iss', $userId, $role, $message);
        $ok = $stmt->execute();
        if ($ok) echo json_encode(['success' => true]);
        else echo json_encode(['error' => 'DB insert failed']);
    }

    // Get recent chat history for logged-in user
    public function getChatHistory()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['customer_id'] ?? null;
        if (!$userId) { echo json_encode(['messages' => []]); return; }

        $this->ensureHistoryTables();

        $limit = 50;
        $stmt = $this->conn->prepare("SELECT role, message, created_at FROM user_chats WHERE user_id = ? ORDER BY id DESC LIMIT ?");
        if ($stmt === false) { echo json_encode(['messages' => []]); return; }
        $stmt->bind_param('ii', $userId, $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        $messages = [];
        while ($row = $res->fetch_assoc()) {
            $messages[] = $row;
        }
        // return in chronological order
        $messages = array_reverse($messages);
        echo json_encode(['messages' => $messages]);
    }

    // Save search query for logged-in user
    public function saveSearch()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['customer_id'] ?? null;
        if (!$userId) { echo json_encode(['error' => 'Not logged in']); return; }

        $query = trim($_POST['query'] ?? '');
        if ($query === '') { echo json_encode(['error' => 'Empty query']); return; }

        $this->ensureHistoryTables();

        $stmt = $this->conn->prepare("INSERT INTO user_searches (user_id, query) VALUES (?, ?)");
        if ($stmt === false) { echo json_encode(['error' => 'DB prepare failed']); return; }
        $stmt->bind_param('is', $userId, $query);
        $ok = $stmt->execute();
        if ($ok) echo json_encode(['success' => true]); else echo json_encode(['error' => 'DB insert failed']);
    }

    // Get recent searches for logged-in user
    public function getSearchHistory()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['customer_id'] ?? null;
        if (!$userId) { echo json_encode(['searches' => []]); return; }

        $this->ensureHistoryTables();

        $limit = 20;
        $stmt = $this->conn->prepare("SELECT query, created_at FROM user_searches WHERE user_id = ? ORDER BY id DESC LIMIT ?");
        if ($stmt === false) { echo json_encode(['searches' => []]); return; }
        $stmt->bind_param('ii', $userId, $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        $searches = [];
        while ($row = $res->fetch_assoc()) $searches[] = $row;
        echo json_encode(['searches' => $searches]);
    }
}
?>
