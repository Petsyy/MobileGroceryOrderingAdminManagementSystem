<?php
include("order/db.php");

header('Content-Type: application/json');

try {
    // Fetch unread notifications
    $stmt = $conn->query("SELECT id, message FROM notifications WHERE status = 'unread' ORDER BY id DESC");
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "new_orders" => count($notifications),
        "notifications" => $notifications
    ]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
