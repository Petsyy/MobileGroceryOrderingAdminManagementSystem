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
                    <button class="edit-btn" data-id="${product.id}">Edit</button>
                    <button class="delete-btn" data-id="${product.id}">Delete</button>
                </div>
            `);

            $('#productList').append(productContainer);
        });

        console.log("Rendered products:", products);
    }

    // Handle "Edit" button click
    $('#productList').on('click', '.edit-btn', function () {
        const productId = $(this).data('id');
        const product = products.find(p => p.id == productId);

        if (!product) return;

        // Populate edit form
        $('#editProductId').val(product.id);
        $('#editPrice').val(product.price);
        $('#editStock').val(product.stock);

        // Show the modal
        $('#editModal').fadeIn();
    });

    // Close Edit Modal
    $('#closeModal').click(function () {
        $('#editModal').fadeOut();
    });

    // Handle form submission for editing
    $('#editForm').submit(function (event) {
        event.preventDefault();

        const productId = $('#editProductId').val();
        const updatedPrice = $('#editPrice').val();
        const updatedStock = $('#editStock').val();

        $.ajax({
            url: '../api.php',
            method: 'POST',
            data: {
                action: 'update',
                id: productId,
                price: updatedPrice,
                stock: updatedStock
            },
            success: function (response) {
                console.log(response);
                alert("Product updated successfully!");
                $('#editModal').fadeOut();
                fetchProducts(); // Refresh the product list
            },
            error: function (error) {
                console.error("Error updating product:", error);
            }
        });
    });

    // Handle "Delete" button click
    $('#productList').on('click', '.delete-btn', function () {
        const productId = $(this).data('id');

        if (!confirm("Are you sure you want to delete this product?")) return;

        $.ajax({
            url: '../api.php',
            method: 'POST',
            data: {
                action: 'delete',
                id: productId
            },
            success: function (response) {
                console.log(response);
                alert("Product deleted successfully!");
                fetchProducts(); // Refresh product list
            },
            error: function (error) {
                console.error("Error deleting product:", error);
            }
        });
    });

    // Handle form submission for adding a product
    $('#productForm').submit(function (event) {
        event.preventDefault();

        const name = $('#name').val();
        const price = $('#price').val();
        const stock = $('#stock').val();
        const image = $('#image').val();

        $.ajax({
            url: '../api.php',
            method: 'POST',
            data: {
                action: 'add',
                name: name,
                price: price,
                stock: stock,
                image: image
            },
            success: function (response) {
                console.log(response);
                alert("Product added successfully!");
                $('#addProductModal').fadeOut(); // Hide the modal
                fetchProducts(); // Refresh the product list
            },
            error: function (error) {
                console.error("Error adding product:", error);
            }
        });
    });

    // Handle "Add Product" button click
    $('#addProductBtn').click(function () {
        $('#addProductModal').fadeIn(); // Show the modal
    });

    // Close Add Product Modal
    $('#closeAddProductModal').click(function () {
        $('#addProductModal').fadeOut(); // Hide the modal
    });
    
    // Toggle Sidebar
    $("#menuIcon").click(function () {
        $("#sidebar").toggleClass("active");
    });

    // Initial fetch of products
    fetchProducts();
});
