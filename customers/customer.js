$(document).ready(function () {
    // Initialize empty customer orders array
    let customerOrders = [];

    // Function to render customer orders
    function renderCustomerOrders(orders) {
        const tbody = $("#customerOrdersBody");
        tbody.empty(); // Clear existing rows

        if (orders.length === 0) {
            tbody.append(`<tr><td colspan="4" style="text-align: center;">No orders yet.</td></tr>`);
        } else {
            orders.forEach((order, index) => {
                const row = $(`
                    <tr>
                        <td>${order.customerName}</td>
                        <td>${order.productName}</td>
                        <td>${order.totalPrice}</td>
                        <td>
                            <button class="delete-btn" data-index="${index}">🗑️ Delete</button>
                        </td>
                    </tr>
                `);
                tbody.append(row);
            });
        }
    }

    // Initial render (empty state)
    renderCustomerOrders(customerOrders);

    // Handle form submission
    $("#addCustomerOrderForm").submit(function (event) {
        event.preventDefault(); // Prevent page refresh

        // Get form values
        const customerName = $("#customerName").val().trim();
        const productName = $("#productName").val().trim();
        let totalPrice = $("#totalPrice").val().trim();

        // Validation
        if (!customerName || !productName || !totalPrice) {
            alert("⚠️ Please fill in all fields.");
            return;
        }

        // Ensure totalPrice is properly formatted
        totalPrice = `$${parseFloat(totalPrice).toFixed(2)}`;

        // Add new order to the array
        const newOrder = { customerName, productName, totalPrice };
        customerOrders.push(newOrder);

        // Re-render table
        renderCustomerOrders(customerOrders);

        // Reset form fields
        $("#addCustomerOrderForm")[0].reset();

        // Close modal after adding order
        $("#customerModal").fadeOut();
    });

    // Handle delete button
    $(document).on("click", ".delete-btn", function () {
        const index = $(this).data("index");
        customerOrders.splice(index, 1); // Remove from array
        renderCustomerOrders(customerOrders); // Re-render table
    });

    // Ensure modal is hidden on page load
    $("#customerModal").hide();

    // Show modal only when "Add Customer" button is clicked
    $("#openModal").click(function () {
        $("#customerModal").fadeIn();
    });

    // Close modal when clicking the close button
    $(".close-btn").click(function () {
        $("#customerModal").fadeOut();
    });

    // Close modal when clicking outside of it
    $(window).click(function (event) {
        if ($(event.target).is("#customerModal")) {
            $("#customerModal").fadeOut();
        }
    });
});
