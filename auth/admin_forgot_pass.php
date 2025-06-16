<?php
session_start();
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
    <title>Admin Forgot Password</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <style>
        .error {
            color: red;
            margin-bottom: 15px;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <fieldset>
            <legend>Forgot Password?</legend>
            <p>Enter your registered email address to reset your password.</p>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>
            <form action="admin_send_otp.php" method="post">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" placeholder="Enter your email" name="email" id="email" required>
                </div>
                <button type="submit">Send OTP</button>
            </form>
        </fieldset>
    </div>
</body>

</html>