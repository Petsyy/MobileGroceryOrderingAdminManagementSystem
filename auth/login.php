<?php
session_start();

// Check if an error exists in the session
$error = isset($_SESSION['error']) ? $_SESSION['error'] : "";
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <fieldset>
            <legend>Log Into Dashboard</legend>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            <form action="login_process.php" method="post">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" placeholder="Enter Username" name="username" id="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" placeholder="Enter Password" name="password" id="password" required>
                </div>
                <button type="submit">Login</button>
                <div class="forgot-password">
                    <a href="forgot_pass.php">Forgot Password?</a>
                </div>
            </form>
        </fieldset>
    </div>
    <div class="bilog1"></div>
    <div class="bilog2"></div>
    <div class="bilog3"></div>
    <div class="bilog4"></div> 
    <div class="bilog5"></div>
    <div class="bilog6"></div>
    <div class="bilog7"></div>
    </div>
    <script src="login.js"></script>
</body>
</html>
