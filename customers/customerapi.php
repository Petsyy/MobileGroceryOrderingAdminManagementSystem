<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['customer_id'])) {
        // Fetch specific customer's transactions
        $customer_id = intval($_GET['customer_id']);
        
        if ($customer_id <= 0) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid customer ID"]);
            exit;
        }

        $sql = "SELECT * FROM orders WHERE customer_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }

        echo json_encode($transactions);
        $stmt->close();
    } else {
        // Fetch all customers
        $sql = "SELECT * FROM customers";
        $result = $conn->query($sql);
        $customers = [];

        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }

        echo json_encode($customers);
    }
}

// Close the connection
$conn->close();
?>
