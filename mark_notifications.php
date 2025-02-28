<?php
include '../order/db.php';

$sql = "UPDATE notifications SET status = 'read' WHERE status = 'unread'";
$conn->query($sql);

echo json_encode(["success" => true]);
?>
