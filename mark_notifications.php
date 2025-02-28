<?php
include '../order/db.php';

header('Content-Type: application/json');

try {
    $sql = "UPDATE notifications SET status = 'read' WHERE status = 'unread'";
    $conn->query($sql);
    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
