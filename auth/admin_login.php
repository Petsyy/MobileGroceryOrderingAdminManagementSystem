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
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f0f2f5;
            margin: 0;
        }

        .logo-bg{
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .login-container {
            background: #1877f2;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1), 0 0 15px rgba(24, 119, 242, 0.3);
            width: 70%;
            max-width: 700px;
        }

        .login-content {
            display: flex;
        }

        .logo-side {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .form-side {
            flex: 1;
            padding: 40px;
            background: white;
            border-radius: 0 10px 10px 0;
        }

        .logo-bg img {
            width: 120px;
            height: auto;
            border-radius: 10px;
        }

        fieldset {
            border: none;
            width: 100%;
        }

        h2 {
            font-size: 26px;
            font-weight: bold;
            color: #1877f2;
            margin-bottom: 30px;
            text-align: center;
        }

        .input-group {
            margin: 0px 0px;
            text-align: left;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
            max-width: 100%;
        }

        label {
            display: block;
            font-weight: bold;
            color: #333;
            font-size: 16px;
            width: 100%;
            margin-bottom: 5px;
        }

        input {
            width: calc(100% - 24px);
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border 0.3s ease;
            margin-bottom: 10px;
        }

        input:focus {
            outline: none;
            border-color: #1877f2;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            background: #1E204A;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
            max-width: 100%;
        }

        button:hover {
            background: #2e315e;
        }

        .error {
            color: #ff4d4d;
            font-size: 14px;
            display: block;   
            margin-top: 5px;
        }

        .forgot-password {
            display: flex;
            justify-content: flex-end;
        }

        .forgot-password a {
            color: #000000;
            font-size: 14px;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .login-link {
            margin-top: 15px;
        }

        .error { color: red; margin-bottom: 15px; }
        .success { color: green; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-content">
            <div class="logo-side">
                <div class="logo-bg">
                    <img src="../assets/images/ez-mart.svg" alt="EZ Mart Logo" style="border-radius: 30px;">
                </div>
            </div>
            <div class="form-side">
                <fieldset>
                    <h2>Log Into Dashboard</h2>
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