<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order - EZ Mart</title>
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="../order/order.css">
    <link rel="stylesheet" href="../buttons/button.css">
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <header class="header">
        <img src="../images/menu.svg" alt="EZ Mart Logo" class="logo" id="menuIcon">
        <span class="logo-text">EZ Mart</span>
    </header>
    
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../products/product.php">Products</a></li>
            <li><a href="../order/order.php">Orders</a></li>
        </ul>
    </div>
    
    <main class="container">
        <h1>Order Section</h1>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Order</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>John Doe</td>
                    <td>Apple, Banana</td>
                    <td><button class="add-btn">Add</button></td>
                </tr>
                <tr>
                    <td>Jane Smith</td>
                    <td>Milk, Bread</td>
                    <td><button class="add-btn">Add</button></td>
                </tr>
            </tbody>
        </table>
    </main>
    
    <script src="../buttons/button.js"></script>
</body>
</html>
