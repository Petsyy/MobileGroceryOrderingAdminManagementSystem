$(document).ready(function () {
    let products = [];

    // Fetch Products
    async function fetchProducts() {
        try {
            console.log("Fetching products...");
            const response = await fetch('../../api/productapi.php');
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

            const data = await response.json();
            console.log("Fetched data:", data);

            if (!data.success || !Array.isArray(data.products)) {
                throw new Error("Invalid data format: Expected 'products' array");
            }

            products = data.products;
            renderProducts(products);
        } catch (error) {
            console.error("Error fetching products:", error);
        }
    }

    // Render Products
    function renderProducts(productsToRender) {
        $('#productList').empty();

        productsToRender.forEach(product => {
            const imagePath = product.image.trim().startsWith('http')
                ? product.image.trim()
                : `http://192.168.100.15/WEB-SM/assets/images/${product.image.trim() || 'default.jpg'}`;

            const price = parseFloat(product.price).toFixed(2);
            const stock = parseInt(product.stock);

            $('#productList').append(`
                <div class="product-container" data-id="${product.id}">
                    <img src="${imagePath}" alt="${product.name}">
                    <h3>${product.name}</h3>
                    <p>Price: ₱${price}</p>
                    <p>Stock: ${stock}</p>
                    <p>Category: ${product.category}</p>
                    <button class="edit-btn" data-id="${product.id}">Edit</button>
                    <button class="delete-btn" data-id="${product.id}">Delete</button>
                </div>
            `);
        });
    }

    // Filter Products by Category
    $('#categoryFilter').change(function () {
        const selectedCategory = $(this).val();
        renderProducts(selectedCategory === "All" ? products : products.filter(p => p.category === selectedCategory));
    });

    // Handle Edit Product Modal Show
    $('#productList').on('click', '.edit-btn', function () {
        const productId = $(this).data('id');
        const product = products.find(p => p.id == productId);
        if (!product) return;

        $('#editProductId').val(product.id);
        $('#editPrice').val(product.price);
        $('#editStock').val(product.stock);
        $('#editCategory').val(product.category);
        $('#editModal').fadeIn();
    });

    // Close Edit Product Modal
    $('#closeModal').click(() => $('#editModal').fadeOut());

    // Handle Edit Product Form Submit
    $('#editForm').submit(function (event) {
        event.preventDefault();

        const productId = $('#editProductId').val();
        const updatedPrice = parseFloat($('#editPrice').val());
        const updatedStock = parseInt($('#editStock').val());
        const updatedCategory = $('#editCategory').val();

        $.ajax({
            url: '../../api/productapi.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'update',
                id: productId,
                price: updatedPrice,
                stock: updatedStock,
                category: updatedCategory
            }),
            success: function () {
                alert("Product updated successfully!");
                $('#editModal').fadeOut();
                fetchProducts();
            },
            error: function (xhr) {
                console.error("Error updating product:", xhr.responseText);
                alert("Failed to update product.");
            }
        });
    });

    // Handle Delete Product
    $('#productList').on('click', '.delete-btn', function () {
        const productId = $(this).data('id');
        if (!confirm("Are you sure you want to delete this product?")) return;

        $.ajax({
            url: '../../api/productapi.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ action: 'delete', id: productId }),
            success: function () {
                alert("Product deleted successfully!");
                fetchProducts();
            },
            error: function (xhr) {
                console.error("Error deleting product:", xhr.responseText);
                alert("Failed to delete product.");
            }
        });
    });

    // Show Add Product Modal
    $('#addProductBtn').click(function () {
        $('#addProductModal').fadeIn(); // Show modal
    });

    // Close Add Product Modal
    $('#closeAddProductModal').click(function () {
        $('#addProductModal').fadeOut(); // Hide modal
    });

    // Handle Add Product Form Submit ✅✅✅ (Fixed Here)
    $('#productForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        // Get form values
        const name = $('#name').val().trim();
        const price = parseFloat($('#price').val());
        const stock = parseInt($('#stock').val());
        const image = $('#image').val().trim();
        const category = $('#category').val();

        // Basic validation
        if (!name || isNaN(price) || isNaN(stock) || !category) {
            alert("Please fill in all fields correctly.");
            return;
        }

        // AJAX call to add product
        $.ajax({
            url: '../../api/productapi.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                action: 'add',
                name: name,
                price: price,
                stock: stock,
                image: image,
                category: category
            }),
            success: function (response) {
                alert("Product added successfully!");
                $('#addProductModal').fadeOut(); // Close modal
                $('#productForm')[0].reset(); // Reset form
                fetchProducts(); // Refresh product list
            },
            error: function (xhr) {
                console.error("Error adding product:", xhr.responseText);
                alert("Failed to add product.");
            }
        });
    });

    // Initial fetch of products
    fetchProducts();
});
