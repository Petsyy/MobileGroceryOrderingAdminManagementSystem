<?php
require 'order/db.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $query = "SELECT id, message FROM notifications WHERE status = 'unread' ORDER BY created_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC); // ✅ Correct method for PDO

    echo json_encode($notifications);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
