<?php
require_once "db.php"; // Ensure database connection is included

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === "fetch") {
    try {
        $stmt = $conn->prepare("SELECT id, customer_name, order_details, status FROM orders ORDER BY id DESC");
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
} elseif ($action === "getOrderStats") {
    // 📌 Get order count per status (Pending, Confirmed, etc.)
    try {
        $stmt = $conn->prepare("SELECT status, COUNT(*) AS total_orders FROM orders GROUP BY status");
        $stmt->execute();
        
        $data = ["labels" => [], "values" => []];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data['labels'][] = $row['status']; // Status: Pending, Confirmed
            $data['values'][] = $row['total_orders']; // Order count
        }

        echo json_encode($data);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} elseif ($action === "customerOrderStats") {
    // 📌 Get total orders per customer
    try {
        $stmt = $conn->prepare("SELECT customer_name, COUNT(*) AS total_orders FROM orders GROUP BY customer_name ORDER BY total_orders DESC");
        $stmt->execute();

        $data = ["labels" => [], "values" => []];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data['labels'][] = $row['customer_name'];
            $data['values'][] = $row['total_orders'];
        }

        echo json_encode($data);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} elseif ($action === "getTotalOrders") {
    // 📌 Get total number of orders
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total_orders FROM orders");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row); // Returns { "total_orders": 100 }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} elseif ($action === "getTotalProducts") {
    // 📌 Get total number of products
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total_products FROM products");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row); // Returns { "total_products": 50 }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid action"]);
}

// Assuming you have an order insertion process somewhere in orderapi.php
if ($action === "place_order") { 
    $customer_name = $_POST['customer_name'] ?? '';
    $order_details = $_POST['order_details'] ?? '';

    try {
        // Insert order into orders table
        $stmt = $conn->prepare("INSERT INTO orders (customer_name, order_details, status) VALUES (?, ?, 'Pending')");
        $stmt->execute([$customer_name, $order_details]);

        // Get the last inserted order ID
        $order_id = $conn->lastInsertId();

        // Insert a notification
        $notif_stmt = $conn->prepare("INSERT INTO notifications (message, status) VALUES (?, 'unread')");
        $notif_stmt->execute(["New order received from $customer_name"]);

        echo json_encode(["success" => true, "order_id" => $order_id]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}
if ($action === "place_order") { 
    $customer_name = $_POST['customer_name'] ?? '';
    $order_details = $_POST['order_details'] ?? '';

    try {
        // Insert the new order
$stmt = $conn->prepare("INSERT INTO orders (customer_name, order_details, status) VALUES (?, ?, 'Pending')");
$stmt->execute([$customer_name, $order_details]);

// 📌 Insert a new notification when an order is placed
$stmt = $conn->prepare("INSERT INTO notifications (message, status, created_at) VALUES (?, 'unread', NOW())");
$stmt->execute(["New order received from $customer_name!"]);


        // Get last inserted order ID
        $order_id = $conn->lastInsertId();

        // Insert notification
        $notif_stmt = $conn->prepare("INSERT INTO notifications (message, status) VALUES (?, 'unread')");
        $notif_stmt->execute(["New order received from $customer_name"]);

        $stmt = $conn->prepare("INSERT INTO notifications (message, status, created_at) VALUES (?, 'unread', NOW())");
        $stmt->execute(["New order received!"]);


        echo json_encode(["success" => true, "order_id" => $order_id]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}


?>
