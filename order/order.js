$(document).ready(function () {
    fetchOrders(); // Fetch orders when page loads
    checkNewOrders(); // Check for new orders

    // Check for new orders every 10 seconds
    setInterval(checkNewOrders, 10000);

    // Event delegation for dynamically created buttons
    $(document).on("click", ".view-btn", function () {
        let row = $(this).closest("tr");
        let name = row.find("td:nth-child(1)").text().trim();
        let order = row.find("td:nth-child(2)").text().trim();
        viewOrder(name, order);
    });

    $(document).on("click", ".confirm-btn", function () {
        let id = $(this).attr("data-id");
        confirmOrder(id, this);
    });

    $(document).on("click", ".delete-btn", function () {
        let id = $(this).attr("data-id");
        if (id) {
            deleteOrder(id, this);
        } else {
            console.error("Order ID is undefined.");
        }
    });

    // Ensure modal is hidden initially
    $("#orderModal").hide();
});

function fetchOrders() {
    $.ajax({
        url: "orderapi.php",
        type: "GET",
        data: { action: "fetch" },
        dataType: "json",
        success: function (response) {
            console.log(response); // ✅ Check if data is received

            let tableBody = $("#orderTableBody");
            tableBody.empty(); // Clear previous data

            if (response.length === 0) {
                tableBody.append("<tr><td colspan='5'>No orders found</td></tr>");
                return;
            }

            response.forEach(order => {
                let row = `
                    <tr>
                        <td>${order.customer_name}</td>
                        <td>${order.order_details}</td>
                        <td>${order.order_total_price}</td>
                        <td>${order.status}</td>
                        <td>
                            <button class="confirm-btn" data-id="${order.order_id}">Confirm</button>
                            <button class="delete-btn" data-id="${order.order_id}">Delete</button>
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error fetching orders:", error);
        }
    });
}


console.log(response);

// Function to check for new orders
function checkNewOrders() {
    $.getJSON("orderapi.php?action=check_new_orders", function (data) {
        let newOrders = data?.new_orders || 0; // Fallback to 0 if undefined
        if (newOrders > 0) {
            $("#notification").text(`📢 ${newOrders} new orders!`).show();
        } else {
            $("#notification").hide();
        }
    }).fail(function (xhr, status, error) {
        console.error("Error checking new orders:", status, error);
    });
}
