<?php
require_once 'models/CustomOrder.php';

class ProductController {

    public function show($product) {
        // Load the corresponding view
        $file = "views/{$product}.php";
        if(file_exists($file)) {
            include $file;
        } else {
            echo "Page not found!";
        }
    }

    public function submit() {
        $data = $_POST;
        $order = new Order();
        $order->product = $data['product'] ?? 'Unknown';
        
        // Collect options dynamically
        $order->options = $data['options'] ?? [];

        // Collect customer info
        $order->customer = $data['customer'] ?? [];

        // Save and email
        $saved = $order->save();
        $emailed = $order->sendEmail();

        if($saved && $emailed) {
            echo json_encode(['status' => 'success', 'message' => 'Order submitted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong']);
        }
    }
}
