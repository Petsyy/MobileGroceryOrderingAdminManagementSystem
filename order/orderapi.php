<?php
require_once "../config/db.php"; // Ensure database connection is included

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === "fetch") {
    try {
        // Fetch orders along with customer details
        $stmt = $conn->prepare("
            SELECT 
                o.id AS order_id, 
                o.customer_name, 
                o.order_details, 
                o.total_price AS order_total_price, 
                o.status, 
                o.created_at AS order_created_at,
                c.product AS customer_product, 
                c.total_price AS customer_total_price
            FROM orders o
            JOIN customers c ON o.customer_name = c.name
            ORDER BY o.created_at DESC
        ");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results);
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
} elseif ($action === "place_order") { 
    $customer_name = $_POST['customer_name'] ?? '';
    $order_details = $_POST['order_details'] ?? '';
    $total_price = $_POST['total_price'] ?? 0;

    // Validate input data
    if (empty($customer_name) || empty($order_details) || !is_numeric($total_price)) {
        echo json_encode(["success" => false, "error" => "Invalid input data"]);
        exit();
    }

    try {
        // Insert the new order
        $stmt = $conn->prepare("INSERT INTO orders (customer_name, order_details, total_price, status, created_at) VALUES (?, ?, ?, 'Pending', NOW())");
        $stmt->execute([$customer_name, $order_details, $total_price]);

        // Insert a notification
        $notif_stmt = $conn->prepare("INSERT INTO notifications (message, status, created_at) VALUES (?, 'unread', NOW())");
        $notif_stmt->execute(["New order received from $customer_name"]);

        echo json_encode(["success" => true, "order_id" => $conn->lastInsertId()]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} elseif ($action === "fetchSingleOrder") {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo json_encode(["success" => false, "error" => "Invalid or missing order ID"]);
        exit();
    }

    $id = intval($_GET['id']);

    try {
        $stmt = $conn->prepare("
            SELECT 
                o.id AS order_id, 
                o.customer_name, 
                o.order_details, 
                o.total_price AS order_total_price, 
                o.status, 
                o.created_at AS order_created_at,
                c.product AS customer_product, 
                c.total_price AS customer_total_price
            FROM orders o
            JOIN customers c ON o.customer_name = c.name
            WHERE o.id = ?
        ");
        $stmt->execute([$id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            echo json_encode($order);
        } else {
            echo json_encode(["success" => false, "error" => "Order not found"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} elseif ($action === "updateOrder") {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        echo json_encode(["success" => false, "error" => "Invalid or missing order ID"]);
        exit();
    }

    $id = intval($_POST['id']);
    $customer_name = $_POST['customer_name'] ?? '';
    $order_details = $_POST['order_details'] ?? '';
    $total_price = $_POST['total_price'] ?? 0;
    $status = $_POST['status'] ?? 'Pending';

    try {
        $stmt = $conn->prepare("UPDATE orders SET customer_name = ?, order_details = ?, total_price = ?, status = ? WHERE id = ?");
        if ($stmt->execute([$customer_name, $order_details, $total_price, $status, $id])) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to update order"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid action"]);
}
?>