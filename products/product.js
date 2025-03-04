$(document).ready(function () {
    let products = []; // Store all products

    // Fetch products from the database
    async function fetchProducts() {
        try {
            console.log("Fetching products...");
            const response = await fetch('../api.php');
    
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
    
            const text = await response.text();
            console.log("Raw response:", text);
    
            const data = JSON.parse(text);
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

    function renderProducts(productsToRender) {
        if (!Array.isArray(productsToRender)) {
            console.error("Error: products is not an array", productsToRender);
            return;
        }

        $('#productList').empty();

        productsToRender.forEach(product => {
            let imagePath = product.image.trim();

            if (!imagePath || imagePath.trim() === "" || imagePath.endsWith('/')) {
                imagePath = "http://localhost/SM/images/default.jpg";
            } else if (!imagePath.startsWith('http')) {
                imagePath = `http://localhost/SM/${imagePath}`;
            }
    
            const productContainer = $(`
                <div class="product-container" data-id="${product.id}">
                    <img src="${imagePath}" alt="${product.name}">
                    <h3>${product.name}</h3>
                    <p class="price">Price: $${product.price}</p>
                    <p>Stock: ${product.stock}</p>
                    <p>Category: ${product.category || 'N/A'}</p>
                    <button class="edit-btn" data-id="${product.id}">Edit</button>
                    <button class="delete-btn" data-id="${product.id}">Delete</button>
                </div>
            `);

            $('#productList').append(productContainer);
        });

        console.log("Rendered products:", productsToRender);
    }

    $('#categoryFilter').change(function () {
        const selectedCategory = $(this).val();
        if (selectedCategory === "All") {
            renderProducts(products);
        } else {
            const filteredProducts = products.filter(product => product.category === selectedCategory);
            renderProducts(filteredProducts);
        }
    });

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

    $('#closeModal').click(function () {
        $('#editModal').fadeOut();
    });

    $('#editForm').submit(function (event) {
        event.preventDefault();

        const productId = $('#editProductId').val();
        const updatedPrice = $('#editPrice').val();
        const updatedStock = $('#editStock').val();
        const updatedCategory = $('#editCategory').val();

        $.ajax({
            url: '../api.php',
            method: 'POST',
            data: {
                action: 'update',
                id: productId,
                price: updatedPrice,
                stock: updatedStock,
                category: updatedCategory
            },
            success: function (response) {
                console.log(response);
                alert("Product updated successfully!");
                $('#editModal').fadeOut();
                fetchProducts();
            },
            error: function (error) {
                console.error("Error updating product:", error);
            }
        });
    });

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
                fetchProducts();
            },
            error: function (error) {
                console.error("Error deleting product:", error);
            }
        });
    });

    $("#menuIcon").click(function () {
        $("#sidebar").toggleClass("active");
    });

    // Open "Add Product" Modal
    $('#addProductBtn').click(function () {
        $('#addProductModal').fadeIn();
    });

    // Close "Add Product" Modal
    $('#closeAddProductModal').click(function () {
        $('#addProductModal').fadeOut();
    });

    // Ensure add product form submission works
    $('#productForm').submit(function (event) {
        event.preventDefault();

        const productName = $('#name').val().trim();
        const productPrice = $('#price').val().trim();
        const productStock = $('#stock').val().trim();
        const productImage = $('#image').val().trim();
        const productCategory = $('#category').val();

        if (!productName || !productPrice || !productStock || !productImage || !productCategory) {
            alert("Please fill out all fields.");
            return;
        }

        $.ajax({
            url: '../api.php',
            method: 'POST',
            data: {
                action: 'add',
                name: productName,
                price: productPrice,
                stock: productStock,
                image: productImage,
                category: productCategory
            },
            success: function (response) {
                console.log(response);
                alert("Product added successfully!");
                $('#productForm')[0].reset();
                $('#addProductModal').fadeOut();
                fetchProducts();
            },
            error: function (error) {
                console.error("Error adding product:", error);
            }
        });
    });

    fetchProducts();
});
