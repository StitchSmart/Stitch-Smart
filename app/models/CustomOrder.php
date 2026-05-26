<?php
class Order {
    public $product;
    public $options = [];
    public $customer = [];

    public function save() {
        // Save to DB if needed (optional)
        // Example: return true;
        return true;
    }

    public function sendEmail() {
        $to = "aleeshahali835@gmail.com";
        $subject = "New Order: " . $this->product;
        $message = "Product: " . $this->product . "\n\nOptions:\n";
        foreach($this->options as $key => $value) {
            $message .= "$key: $value\n";
        }
        $message .= "\nCustomer Info:\n";
        foreach($this->customer as $key => $value) {
            $message .= "$key: $value\n";
        }

        $headers = "From: " . ($this->customer['email'] ?? 'noreply@example.com');
        return mail($to, $subject, $message, $headers);
    }
}