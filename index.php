<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EZ Mart</title>
    
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="user-profile/user.css">
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header class="header">
        <img src="./images/ez-mart.svg" alt="EZ Mart Logo" class="ez_logo" id="ezLogo" style="width: 60px; margin-left: 10px;">
        <span class="logo-text">Mart</span>
    </header>

    <main class="container">
        <h1>Dashboard</h1>

        <!-- Total Products Count -->
        <div class="product-counter">
            <label>Total Products:</label>
            <span id="totalProductCount">0</span>
        </div>
    
        <!-- Order Counter -->
        <div class="order-counter">
            <label>Total Orders:</label>
            <span id="totalOrderCount">0</span>
        </div>

        <div id="productList" class="product-list"></div>
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
    
    <script src="index.js"></script>
    <script src="user-profile/user.js"></script>
</body>
</html>
