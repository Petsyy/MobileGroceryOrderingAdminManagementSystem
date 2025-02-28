<?php
require 'order/db.php';

header('Content-Type: application/json');

$query = "SELECT id, message FROM notifications WHERE status = 'unread' ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();

$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC); // ✅ Correct method for PDO

echo json_encode($notifications);
?>
