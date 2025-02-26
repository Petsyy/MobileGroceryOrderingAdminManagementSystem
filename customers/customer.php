<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer - EZ Mart</title>
    
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="customer.css">
    <link rel="stylesheet" href="../buttons/button.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <header class="header">
        <img src="../images/ez-mart.svg" alt="EZ Mart Logo" class="ez_logo" id="ezLogo" style="width: 50px;">
        <span class="logo-text"> Mart</span>
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
                    <img src="../icons/customer.png" alt="Customers" id="sidebar-icon" style="width: 26px; height: 26px;">
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
        <h1 class="CustomerSection">Customers</h1>
        
        <!-- Previous Orders Table -->
        <table class="customer-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Total Price</th>
                </tr>
            </thead>
        </table>
    </main>

    <!-- JavaScript Files -->
    <script src="../buttons/button.js"></script>
    <script src="customer.js"></script>
</body>
</html>