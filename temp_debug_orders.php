<?php
require 'config/config.php';
require 'config/database.php';
$db = (new Database())->connect();
$res = $db->query('SHOW COLUMNS FROM orders');
while ($row = $res->fetch_assoc()) {
    echo $row['Field'] . "\t" . $row['Type'] . "\n";
}
