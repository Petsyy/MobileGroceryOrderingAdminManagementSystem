<?php
require_once __DIR__ . '/../config/db.php';  

function cancelOrder($conn, $orderId) {  
    // Prepare the SQL query to update the order status to 'Cancelled'
    $query = "UPDATE orders SET status = 'Cancelled' WHERE id = :orderId";
    
    try {
        // Prepare the statement using PDO
        $stmt = $conn->prepare($query);

        // Bind the parameter to the order ID
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Check if any row was updated
        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "Order has been successfully cancelled."]);
        } else {
            echo json_encode(["success" => false, "message" => "Order not found or already cancelled."]);
        }
    } catch (PDOException $e) {
        // Handle database-specific errors
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    } catch (Exception $e) {
        // Handle general errors (e.g., query preparation issues)
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
}

// Example usage: Call the function with an order ID to cancel the order
if (isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    cancelOrder($conn, $orderId);  
} else {
    echo json_encode(["success" => false, "message" => "Order ID is required."]);
}
?>
