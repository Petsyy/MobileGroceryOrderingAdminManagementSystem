<?php
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$inputJSON = file_get_contents("php://input");
$input = json_decode($inputJSON, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    exit;
}

$firstName = trim($input['first_name'] ?? '');
$lastName = trim($input['last_name'] ?? '');
$email = trim($input['email'] ?? '');
$password = trim($input['password'] ?? '');
$confirmPassword = trim($input['confirm_password'] ?? '');
$gender = trim($input['gender'] ?? '');
$birthdate = trim($input['birthdate'] ?? '');
$contact = trim($input['contact'] ?? '');
$address = trim($input['address'] ?? '');

// Validate input fields
if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword) || empty($contact)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

if ($password !== $confirmPassword) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT id FROM users_mobile WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'Email already exists.']);
        exit;
    }
    
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("
        INSERT INTO users_mobile (first_name, last_name, email, password, contact, gender, birthdate, address)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$firstName, $lastName, $email, $hashedPassword, $contact, $gender, $birthdate, $address]);

    http_response_code(201);
    echo json_encode(['success' => true, 'message' => 'Registration successful!']);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Registration failed. Please try again.']);
}
?>
