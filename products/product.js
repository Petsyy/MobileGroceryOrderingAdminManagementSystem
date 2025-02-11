$(document).ready(function () {
    let products = []; 

    // Fetch products from the database
    async function fetchProducts() {
        try {
            console.log("Fetching products...");
            const response = await fetch('../api.php');

            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

            const text = await response.text();
            console.log("Raw response:", text);

            const data = JSON.parse(text);
            console.log("Fetched products:", data);

            if (!Array.isArray(data)) throw new Error("Invalid data format");

            products = data;
            renderProducts();
        } catch (error) {
            console.error("Error fetching products:", error);
        }
    }

    // Render products in the productList
    function renderProducts() {
        if (!Array.isArray(products)) {
            console.error("Error: products is not an array", products);
            return;
        }

        $('#productList').empty(); // Clear existing products

        products.forEach(product => {
            const productContainer = $(`
                <div class="product-container" data-id="${product.id}">
                    <img src="../images/${product.image}" alt="${product.name}">
                    <h3>${product.name}</h3>
                    <p class="price">Price: $${product.price}</p>
                    <p>Stock: ${product.stock}</p>
                    <button class="order-btn" data-id="${product.id}">Order Now</button>
                </div>
            `);

            $('#productList').append(productContainer);
        });

        console.log("Rendered products:", products);
    }

    // Handle order button click
    $('#productList').on('click', '.order-btn', function () {
        const productId = $(this).data('id');
        window.location.href = `../order/order.php?id=${productId}`;
    });

    // Toggle Sidebar
    $("#menuIcon").click(function () {
        $("#sidebar").toggleClass("active");
    });

    // Initial fetch of products
    fetchProducts();
});
