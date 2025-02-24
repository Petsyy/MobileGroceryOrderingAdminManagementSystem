<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_db";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}


header('Content-Type: application/json');

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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $image = $_POST['image'] ?? '';
    $category = $_POST['category'] ?? '';

    // Validate inputs
    if (empty($name) || !is_numeric($price) || !is_numeric($stock) || empty($image) || empty($category)) {
        echo json_encode(["error" => "Invalid input data"]);
        $conn->close();
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO products (name, price, stock, image, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsss", $name, $price, $stock, $image, $category);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product added successfully"]);
    } else {
        echo json_encode(["error" => "Error adding product: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Handle POST request to update a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {
    $id = $_POST['id'] ?? '';
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $category = $_POST['category'] ?? '';

    // Validate inputs
    if (!is_numeric($id) || !is_numeric($price) || !is_numeric($stock) || empty($category)) {
        echo json_encode(["error" => "Invalid input data"]);
        $conn->close();
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE products SET price=?, stock=?, category=? WHERE id=?");
    $stmt->bind_param("ddsi", $price, $stock, $category, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product updated successfully"]);
    } else {
        echo json_encode(["error" => "Error updating product: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Handle POST request to delete a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
    $id = $_POST['id'] ?? '';

    if (!is_numeric($id)) {
        echo json_encode(["error" => "Invalid product ID"]);
        $conn->close();
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product deleted successfully"]);
    } else {
        echo json_encode(["error" => "Error deleting product: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Close the connection at the end
$conn->close();
?>
