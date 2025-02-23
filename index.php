<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EZ Mart</title>
    
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="buttons/button.css">
    <link rel="stylesheet" href="user-profile/user.css">
    <link rel="stylesheet" href="notification-bell/notification.css">
    
    <!-- Include jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<header class="header">
    <div class="logo-container">
        <img src="./images/ez-mart.svg" alt="EZ Mart Logo" class="ez_logo" id="ezLogo" style="width: 60px;">
        <span class="logo-text"> Mart</span>
    </div>
    <div class="header-right">
        <div class="user-container" id="userContainer">
            <img src="./images/user-profile.png" alt="user-profile" class="user-profile" id="userProfile">
            <i class="fa-solid fa-caret-down dropdown-icon" id="dropdownIcon"></i>
            <div class="user-dropdown" id="userDropdown">
                <ul>
                    <li><a href="#"><i class="fa-solid fa-user"></i> Edit Profile</a></li>
                    <li><a href="#"><i class="fa-solid fa-gear"></i> Settings</a></li>
                    <li><a href="login/login.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </div>
        </div>

        <div class="notification-bell" onclick="toggleNotifications()">
            <i class="fas fa-bell"></i>
            <div class="badge" id="badge">3</div>
        </div>
    </div>

    <div class="notifications" id="notifications">
        <div class="notification-item">New message from John</div>
        <div class="notification-item">Your order has been shipped</div>
        <div class="notification-item">New comment on your post</div>
    </div>
</header>

    <main class="container">
        <h1>Dashboard</h1>

    <!-- Counter Container -->
    <div class="counter-container">
        
        <!-- Total Products Count -->
        <div class="product-counter">
            <label>Total Products:</label>
            <span id="totalProductCount">0</span>
        </div>

        <!-- Order-Counter -->
        <div class="order-counter">
            <label>Total Order:</label>
            <span id="totalOrderCount">0</span>
        </div>

        <!-- Recent Counter -->
        <div class="recent-counter">
            <label>Recent Order:</label>
            <span id="totalRecentCount">0</span>
        </div>
    </div>

    <div id="productList" class="product-list">
        <!-- Product items will be dynamically added here -->
    </div>
</main>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products/product.php">Products</a></li>
            <li><a href="order/order.php">Orders</a></li>
            <li><a href="login/login.php">Log out</a></li>
        </ul>
    </div>
    <!-- Include your JS file -->
    <script src="buttons/button.js"></script>
    <script src="index.js"></script>
    <script src="user-profile/user.js"></script>
    <script src="notification-bell/notification.js"></script>
</body>
</html>