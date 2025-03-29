<?php
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit;
}

// Handle OPTIONS preflight request for CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Fetch Products
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT id, name, price, stock, image, category FROM products");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "Database query failed"]);
        exit;
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $products = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

    $stmt->close();
    $conn->close();

    echo json_encode(["success" => true, "products" => $products]);
    exit;
}

// Handle Stock Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $action = $data['action'] ?? '';

    if (!isset($data['products']) || !is_array($data['products'])) {
        echo json_encode(["success" => false, "error" => "Invalid or missing product data"]);
        exit;
    }

    $response = [];
    $success = true;

    foreach ($data['products'] as $product) {
        $product_id = $product['product_id'] ?? null;
        $quantity = $product['quantity'] ?? null;

        if (!$product_id || !$quantity || $quantity <= 0) {
            $response[] = [
                "product_id" => $product_id,
                "status" => "Invalid product data"
            ];
            $success = false;
            continue;
        }

        // Check stock availability
        $checkStmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
        $checkStmt->bind_param("i", $product_id);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $row = $result->fetch_assoc();
        $checkStmt->close();

        if (!$row) {
            $response[] = [
                "product_id" => $product_id,
                "status" => "Product not found"
            ];
            $success = false;
            continue;
        }

        $current_stock = $row['stock'];

        if ($action === 'reduce_stock') {
            if ($current_stock >= $quantity) {
                $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                $stmt->bind_param("ii", $quantity, $product_id);
                if ($stmt->execute()) {
                    $response[] = [
                        "product_id" => $product_id,
                        "status" => "Stock reduced",
                        "reduced_quantity" => $quantity
                    ];
                } else {
                    $response[] = [
                        "product_id" => $product_id,
                        "status" => "Stock reduction failed"
                    ];
                    $success = false;
                }
                $stmt->close();
            } else {
                $response[] = [
                    "product_id" => $product_id,
                    "status" => "Insufficient stock"
                ];
                $success = false;
            }
        } elseif ($action === 'restore_stock') {
            $stmt = $conn->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
            $stmt->bind_param("ii", $quantity, $product_id);
            if ($stmt->execute()) {
                $response[] = [
                    "product_id" => $product_id,
                    "status" => "Stock restored",
                    "restored_quantity" => $quantity
                ];
            } else {
                $response[] = [
                    "product_id" => $product_id,
                    "status" => "Failed to restore stock"
                ];
                $success = false;
            }
            $stmt->close();
        }
    }

    echo json_encode(["success" => $success, "message" => "Stock update completed", "details" => $response]);
    exit;
}

// Invalid request method
http_response_code(400);
echo json_encode(["success" => false, "error" => "Invalid request"]);
?>
