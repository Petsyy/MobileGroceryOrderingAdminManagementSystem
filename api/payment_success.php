<?php
// Load Database Connection (PDO)
require_once __DIR__ . '/../config/db.php';

// Get Order ID and Payment Method from URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';
$payment_method = isset($_GET['payment_method']) ? $_GET['payment_method'] : '';

if (empty($order_id) || empty($payment_method)) {
    echo json_encode(['success' => false, 'message' => 'Invalid order data']);
    exit;
}

try {
    // Update Order Payment Status
    $stmt = $conn->prepare("UPDATE orders SET status='Paid' WHERE id=:order_id");
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'The payment status for your order has been successfully updated to "Paid".'];
    } else {
        $response = ['success' => false, 'message' => 'We encountered an issue while updating the payment status of your order. Please try again later.'];
    }
} catch (PDOException $e) {
    $response = ['success' => false, 'message' => 'An unexpected error occurred while processing your request. Please contact support if the issue persists.'];
}

$conn = null; // Close connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status Update</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .message {
            font-size: 16px;
            text-align: center;
            padding: 20px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }

        .back-link a {
            color: #007bff;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Payment Status Update</h1>
        <div class="message <?php echo $response['success'] ? 'success' : 'error'; ?>">
            <p><?php echo $response['message']; ?></p>
        </div>
        
    </div>

</body>
</html>
