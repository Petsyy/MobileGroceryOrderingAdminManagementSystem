<?php
require_once 'config/db.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]));
}

header('Content-Type: application/json');

// 📌 Fetch total number of products
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getTotalProducts') {
    $sql = "SELECT COUNT(*) AS totalProducts FROM products";
    $result = $conn->query($sql);

    if ($row = $result->fetch_assoc()) {
        echo json_encode(["success" => true, "totalProducts" => (int)$row['totalProducts']]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to fetch total products"]);
    }

    $conn->close();
    exit;
}

// 📌 Fetch all products
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['action'])) {
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    $products = [];

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode(["success" => true, "products" => $products]);
    $conn->close();
    exit;
}

// 📌 Handle adding a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $image = $_POST['image'] ?? '';
    $category = $_POST['category'] ?? '';

    if (empty($name) || !is_numeric($price) || !is_numeric($stock) || empty($image) || empty($category)) {
        echo json_encode(["success" => false, "error" => "Invalid input data"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO products (name, price, stock, image, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdiss", $name, $price, $stock, $image, $category);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product added successfully"]);
    } else {
        echo json_encode(["success" => false, "error" => "Error adding product: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// 📌 Handle updating a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = $_POST['id'] ?? '';
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $category = $_POST['category'] ?? '';

    if (!is_numeric($id) || !is_numeric($price) || !is_numeric($stock) || empty($category)) {
        echo json_encode(["success" => false, "error" => "Invalid input data"]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE products SET price=?, stock=?, category=? WHERE id=?");
    $stmt->bind_param("disi", $price, $stock, $category, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product updated successfully"]);
    } else {
        echo json_encode(["success" => false, "error" => "Error updating product: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// 📌 Handle deleting a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'] ?? '';

    if (!is_numeric($id)) {
        echo json_encode(["success" => false, "error" => "Invalid product ID"]);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "error" => "Error deleting product: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

// 📌 Default response for invalid actions
echo json_encode(["success" => false, "error" => "Invalid request"]);
$conn->close();
?>
