<?php
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (!isset($_POST['name'], $_POST['price'], $_POST['stock'], $_POST['category']) || !isset($_FILES['image'])) {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "Missing required fields"]);
        exit;
    }

    // Get form inputs
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category = trim($_POST['category']);

    // Validate input
    if (empty($name) || $price <= 0 || $stock < 0 || empty($category)) {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "Invalid input values"]);
        exit;
    }

    // File upload handling
    $uploadFolder = __DIR__ . '/../products/'; 
    if (!is_dir($uploadFolder)) {
        mkdir($uploadFolder, 0777, true);
    }

    $fileName = 'products/' . time() . '_' . basename($_FILES["image"]["name"]);
    $targetFilePath = $uploadFolder . time() . '_' . basename($_FILES["image"]["name"]);
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Allowed file types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileType, $allowedTypes)) {
        http_response_code(400);
        echo json_encode(["success" => false, "error" => "Invalid file type. Allowed types: JPG, JPEG, PNG, GIF"]);
        exit;
    }

    // Move uploaded file to the target directory
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "Failed to upload image"]);
        exit;
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO products (name, price, stock, image, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdiss", $name, $price, $stock, $fileName, $category); // Store "products/image.jpg"

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product added successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "Database error"]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
}
?>