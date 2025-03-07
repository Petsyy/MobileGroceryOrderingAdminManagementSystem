<!DOCTYPE html>
<html lang="en">
<>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="buttons/button.css">
    <link rel="stylesheet" href="user-profile/user.css">
    
    <!-- Include jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

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
                    <li><a href="#"><i class="fa-solid fa-user"></i> Edit Profile</a></li>
                    <li><a href="#"><i class="fa-solid fa-gear"></i> Settings</a></li>
                    <li><a href="login/login.html"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

    <div class="user-form-container">
        <div class="user-form">
            <div class="user-profile-section">
                <div class="user-profile">
                    <img src="../images/user_profile.png" alt="User Profile" id="userProfile">
                </div>
                <div class="user-upload">
                    <button class="upload-btn-upload">Upload New</button>
                    <button class="upload-btn-delete">Delete Avatar</button>
                </div>
            </div>

            <h2>Profile Settings</h2>

            <form action="user_settings.php" method="post" class="user-details">
                <div class="form-row">
                    <div class="form-group">
                        <label for="Fname">First Name:</label>
                        <input type="text" id="Fname" name="first_name" placeholder="First Name" required>
                    </div>
                    <div class="form-group">
                        <label for="Lname">Last Name:</label>
                        <input type="text" id="Lname" name="last_name" placeholder="Last Name" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
                    </div>
                    <div class="form-group">
                        <label for="number">Mobile Number:</label>
                        <input type="number" id="number" name="mobile_number" placeholder="+63XXXXXXXXX" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group gender-section">
                        <label>Gender:</label>
                        <div class="gender-options">
                            <label for="male">
                                <input type="radio" id="male" name="gender" value="male" required> Male
                            </label>
                            <label for="female">
                                <input type="radio" id="female" name="gender" value="female" required> Female
                            </label>
                        </div>
                    </div>

                    <div class="save-button-container">
                        <button type="submit">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
                <a href="./login/login.html" title="Log out">
                    <img src="./icons/logout.png" alt="Log out" id="sidebar-icon" style="width: 26px; height: 26px;">
                </a>
            </li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="buttons/button.js"></script>
    <script src="index.js"></script>
    <script src="user-profile/user.js"></script>
    <script src="bell.js"></script>

</body>
</html>