<?php
require_once "db.php"; // Ensure database connection is included

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === "fetch") {
    try {
        $stmt = $conn->prepare("SELECT id, customer_name, order_details FROM orders ORDER BY id DESC");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} elseif ($action === "confirm") {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        echo json_encode(["success" => false, "error" => "Invalid or missing order ID"]);
        exit();
    }

    $id = intval($_POST['id']);

    try {
        $stmt = $conn->prepare("UPDATE orders SET status = 'Confirmed' WHERE id = ?");
        if ($stmt->execute([$id])) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to confirm order"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} elseif ($action === "delete") {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        echo json_encode(["success" => false, "error" => "Invalid or missing order ID"]);
        exit();
    }

    $id = intval($_POST['id']);

    try {
        $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
        if ($stmt->execute([$id])) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to delete order"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid action"]);
}
?>
