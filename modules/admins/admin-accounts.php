<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Accounts - EZ Mart</title>
    <link rel="stylesheet" href="../../assets/css/index.css">
    <link rel="stylesheet" href="../../assets/css/user.css">
    <link rel="stylesheet" href="../../assets/css/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        <div class="user-accounts-header">
            <h1>Admin Section</h1>
        </div>

        <div class="user-accounts-container">
        

            <div class="users-table-container">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <!-- Data will be dynamically loaded here -->
                    </tbody>
                </table>
            </div>
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


    <script src="../../js/admin.js"></script>
</body>
</html>
