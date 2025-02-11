<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - EZ Mart</title>
    
    <!-- Link to external CSS files -->
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../product/product.css">
    <Link rel="stylesheet" href="../buttons/button.css">
    
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <header class="header">
        <img src="../images/menu.svg" alt="EZ Mart Logo" class="logo" id="menuIcon">
        <span class="logo-text">EZ Mart</span>
    </header>
    
    <main class="container">
        <h1>Products</h1>
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
            <li><a href="../index.php">Home</a></li>
            <li><a href="../products/product.php">Products</a></li>
            <li><a href="../order/order.php">Orders</a></li>
        </ul>
    </div>

    <!-- Modals -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <span id="closeAddProductModal" class="close">&times;</span>
            <h2>Add Product</h2>
            <form id="productForm">
                <input type="text" id="name" placeholder="Product Name" required>
                <input type="number" id="price" placeholder="Price" required>
                <input type="number" id="stock" placeholder="Stock" required>
                <input type="text" id="image" placeholder="Image URL" required>
                <button type="submit">Add</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span id="closeModal" class="close">&times;</span>
            <h2>Edit Product</h2>
            <form id="editForm">
                <input type="hidden" id="editProductId">
                <input type="number" id="editPrice" placeholder="Price" required>
                <input type="number" id="editStock" placeholder="Stock" required>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>

    <!-- Include product-specific JS -->
    <script src="product.js"></script>
    <script src="../buttons/button.js"></script>
</body>
</html>
