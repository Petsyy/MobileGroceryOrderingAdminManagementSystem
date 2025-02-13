<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Hardcoded credentials
    $valid_username = "admin";
    $valid_password = "admin123";

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['user'] = $username;
        header("Location: ../index.php"); // Redirect to dashboard
        exit; // Stop script execution
    } else {
        header("Location: ../login.php?error=Invalid username or password");
        exit; // Stop script execution
    }
}
?>
