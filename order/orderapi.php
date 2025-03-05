<?php
require_once "db.php"; // Ensure database connection is included

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === "fetch") {
    try {
        $stmt = $conn->prepare("
            SELECT 
                o.id AS order_id, 
                o.customer_name, 
                o.order_details, 
                o.total_price AS order_total_price, 
                o.status,
                COALESCE(o.created_at, 'N/A') AS order_created_at
            FROM orders o
            ORDER BY o.id DESC
        ");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}


// ✅ Check for new orders (Real-time Notification)
elseif ($action === "check_new_orders") {
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) AS new_orders FROM orders WHERE status = 'Pending'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(["new_orders" => $row['new_orders']]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}

elseif ($action === "confirm") {
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
}

elseif ($action === "delete") {
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
} 

elseif ($action === "most_selling_product") {
    try {
        $stmt = $conn->prepare("
            SELECT product_name, SUM(quantity) AS total_sold 
            FROM orders 
            GROUP BY product_name 
            ORDER BY total_sold DESC 
            LIMIT 1
        ");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo json_encode(["product_name" => $row['product_name'], "total_sold" => $row['total_sold']]);
        } else {
            echo json_encode(["product_name" => "No Data", "total_sold" => 0]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}

elseif ($action === "most_sold_product") {
    try {
        $stmt = $conn->prepare("
            SELECT 
                TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(product_list.product_name, ':', 1), ',', -1)) AS product_name,
                COUNT(*) AS total_sold
            FROM (
                SELECT 
                    TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(od.order_details, ',', n.n), ',', -1)) AS product_name
                FROM orders od
                JOIN (
                    SELECT 1 AS n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 
                    UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10
                ) n ON CHAR_LENGTH(od.order_details) - CHAR_LENGTH(REPLACE(od.order_details, ',', '')) >= n.n - 1
            ) product_list
            GROUP BY product_name
            ORDER BY total_sold DESC
            LIMIT 5;
        ");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($products);
        exit();
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}


else {
    echo json_encode(["success" => false, "error" => "Invalid action"]);
}
?>
