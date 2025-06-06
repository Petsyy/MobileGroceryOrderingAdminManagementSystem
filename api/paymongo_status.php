<?php

// PayMongo API Configuration
$server_url = "http://192.168.100.15/EZMartOrderingSystem";
$paymongoApiUrl = "https://api.paymongo.com/v1/checkout_sessions";
$paymongoApiKey = "sk_test_EbvCZMXi6ARpJuYgK4Z8ZgNh";

// Get Request Payload
$payload = file_get_contents("php://input");
$data = json_decode($payload, true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON format']);
    exit;
}

// Extract & Sanitize Inputs
$customer_name = filter_var($data['customer_name'] ?? '', FILTER_SANITIZE_STRING);
$user_id = filter_var($data['user_id'] ?? '', FILTER_SANITIZE_STRING);
$order_id = filter_var($data['order_id'] ?? '', FILTER_SANITIZE_STRING);
$payment_method = filter_var($data['payment_method'] ?? '', FILTER_SANITIZE_STRING);
$fcm_token = filter_var($data['fcm_token'] ?? '', FILTER_SANITIZE_STRING);
$total_price = isset($data['total_price']) ? floatval($data['total_price']) : 0;

if (empty($customer_name) || empty($user_id) || empty($order_id) || empty($payment_method) || $total_price <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Validate Payment Method (Case-insensitive)
$valid_payment_methods = ["gcash", "paymaya"];
if (!in_array(strtolower($payment_method), $valid_payment_methods)) {
    echo json_encode(['success' => false, 'message' => 'Invalid payment method']);
    exit;
}

// Load Database Connection (PDO)
require_once __DIR__ . '/../config/db.php';

try {
    // Get Order Details
    $stmt = $conn->prepare("SELECT order_details FROM orders WHERE id=:order_id");
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo json_encode(['success' => false, 'message' => 'Order not found']);
        exit;
    }

    $order_details = $order['order_details'] ?? 'No details available';

    // Set Payment Amount (Full Price Only)
    $amountToPayCents = intval($total_price * 100);

    // Set Payment Method Dynamically (only include the selected one)
    $payment_method_types = [];
    if (strtolower($payment_method) == "paymaya") {
        $payment_method_types = ["paymaya"];
    } elseif (strtolower($payment_method) == "gcash") {
        $payment_method_types = ["gcash"];
    }

    // Create Payment Request for PayMongo
    $requestData = [
        "data" => [
            "attributes" => [
                "line_items" => [
                    [
                        "currency" => "PHP",
                        "amount" => $amountToPayCents,
                        "name" => "Order Payment",
                        "quantity" => 1
                    ]
                ],
                "payment_method_types" => $payment_method_types, // Use the selected payment method
                "send_email_receipt" => true,
                "show_description" => true,
                "description" => "Payment for Order #$order_id\n$order_details",
                "success_url" => "$server_url/api/payment_success.php?order_id=$order_id&payment_method=$payment_method",
                "cancel_url" => "$server_url/api/payment_failed.php",
                "metadata" => [
                    "customer_name" => $customer_name,
                    "order_id" => $order_id,
                    "user_id" => $user_id,
                    "payment_method" => $payment_method,
                    "fcm_token" => $fcm_token
                ]
            ]
        ]
    ];

    // Send Request to PayMongo
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $paymongoApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . base64_encode($paymongoApiKey . ':'),
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo json_encode(['success' => false, 'message' => 'Error connecting to PayMongo API: ' . curl_error($ch)]);
        curl_close($ch);
        exit;
    }
    curl_close($ch);

    $responseData = json_decode($response, true);

    // Check PayMongo Response & Provide Checkout URL
    if (isset($responseData['data']['attributes']['checkout_url'])) {
        $checkoutUrl = $responseData['data']['attributes']['checkout_url'];
        echo json_encode([
            'success' => true,
            'checkoutUrl' => $checkoutUrl,
            'order_id' => $order_id,
            'payment_method' => $payment_method
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to create checkout session'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

$conn = null; // Close connection
?>
