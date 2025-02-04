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
        <h1>Add Product</h1>
        <form id="productForm">
            <input type="text" id="name" placeholder="Product Name" required>
            <input type="number" id="price" placeholder="Price" required>
            <input type="text" id="image" placeholder="Image Path (e.g., images/product1.jpg)" required>
            <button type="submit">Add Product</button>
        </form>

        <h2>Products</h2>
        <div id="productList" class="product-list"></div>
    </div>

    <!-- Modal for Editing Price and Stock -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Edit Product</h2>
            <form id="editForm">
                <label for="editPrice">Price:</label>
                <input type="number" id="editPrice" placeholder="Price" required>
                <label for="editStock">Stock:</label>
                <input type="number" id="editStock" placeholder="Stock" required>
                <input type="hidden" id="editProductId">
                <button type="submit">Update Product</button>
            </form>
        </div>
    </div>

    <script src="index.js"></script>
</body>
</html>