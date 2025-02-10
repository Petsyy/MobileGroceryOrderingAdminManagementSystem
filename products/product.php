<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - EZ Mart</title>
    
    <!-- Link to CSS files -->
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../buttons/button.css">
    
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <!-- Header (same as index.php) -->
    <header class="header">
        <img src="../images/menu.svg" alt="EZ Mart Logo" class="logo" id="menuIcon">
        <span class="logo-text">EZ Mart</span>
    </header>

    <!-- Sidebar (same as index.php) -->
    <div id="sidebar" class="sidebar">
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="product.php">Products</a></li>
            <li><a href="#">Orders</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <main class="container">
        <h1>Product Section</h1>
        <div id="productList" class="product-list">
            <!-- Products will be displayed here -->
        </div>
    </main>

    <!-- Include index.js -->
    <script src="../index.js"></script>
    <script src="../buttons/button.js"></script>
</body>
</html>
