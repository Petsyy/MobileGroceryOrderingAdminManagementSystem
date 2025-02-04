<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>SM Hypermarket</title>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <span class="logo-text">SM</span>
        <span class="logo-subtext">Hypermarket</span>
        <img src="images/sm.png" alt="SM logo" class="logo-image">
    </div>

    <div class="container">
        <h1 class="h1">Products</h1>
        <div id="productList" class="product-list">
            <!-- Example Product Item -->
            <div class="product-container">
                <img src="images/product1.jpg" alt="Product 1">
                <h3>Product Name</h3>
                <p class="price">$19.99</p>
                <button class="edit-btn">Edit</button>
            </div>
            <!-- More product items will be dynamically added here -->
        </div>

        <!-- Centered Add Product Button -->
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
            <input type="text" id="image" placeholder="Image Path (e.g., images/product1.jpg)" required>
            <button type="submit">Add Product</button>
        </form>
    </div>
</div>

<!-- Modal for Editing Price and Stock -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Edit Product</h2>
        <form id="editForm">
            <div class="form-group">
                <label for="editPrice">Price:</label>
                <input type="number" id="editPrice" placeholder="Enter Price" required>
            </div>
            <div class="form-group">
                <label for="editStock">Stock:</label>
                <input type="number" id="editStock" placeholder="Enter Stock" required>
            </div>
            <input type="hidden" id="editProductId">
            <button type="submit">Update Product</button>
        </form>
    </div>
</div>

    <script src="index.js"></script>
</body>
</html>
