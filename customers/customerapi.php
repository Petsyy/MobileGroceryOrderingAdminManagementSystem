<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

header('Content-Type: application/json');

// Fetch all customers (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM customers";
    $result = $conn->query($sql);
    $customers = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
    }
    echo json_encode($customers);
    $conn->close();
    exit;
}

// Add a new customer (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
    $name = $_POST['name'] ?? '';
    $product = $_POST['product'] ?? '';
    $total_price = $_POST['total_price'] ?? '';

    if (empty($name) || empty($product) || !is_numeric($total_price)) {
        echo json_encode(["error" => "Invalid input data"]);
        $conn->close();
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO customers (name, product, total_price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $name, $product, $total_price);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Customer added successfully"]);
    } else {
        echo json_encode(["error" => "Error adding customer: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Update a customer (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {
    $id = $_POST['id'] ?? '';
    $product = $_POST['product'] ?? '';
    $total_price = $_POST['total_price'] ?? '';

    if (!is_numeric($id) || empty($product) || !is_numeric($total_price)) {
        echo json_encode(["error" => "Invalid input data"]);
        $conn->close();
        exit;
    }

    $stmt = $conn->prepare("UPDATE customers SET product=?, total_price=? WHERE id=?");
    $stmt->bind_param("sdi", $product, $total_price, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Customer updated successfully"]);
    } else {
        echo json_encode(["error" => "Error updating customer: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Delete a customer (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
    $id = $_POST['id'] ?? '';

    if (!is_numeric($id)) {
        echo json_encode(["error" => "Invalid customer ID"]);
        $conn->close();
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM customers WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Customer deleted successfully"]);
    } else {
        echo json_encode(["error" => "Error deleting customer: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Close the connection at the end
$conn->close();
?>
