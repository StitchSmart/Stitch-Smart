<?php
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/database.php';
try {
    $db = (new Database())->connect();
} catch (Exception $e) {
    echo "DB_CONNECT_ERROR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
$userId = 4042;
$u = $db->prepare("INSERT INTO user_chats (user_id, role, message) VALUES (?, 'user', ?)");
$b = $db->prepare("INSERT INTO user_chats (user_id, role, message) VALUES (?, 'bot', ?)");
if ($u && $b) {
    $msg1 = 'Test user message at ' . date('Y-m-d H:i:s');
    $msg2 = 'Test bot reply at ' . date('Y-m-d H:i:s');
    $u->bind_param('is', $userId, $msg1);
    $b->bind_param('is', $userId, $msg2);
    $u->execute();
    $b->execute();
    echo "Inserted test chat\n";
} else {
    echo "Prepare failed" . PHP_EOL;
}
