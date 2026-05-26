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
$stmt = $db->prepare("DELETE FROM user_chats WHERE user_id = ? AND (message LIKE 'Test user message at %' OR message LIKE 'Test bot reply at %')");
if (!$stmt) {
    echo "Prepare failed: " . $db->error . PHP_EOL;
    exit(1);
}
$stmt->bind_param('i', $userId);
$stmt->execute();
$affected = $stmt->affected_rows;
echo "Deleted $affected test chat row(s) for user_id=$userId" . PHP_EOL;
