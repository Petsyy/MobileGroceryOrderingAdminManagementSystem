<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - EZ Mart</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../customers/customer.css">
    <link rel="stylesheet" href="../buttons/button.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <header class="header">
        <img src="../images/ez-mart.svg" alt="EZ Mart Logo" class="ez_logo" id="ezLogo" style="width: 50px;">
        <span class="logo-text">Mart</span>
    </header>
    
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <ul>
            <li>
                <a href="../index.php" title="Home">
                    <img src="../icons/home-icon.png" alt="Home" class="sidebar-icon">
                </a>
            </li>
            <li>
                <a href="../products/product.php" title="Products">
                    <img src="../icons/product.png" alt="Products" class="sidebar-icon">
                </a>
            </li>
            <li>
                <a href="../order/order.php" title="Orders">
                    <img src="../icons/order.png" alt="Orders" class="sidebar-icon">
                </a>
            </li>
            <li>
                <a href="../customers/customer.php" title="Customers" class="active">
                    <img src="../icons/customer.png" alt="Customers" class="sidebar-icon">
                </a>
            </li>
            <li>
                <a href="../login/login.php" title="Log out">
                    <img src="../icons/logout.png" alt="Log out" class="sidebar-icon">
                </a>
            </li>
        </ul>
    </div>
    
    <main class="container">
    <h1 id="customers">Customers</h1>
    
    <!-- Add Customer Button -->
    <button class="add-customer-btn" id="openModal">Add Customer</button>

    <!-- Modal -->
    <div id="customerModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Add Customer Order</h2>
            <form id="addCustomerOrderForm">
                <div class="form-group">
                    <label for="customerName">Customer Name:</label>
                    <input type="text" id="customerName" placeholder="Enter customer name" required>
                </div>
                <div class="form-group">
                    <label for="productName">Product Name:</label>
                    <input type="text" id="productName" placeholder="Enter product name" required>
                </div>
                <div class="form-group">
                    <label for="totalPrice">Total Price ($):</label>
                    <input type="number" id="totalPrice" placeholder="Enter total price" required min="0.01" step="0.01">
                </div>
                <button type="submit" class="submit-btn">Add Order</button>
            </form>
        </div>
    </div>

    <!-- Customer Orders Table -->
    <div class="table-container">
        <table class="customer-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="customerOrdersBody">
                <!-- Customer orders will be inserted here dynamically -->
            </tbody>
        </table>
    </div>
</main>

    <!-- JavaScript Files -->
    <script src="../buttons/button.js"></script>
    <script src="customer.js"></script>
</body>
</html>