<?php
// config.php
$DB_HOST = 'localhost';
$DB_NAME = 'cakehaven';
$DB_USER = 'root';
$DB_PASS = ''; // your MySQL password if any

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
                   $DB_USER, $DB_PASS,
                   [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

function e($str) {
    return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Admin credentials (fixed hash for the admin password)
// NOTE: for production consider using an environment variable or secure secret store
$ADMIN_USER = 'cakehaven';
$ADMIN_PASS_HASH = '$2y$10$/WjqKOkRSChGCgALHeKLheXVtiiaWeXcZ7nMfHjzyKo2doMJtrfnm';
// Optional Twilio SMS settings. Leave empty to disable SMS sending.
// Get these from your Twilio console if you want SMS notifications.
$TWILIO_ACCOUNT_SID = '';
$TWILIO_AUTH_TOKEN  = '';
$TWILIO_FROM_NUMBER = ''; // e.g. '+12025551234'
?>
