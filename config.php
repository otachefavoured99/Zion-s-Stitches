<?php
// Zion Stitches - DevOps ready config
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$dbname = getenv('DB_NAME') ?: 'zion_stitches';
$port = getenv('DB_PORT') ?: 3306;

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    // Don't die on homepage, just log
    error_log("DB Connection failed: " . $conn->connect_error);
    // $conn = null; // comment this if you want site to still load without DB
}
?>
