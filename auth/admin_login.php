<?php
session_start();

require '../config/db.php';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : "";
unset($_SESSION['error']);

$success = isset($_SESSION['success']) ? $_SESSION['success'] : "";
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <style>
        .error { color: red; margin-bottom: 15px; }
        .success { color: green; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-content">
            <div class="logo-side">
                <div class="logo-bg">
                    <img src="../assets/images/ez-mart.svg" alt="EZ Mart Logo">
                </div>
            </div>
            <div class="form-side">
                <fieldset>
                    <h2>Log Into Dashboard</h2>
                    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
                    <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>
                    <form action="login_process.php" method="post" id="loginForm">
                        <div class="input-group">
                            <label for="username">Username</label>
                            <input type="text" placeholder="Enter Username" name="username" id="username" required>
                        </div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" placeholder="Enter Password" name="password" id="password" required>
                        </div>
                        <div class="forgot-password">
                            <a href="admin_forgot_pass.php">Forgot Password?</a>
                        </div>
                        <button type="submit">Login</button>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (username === '' || password === '') {
                e.preventDefault();
                alert('Please fill in all fields');
                return false;
            }
            return true;
        });
    </script>
</body>
</html>