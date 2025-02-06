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

// Set response content type to JSON
header('Content-Type: application/json');

// Handle GET request to fetch products
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    $products = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    echo json_encode($products);
    $conn->close();
    exit;
}

// Handle POST request to add a product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $image = $_POST['image'] ?? '';

    // Validate inputs
    if (empty($name) || !is_numeric($price) || !is_numeric($stock) || empty($image)) {
        echo json_encode(["error" => "Invalid input data"]);
        $conn->close();
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO products (name, price, stock, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $stock, $image);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Product added successfully"]);
    } else {
        echo json_encode(["error" => "Error adding product: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Handle PUT request to update a product
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    if (!isset($_PUT['id'], $_PUT['price'], $_PUT['stock'])) {
        echo json_encode(["error" => "Missing parameters"]);
        $conn->close();
        exit;
    }

    $id = $_PUT['id'];
    $price = $_PUT['price'];
    $stock = $_PUT['stock'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE products SET price=?, stock=? WHERE id=?");
    $stmt->bind_param("ddi", $price, $stock, $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Product updated successfully"]);
    } else {
        echo json_encode(["error" => "Error updating product: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Handle DELETE request to delete a product
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (!isset($_DELETE['id'])) {
        echo json_encode(["error" => "Missing product ID"]);
        $conn->close();
        exit;
    }

    $id = $_DELETE['id'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Product deleted successfully"]);
    } else {
        echo json_encode(["error" => "Error deleting product: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

$conn->close();
?>