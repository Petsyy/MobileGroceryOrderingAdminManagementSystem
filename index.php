<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EZ Mart</title>
    
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="buttons/button.css">
    
    <!-- Include jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <header class="header">
        <img src="images/menu.svg" alt="menu-icon" id="menuIcon">
        <img src="./images/ez-mart.svg" alt="EZ Mart Logo" class="ez_logo" id="ezLogo" style="width: 60px; margin-left: 10px; ">
        <span class="logo-text"> Mart</span>
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
</body>
</html>