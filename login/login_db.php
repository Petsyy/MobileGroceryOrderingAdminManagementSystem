<?php
$host = "localhost";
$dbname = "inventory_db";
$username = "root"; // Default in XAMPP
$password = ""; // Leave blank if no password

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
