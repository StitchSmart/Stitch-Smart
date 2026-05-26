<?php
class ApiService {

    private $chatbotUrl;
    private $similarProductsUrl;
    private $syncProductsUrl;

    public function __construct() {
        // endpoints - Python chatbot on port 8000 (FastAPI)
        $this->chatbotUrl = "http://127.0.0.1:8000/chat-simple"; 
        $this->similarProductsUrl = "http://127.0.0.1:8000/similar-products";
        $this->syncProductsUrl = "http://127.0.0.1:8000/sync-products";
    }

    // POST to Chatbot endpoint
    public function sendMessageToChatbot($userMessage, $sessionId = 'default') {
        $data = [
            'query' => $userMessage,
            'session_id' => $sessionId,
            'user_id' => 'web_user',
            'base_url' => BASE_URL
        ];
        return $this->postRequest($this->chatbotUrl, $data);
    }

    // POST to Similar Products endpoint
    public function getSimilarProducts($productId) {
        $data = ['product_id' => (string)$productId];
        return $this->postRequest($this->similarProductsUrl, $data);
    }

    // Sync all products to chatbot FAISS index automatically
    public static function syncProduct($unused = null) {
        // Load all products from DB
        require_once BASE_PATH . '/config/database.php';
        require_once BASE_PATH . '/app/models/Product.php';

        $database = new Database();
        $db = $database->connect();
        $productModel = new Product($db);
        $products = $productModel->getAllProductsForAI();

        if (empty($products)) return;

        // Push to Python chatbot /sync-products endpoint
        $ch = curl_init("http://127.0.0.1:5000/sync-products");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['products' => $products]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_exec($ch); // fire and forget — don't block admin on chatbot errors
        curl_close($ch);
    }

    // Generic POST function
    private function postRequest($url, $data) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);
        if(curl_errno($ch)){
            $error = curl_error($ch);
            curl_close($ch);
            return ['error' => $error];
        }
        curl_close($ch);
        return json_decode($response, true);
    }
}
?>