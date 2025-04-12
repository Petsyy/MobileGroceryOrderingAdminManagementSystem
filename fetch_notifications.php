<?php
require_once 'config/db.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Only POST requests are allowed", 405);
    }

    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid JSON input", 400);
    }

    $conn->beginTransaction();

    if (isset($input['mark_all']) && $input['mark_all'] === true) {
        $stmt = $conn->prepare("UPDATE notifications SET status = 'read' WHERE status = 'unread'");
        $stmt->execute();
        $affected = $stmt->rowCount();
    } else {
        if (empty($input['id'])) {
            throw new Exception("Notification ID is required", 400);
        }

        $stmt = $conn->prepare("UPDATE notifications SET status = 'read' WHERE id = :id AND status = 'unread'");
        $stmt->bindParam(':id', $input['id'], PDO::PARAM_INT);
        $stmt->execute();
        $affected = $stmt->rowCount();
    }

    $conn->commit();

    echo json_encode([
        'success' => true,
        'affected_rows' => $affected,
        'action' => isset($input['mark_all']) ? 'mark_all' : 'mark_single'
    ]);

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'code' => $e->getCode()
    ]);
}
?>