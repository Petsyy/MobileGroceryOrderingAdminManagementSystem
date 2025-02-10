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
        <img src="images/menu.svg" alt="EZ Mart Logo" class="logo" id="menuIcon">
        <span class="logo-text">EZ Mart</span>
    </header>
    

    <main class="container">
        <h1>Dashboard</h1>
        <div id="productList" class="product-list">
            <!-- Product items will be dynamically added here -->
        </div>

        <!-- Add Product Button -->
        <div class="add-product-container">
            <button id="addProductBtn">Add Product</button>
        </div>
    </main>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products/product.php">Products</a></li>
            <li><a href="#">Orders</a></li>
        </ul>
    </div>

    <!-- Modal for Adding Product -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeAddProductModal">&times;</span>
            <h2>Add Product</h2>
            <form id="productForm">
                <input type="text" id="name" placeholder="Product Name" required>
                <input type="number" id="price" placeholder="Price" required>
                <input type="text" id="image" placeholder="Image Path" required>
                <button type="submit">Add Product</button>
            </form>
        </div>
    </div>

    <!-- Include your JS file -->
    <script src="index.js"></script>
    <script src="buttons/button.js"></script>
</body>
</html>
