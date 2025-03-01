<?php
require 'order/db.php'; // Ensure this path is correct

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }

    // Get the request data
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['mark_all']) && $data['mark_all'] === true) {
        // Mark all notifications as read
        $query = "UPDATE notifications SET status = 'read' WHERE status = 'unread'";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        echo json_encode(["success" => true]);
    } else {
        // Mark a single notification as read
        $notificationId = $data['id'] ?? null;

        if (!$notificationId) {
            throw new Exception("Notification ID is required.");
        }

        $query = "UPDATE notifications SET status = 'read' WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $notificationId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Notification not found or already marked as read."]);
        }
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>