<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SM Hypermarket</title>
    
    <!-- Link to external CSS file (if needed) -->
    <link rel="stylesheet" href="index.css">
    
    <!-- Include jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div class="header">
        <span class="logo-text">SM</span>
        <span class="logo-subtext">Hypermarket</span>
        <img src="images/sm.png" alt="SM logo" class="logo-image">
    </div>

    <div class="container">
        <h1 class="h1">Products</h1>
        <div id="productList" class="product-list">
            <!-- Product items will be dynamically added here -->
        </div>

        <!-- Add Product Button -->
        <div class="add-product-container">
            <button id="addProductBtn">Add Product</button>
        </div>
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

</body>
</html>
