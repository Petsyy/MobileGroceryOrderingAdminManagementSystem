<?php
require_once __DIR__ . '/../config/db.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["success" => false, "error" => "Unauthorized access"]);
    exit();
}

header("Content-Type: application/json");

$response = ["success" => false, "admins" => [], "error" => ""];

try {
    // Prepare and execute the statement
    $stmt = $conn->prepare("SELECT id, username, email, role, status FROM admins ORDER BY id DESC");
    $stmt->execute();

    // Fetch all results as an associative array
    $response["admins"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response["success"] = true;

} catch (Exception $e) {
    $response["error"] = "Error loading admin data: " . $e->getMessage();
}

// Close the database connection (PDO automatically manages this)
echo json_encode($response);
?>
