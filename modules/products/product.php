<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - EZ Mart</title>
    <link rel="stylesheet" href="../../assets/css/index.css">
    <link rel="stylesheet" href="../../assets/css/product.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <header class="header">
        <div class="logo-container">
            <img src="../../assets/images/ez-mart.svg" alt="EZ Mart Logo" class="ez_logo" id="ezLogo" style="width: 50px; height: auto;">
            <span class="logo-text">Mart</span>
        </div>
    </header>

    <main class="container">
        <h1>Products</h1>
        <!-- Filter Container -->
        <div class="filter-container">
            <label for="categoryFilter" class="filter-label">Category:</label>
            <select id="categoryFilter" class="filter-select">
                <option value="All">All</option>
                <option value="Unbeatable Prices">Unbeatable Prices</option>
                <option value="Featured Products">Featured Products</option>
                <option value="Snacks">Snacks</option>
                <option value="Sweets">Sweets</option>
                <option value="Pantry">Pantry</option>
                <option value="Fresh Produce">Fresh Produce</option>
                <option value="Meats and Seafoods">Meats and Seafoods</option>
                <option value="Beverages">Beverages</option>
                <option value="Dairy and Pastry">Dairy and Pastry</option>
                <option value="Household Essentials">Household Essentials</option>
            </select>
        </div>
        <!-- Product List -->
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
            <li>
                <a href="../index" title="Home">
                    <img src="../../assets/icons/home-icon.png" alt="Home" id="sidebar-icon" style="width: 27px; height: 27px;">
                </a>
            </li>
            <li>
                <a href="../modules/products/product" title="Products">
                    <img src="../../assets/icons/product.png" alt="Products" id="sidebar-icon" style="width: 24px; height: 24px;">
                </a>
            </li>
            <li>
                <a href="../modules/orders/order" title="Orders">
                    <img src="../../assets/icons/order.png" alt="Orders" id="sidebar-icon" style="width: 27px; height: 27px;">
                </a>
            </li>
            <li>
                <a href="../modules/customers/customer" title="Customers">
                    <img src="../../assets/icons/customer.png" alt="Customer" id="sidebar-icon" style="width: 29px; height: 29px;">
                </a>
            </li>
            <li>
                <a href="../modules/admins/admin-accounts" title="User Accounts">
                    <img src="../../assets/icons/user-settings.png" alt="User-Settings" id="sidebar-icon" style="width: 30px; height: 30px;">
                </a>
            </li>
            <li>
                <a href="../login/login.php" title="Log out">
                    <img src="../../assets/icons/logout.png" alt="Log out" id="sidebar-icon" style="width: 26px; height: 26px;">
                </a>
            </li>
        </ul>
    </div>


    <!-- Modals -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <span id="closeAddProductModal" class="close">&times;</span>
            <h2>Add Product</h2>
            <form id="productForm" action="../../api/add_products.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter product name" required>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" placeholder="Enter price" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" placeholder="Enter stock" required>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="All">All</option>
                        <option value="Unbeatable Prices">Unbeatable Prices</option>
                        <option value="Featured Products">Featured Products</option>
                        <option value="Snacks">Snacks</option>
                        <option value="Sweets">Sweets</option>
                        <option value="Pantry">Pantry</option>
                        <option value="Fresh Produce">Fresh Produce</option>
                        <option value="Meats and Seafoods">Meats and Seafoods</option>
                        <option value="Household Essentials">Household Essentials</option>
                        <option value="Beverages">Beverages</option>
                        <option value="Dairy and Pastry">Dairy and Pastry</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Add Product</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span id="closeModal" class="close">&times;</span>
            <h2>Edit Product</h2>
            <form id="editForm">
                <input type="hidden" id="editProductId">
                <div class="form-group">
                    <label for="editPrice">Price</label>
                    <input type="number" id="editPrice" placeholder="Enter price" required>
                </div>
                <div class="form-group">
                    <label for="editStock">Stock</label>
                    <input type="number" id="editStock" placeholder="Enter stock" required>
                </div>
                <div class="form-group">
                    <label for="editCategory">Category</label>
                    <select id="editCategory" required>
                        <option value="All">All</option>
                        <option value="Unbeatable Prices">Unbeatable Prices</option>
                        <option value="Featured Products">Featured Products</option>
                        <option value="Snacks">Snacks</option>
                        <option value="Sweets">Sweets</option>
                        <option value="Pantry">Pantry</option>
                        <option value="Fresh Produce">Fresh Produce</option>
                        <option value="Meats and Seafoods">Meats and Seafoods</option>
                        <option value="Beverages">Beverages</option>
                        <option value="Dairy and Pastry">Dairy and Pastry</option>
                        <option value="Household Essentials">Household Essentials</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Update Product</button>
            </form>
        </div>
    </div>

    <!-- Include product-specific JS -->
    <script src="../../js/product.js"></script>
</body>

</html>