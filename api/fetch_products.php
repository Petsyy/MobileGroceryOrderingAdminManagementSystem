<?php
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$server_url = "http://192.168.100.15/EZMartOrderingSystem/";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $category = isset($_GET['category']) ? trim($_GET['category']) : null;

    if ($category) {
        $stmt = $conn->prepare("SELECT id, name, price, stock, CONCAT(?, image) AS image, category FROM products WHERE LOWER(category) = LOWER(?) ORDER BY name ASC");
        $stmt->bind_param("ss", $server_url, $category);
    } else {
        $stmt = $conn->prepare("SELECT id, name, price, stock, CONCAT(?, image) AS image, category FROM products ORDER BY name ASC");
        $stmt->bind_param("s", $server_url);
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        echo json_encode(["success" => true, "products" => $products]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to fetch products"]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $action = $data['action'] ?? '';

    if ($action === 'add') {
        if (!empty($data['name']) && isset($data['price'], $data['stock'], $data['image'], $data['category'])) {
            $stmt = $conn->prepare("INSERT INTO products (name, price, stock, image, category) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sdiss", $data['name'], $data['price'], $data['stock'], $data['image'], $data['category']);
            echo json_encode(["success" => $stmt->execute()]);
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => "Missing required fields"]);
        }
        exit;
    }

    if ($action === 'update') {
        if (isset($data['id'], $data['price'], $data['stock'], $data['category'])) {
            $stmt = $conn->prepare("UPDATE products SET price = ?, stock = ?, category = ? WHERE id = ?");
            $stmt->bind_param("dssi", $data['price'], $data['stock'], $data['category'], $data['id']);
            echo json_encode(["success" => $stmt->execute()]);
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => "Missing required fields for update"]);
        }
        exit;
    }

    if ($action === 'delete') {
        if (isset($data['id'])) {
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $data['id']);
            echo json_encode(["success" => $stmt->execute()]);
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => "Missing product ID"]);
        }
        exit;
    }

    echo json_encode(["success" => false, "error" => "Invalid action"]);
    exit;
}

http_response_code(400);
echo json_encode(["success" => false, "error" => "Invalid request"]);
