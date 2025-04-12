<?php
// Include database connection
require_once __DIR__ . '/config/db.php'; // Make sure the path is correct

header('Content-Type: application/json'); // Ensure response is JSON

try {
    // Check if 'customer_id' exists in the table
    $checkColumnQuery = "SHOW COLUMNS FROM orders LIKE 'customer_id'";
    $checkStmt = $conn->prepare($checkColumnQuery);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        // If 'customer_id' exists, count distinct customer IDs
        $sql = "SELECT COUNT(DISTINCT customer_id) AS total FROM orders";
    } else {
        // If 'customer_id' doesn't exist, count distinct customer names
        $sql = "SELECT COUNT(DISTINCT customer_name) AS total FROM orders";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalCustomers = $result ? (int) $result['total'] : 0;

    error_log("Total unique customers counted: " . $totalCustomers); // Log the result for debugging

    echo json_encode(["total" => $totalCustomers]); // Send JSON response
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage()); // Log database errors
    echo json_encode(["error" => $e->getMessage()]);
}
?>
