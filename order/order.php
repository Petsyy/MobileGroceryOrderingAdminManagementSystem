<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order - EZ Mart</title>
    
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="order.css">
    <link rel="stylesheet" href="../buttons/button.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <header class="header">
        <div class="logo-container">
            <img src="../images/ez-mart.svg" alt="EZ Mart Logo" class="ez_logo" id="ezLogo" style="width: 50px; height: auto;">
            <span class="logo-text">Mart</span>
        </div>
    </header>
    
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <ul>
            <li>
                <a href="../index.php" title="Home">
                    <img src="../icons/home-icon.png" alt="Home" id="sidebar-icon" style="width: 27px; height: 27px;">
                </a>
            </li>
            <li>
                <a href="../products/product.php" title="Products">
                    <img src="../icons/product.png" alt="Products" id="sidebar-icon" style="width: 24px; height: 24px;">
                </a>
            </li>
            <li>
                <a href="../order/order.php" title="Orders">
                    <img src="../icons/order.png" alt="Orders" id="sidebar-icon" style="width: 27px; height: 27px;">
                </a>
            </li>
            <li>
                <a href="../customers/customer.php" title="Customers">
                    <img src="../icons/customer.png" alt="Customer" id="sidebar-icon" style="width: 29px; height: 29px;">
                </a>
            </li>
            <li>
                <a href="../user_accounts/user-accounts.php" title="User Accounts">
                    <img src="../icons/user-settings.png" alt="User-Settings" id="sidebar-icon" style="width: 30px; height: 30px;">
                </a>
            </li>
            <li>
                <a href="../login/login.php" title="Log out">
                    <img src="../icons/logout.png" alt="Log out" id="sidebar-icon" style="width: 26px; height: 26px;">
                </a>
            </li>
        </ul>
    </div>
    
<main class="container">
    <h1>Order Section</h1>
    <div class="table-container">
        <table class="order-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="orderTableBody">
                <!-- Orders will be dynamically inserted here -->
            </tbody>
        </table>
    </div>
</main>



    <!-- Order View Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Order Details</h2>
            <p id="orderDetails"></p>
        </div>
    </div>

    <!-- JavaScript Files -->
    <script src="../buttons/button.js"></script>
    <script src="order.js"></script>
</html>