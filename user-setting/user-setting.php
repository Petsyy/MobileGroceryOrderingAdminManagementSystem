<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - EZ Mart</title>


    <link rel="stylesheet" href="../user-profile/user.css">
    <link rel="stylesheet" href="../buttons/button.css">


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="customer.js"></script>
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
                    <li><a href="#"><i class="fa-solid fa-user"></i> User Setting</a></li>
                    <li><a href="login/forgot.p"><i class="fa-solid fa-gear"></i> Forgot Password</a></li>
                    <li><a href="login/login.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>


    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <ul>
            <li>
                <a href="../index.php" title="Home">
                    <img src="../icons/home-icon.png" alt="Home" class="sidebar-icon" style="width: 27px; height: 27px;">
                </a>
            </li>
            <li>
                <a href="../products/product.php" title="Products">
                    <img src="../icons/product.png" alt="Products" class="sidebar-icon" style="width: 24px; height: 24px;">
                </a>
            </li>
            <li>
                <a href="../order/order.php" title="Orders">
                    <img src="../icons/order.png" alt="Orders" class="sidebar-icon" style="width: 27px; height: 27px;">
                </a>
            </li>
            <li>
                <a href="../customers/customer.php" title="Customers">
                    <img src="../icons/customer.png" alt="Customer" class="sidebar-icon" style="width: 29px; height: 29px;">
                </a>
            </li>
            <li>
                <a href="../user_accounts/user-accounts.php" title="User Accounts">
                    <img src="../icons/user-settings.png" alt="User-Settings" class="sidebar-icon" style="width: 30px; height: 30px;">
                </a>
            </li>
            <li>
                <a href="../login/login.php" title="Log out">
                    <img src="../icons/logout.png" alt="Log out" class="sidebar-icon" style="width: 26px; height: 26px;">
                </a>
            </li>
        </ul>
    </div>

    <div class="user-form-container"> <div class="user-form"> <div class="user-profile-section"> <div class="user-profile"> <img src="../images/user_profile.png" alt="User Profile" id="userProfile"> </div> <div class="user-upload"> <button class="upload-btn-upload">Upload New</button> <button class="upload-btn-delete">Delete Avatar</button> </div> </div> <h2>Profile Settings</h2> <form action="user_settings.php" method="post" class="user-details"> <div class="form-row"> <div class="form-group"> <label for="Fname">First Name:</label> <input type="text" id="Fname" name="first_name" placeholder="First Name" required> </div> <div class="form-group"> <label for="Lname">Last Name:</label> <input type="text" id="Lname" name="last_name" placeholder="Last Name" required> </div> </div> <div class="form-row"> <div class="form-group"> <label for="email">Email:</label> <input type="email" id="email" name="email" placeholder="example@gmail.com" required> </div> <div class="form-group"> <label for="number">Mobile Number:</label> <input type="number" id="number" name="mobile_number" placeholder="+63XXXXXXXXX" required> </div> </div> <div class="form-row"> <div class="form-group gender-section"> <label>Gender:</label> <div class="gender-options"> <label for="male"> <input type="radio" id="male" name="gender" value="male" required> Male </label> <label for="female"> <input type="radio" id="female" name="gender" value="female" required> Female </label> </div> </div> <div class="save-button-container"> <button type="submit">Save Changes</button> </div> </div> </form> </div> </div>

</body>
</html>
