<?php
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/database.php';

try {
    $db = (new Database())->connect();
} catch (Exception $e) {
    echo "DB_CONNECT_ERROR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

$res = $db->query("SELECT * FROM user_chats ORDER BY id DESC LIMIT 5");
if ($res && $res->num_rows) {
    echo "-- user_chats --" . PHP_EOL;
    while ($r = $res->fetch_assoc()) {
        echo json_encode($r, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    }
} else {
    echo "NO_USER_CHATS" . PHP_EOL;
}

$res2 = $db->query("SELECT * FROM user_searches ORDER BY id DESC LIMIT 5");
if ($res2 && $res2->num_rows) {
    echo "-- user_searches --" . PHP_EOL;
    while ($s = $res2->fetch_assoc()) {
        echo json_encode($s, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    }
} else {
    echo "NO_USER_SEARCHES" . PHP_EOL;
}
