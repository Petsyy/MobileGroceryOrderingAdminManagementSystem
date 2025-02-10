$(document).ready(function () {
    let products = []; 

    // Fetch products from the database
    async function fetchProducts() {
        try {
            console.log("Fetching products...");
            const response = await fetch('api.php');
    
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
    
            const text = await response.text(); // Get raw response
            console.log("Raw response:", text); // Log raw response
    
            // Try parsing JSON
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
                    <h3>${product.name}</h3>
                    <img src="${product.image}" alt="${product.name}">
                    <p>Price: $${product.price}</p>
                    <p>Stock: ${product.stock}</p>
                    <button class="edit-btn" data-id="${product.id}" data-price="${product.price}" data-stock="${product.stock}">Edit</button>
                    <button class="delete-btn">Delete</button>
                </div>
            `);

            $('#productList').append(productContainer);
        });

        console.log("Rendered products:", products);
    }

    // Toggle Sidebar
    $("#menuIcon").click(function () {
        $("#sidebar").toggleClass("active");
    });

    // Open the edit modal
    function openEditModal(id, price, stock) {
        $('#editProductId').val(id);
        $('#editPrice').val(price);
        $('#editStock').val(stock);
        $('#editModal').show();
    }

    // Close the edit modal
    $('#closeModal').click(function () {
        $('#editModal').hide();
    });

    // Open and close add product modal
    $('#addProductBtn').click(function () {
        $('#addProductModal').show();
    });
    
    $('#closeAddProductModal').click(function () {
        $('#addProductModal').hide();
    });

    // Handle add product form submission
    $('#productForm').on('submit', async function (e) {
        e.preventDefault();
        const name = $('#name').val();
        const price = $('#price').val();
        const stock = $('#stock').val();
        const image = $('#image').val();

        const response = await fetch('SM/api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `name=${name}&price=${price}&stock=${stock}&image=${image}`
        });

        const result = await response.json();
        alert(result.message || result.error);
        fetchProducts();
        $('#addProductModal').hide();
    });

    // Handle edit form submission
    $('#editForm').on('submit', async function (e) {
        e.preventDefault();
        const id = $('#editProductId').val();
        const price = $('#editPrice').val();
        const stock = $('#editStock').val();

        const response = await fetch('SM/api.php', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&price=${price}&stock=${stock}`
        });

        const result = await response.json();
        alert(result.message || result.error);
        fetchProducts(); // Refresh products
        $('#editModal').hide();
    });

    // Handle delete button click
    $('#productList').on('click', '.delete-btn', async function () {
        const productContainer = $(this).closest('.product-container');
        const productId = productContainer.data('id');

        if (confirm('Are you sure you want to delete this product?')) {
            const response = await fetch('SM/api.php', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${productId}`
            });

            const result = await response.json();
            alert(result.message || result.error);
            fetchProducts(); // Refresh product list
        }
    });

    // Close modals when clicking outside
    $(window).on('click', function (event) {
        if (event.target === $('#addProductModal')[0]) {
            $('#addProductModal').hide();
        }
        if (event.target === $('#editModal')[0]) {
            $('#editModal').hide();
        }
    });

    // Initial fetch of products
    fetchProducts();
});
