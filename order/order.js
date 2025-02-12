$(document).ready(function () {
    fetchOrders();

    // Event delegation for dynamically created buttons
    $(document).on("click", ".view-btn", function () {
        let row = $(this).closest("tr");
        let name = row.find("td:nth-child(1)").text();
        let order = row.find("td:nth-child(2)").text();
        viewOrder(name, order);
    });

    $(document).on("click", ".confirm-btn", function () {
        let id = $(this).attr("data-id"); // Get order ID
        confirmOrder(id, this);
    });

    $(document).on("click", ".delete-btn", function () {
        let id = $(this).attr("data-id"); // Get order ID
        deleteOrder(id, this);
    });
});

// Fetch Orders from API
function fetchOrders() {
    $.getJSON("orderapi.php?action=fetch", function (data) {
        let tableBody = $(".order-table tbody");
        tableBody.empty(); // Clear existing rows

        data.forEach(order => {
            let row = `<tr>
                <td>${order.customer_name}</td>
                <td>${order.order_details}</td>
                <td>
                    <button class="view-btn">View</button>
                    <button class="confirm-btn" data-id="${order.id}">Confirm</button>
                    <button class="delete-btn" data-id="${order.id}">Delete</button>
                </td>
            </tr>`;
            tableBody.append(row);
        });
    }).fail(function (xhr, status, error) {
        console.error("Error fetching orders:", status, error);
    });
}

// View Order Modal
function viewOrder(name, order) {
    $("#orderDetails").text(`${name} ordered: ${order}`);
    $("#orderModal").show();
}

// Close Modal
function closeModal() {
    $("#orderModal").hide();
}

// Confirm Order (Remove Row on Success)
function confirmOrder(id, button) {
    console.log("Confirming Order ID:", id); // Debugging log

    $.post("orderapi.php", { action: "confirm", id: id }, function (response) {
        console.log("Response from Server:", response); // Debugging log

        if (response.success) {
            $(button).closest("tr").remove(); // Remove row after confirming
        } else {
            alert("Error confirming order.");
        }
    }, "json").fail(function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
    });
}

// Delete Order
function deleteOrder(id, button) {
    if (confirm("Are you sure you want to delete this order?")) {
        console.log("Deleting Order ID:", id); // Debugging log

        $.post("orderapi.php", { action: "delete", id: id }, function (response) {
            console.log("Response from Server:", response); // Debugging log

            if (response.success) {
                $(button).closest("tr").remove(); // Remove row after deleting
            } else {
                alert("Error deleting order.");
            }
        }, "json").fail(function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
        });
    }
}
