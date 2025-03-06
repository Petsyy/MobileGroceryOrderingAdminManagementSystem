<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EZ Mart</title>
    
    <!-- Link to external CSS files -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="buttons/button.css">
    
    <!-- Include jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Header -->
<header class="header">
    <div class="logo-container">
        <img src="./images/ez-mart.svg" alt="EZ Mart Logo" class="ez_logo" id="ezLogo" style="width: 50px; height: auto;">
        <span class="logo-text">Mart</span>
    </div>

    <!-- User Profile and Notification Section -->
    <div class="user-notification-container">
        <!-- Notification Bell -->
        <div class="notification-container">
            <img src="icons/bell.svg" alt="Notifications" class="bell" id="bell">
            
            <!-- Notification Center -->
            <div id="notification-center">
                <h2>Notifications</h2>
                <div id="notification-container">
                    <ul id="notification-list">
                        <li>No new notifications</li>
                    </ul>
                    <button id="mark-all-read">Mark All as Read</button>
                </div>
            </div>
        </div>

        <!-- User Profile Section -->
        <div class="user-container" id="userContainer">
            <img src="./images/user_profile.png" alt="User Profile" class="user-profile" id="userProfile">
            <i class="fa-solid fa-caret-down dropdown-icon" id="dropdownIcon"></i>

            <!-- User Dropdown Menu -->
            <div class="user-dropdown hidden" id="userDropdown">
                <ul>
                    <li>
                        <a href="./user-profile/user_settings.php">
                        <i class="fa-solid fa-user"></i> Edit Profile</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa-solid fa-gear">
                        </i> Settings</a>
                    </li>

                    <li>
                        <a href="login/login.php">
                        <i class="fa-solid fa-right-from-bracket">
                    </i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

    <!-- Main Content -->
    <main class="container">
        <h1 id="dashBoard">Dashboard</h1>

            <!-- Counter Container -->
            <div class="counter-container">
                <!-- Total Products Count -->
                <div class="counter-box">
                <label>Total Products:</label>
                    <div class="counter-icon">
                        <img src="./icons/product-icon-counter.png" alt="Product Icon">
                        <span id="totalProductCount">0</span>
                    </div>
                </div>

                <!-- Order Counter -->
                <div class="counter-box">
                <label>Total Orders:</label>
                    <div class="counter-icon">
                        <img src="./icons/order-icon-counter.png" alt="Order Icon">
                        <span id="totalOrderCount">0</span>
                    </div>
                </div>

                <!-- Total Customer Counter -->
                <div class="counter-box">
                    <label>Total Customers:</label>
                    <div class="counter-icon">
                        <img src="./icons/customer-icon-counter.png" alt="Customer Icon">
                        <span id="totalCustomerCount">0</span>
                    </div>
                </div>
            </div>

        <!-- Product List -->
        <div id="productList" class="product-list">
            <!-- Product items will be dynamically added here -->
        </div>
    </main>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <ul>
            <li>
                <a href="./index.php" title="Home">
                    <img src="./icons/home-icon.png" alt="Home" id="sidebar-icon" style="width: 27px; height: 27px;">
                </a>
            </li>
            <li>
                <a href="./products/product.php" title="Products">
                    <img src="./icons/product.png" alt="Products" id="sidebar-icon" style="width: 24px; height: 24px;">
                </a>
            </li>
            <li>
                <a href="./order/order.php" title="Orders">
                    <img src="./icons/order.png" alt="Orders" id="sidebar-icon" style="width: 27px; height: 27px;">
                </a>
            </li>
            <li>
                <a href="./customers/customer.php" title="Customers">
                    <img src="./icons/customer.png" alt="Customer" id="sidebar-icon" style="width: 29px; height: 29px;">
                </a>
            </li>
            <li>
                <a href="./user-setting/user-setting.php" title="User Setting">
                    <img src="./icons/user-settings.png" alt="User-Settings" id="sidebar-icon" style="width: 30px; height: 30px;">
                </a>
            </li>
            <li>
                <a href="./login/login.php" title="Log out">
                    <img src="./icons/logout.png" alt="Log out" id="sidebar-icon" style="width: 26px; height: 26px;">
                </a>
            </li>
        </ul>
    </div>

    <!-- Chart Container -->
    <div class="chart-container" style="height: 400px; width: 400px;">
        <canvas id="myChart" class="chart"></canvas>
        <canvas id="customerChart" class="chart"></canvas>
    </div>

    <!-- Include external JavaScript files -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="chart.js"></script>
    <script src="buttons/button.js"></script>
    <script src="index.js"></script>
    <script src="user-profile/user.js"></script>
    <script src="bell.js"></script>
</body>
</html>