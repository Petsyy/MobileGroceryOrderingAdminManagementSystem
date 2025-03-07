$(document).ready(function () {
    fetchOrders();

    // Event delegation for dynamically created buttons
    $(document).on("click", ".view-btn", function () {
        let row = $(this).closest("tr");
        let name = row.find("td:nth-child(1)").text().trim();
        let order = row.find("td:nth-child(2)").text().trim();
        viewOrder(name, order);
    });

    $(document).on("click", ".confirm-btn", function () {
        let id = $(this).attr("data-id"); // Get order ID
        confirmOrder(id, this);
    });

    $(document).on("click", ".delete-btn", function () {
        let id = $(this).attr("data-id"); // Get order ID
        if (id) {
            deleteOrder(id, this);
        } else {
            console.error("Order ID is undefined.");
        }
    });

    // Close modal when clicking outside the modal content
    $(document).on("click", "#orderModal", function (e) {
        if ($(e.target).hasClass("modal")) {
            closeModal();
        }
    });

    // Close modal on ESC key press
    $(document).on("keydown", function (e) {
        if (e.key === "Escape") {
            closeModal();
        }
    });

    // Ensure modal is hidden initially
    $("#orderModal").hide();
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
                <td>${order.status}</td>
                <td>
                    <button class="view-btn">View</button>
                    <button class="confirm-btn" data-id="${order.order_id}">Confirm</button>
                    <button class="delete-btn" data-id="${order.order_id}">Delete</button>
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
    $("#orderModal").fadeIn(200); // Use fadeIn for smooth appearance
}

// Close Modal
function closeModal() {
    $("#orderModal").fadeOut(200); // Use fadeOut for smooth disappearance
}

// Confirm Order (Remove Row on Success)
function confirmOrder(id, button) {
    console.log("Confirming Order ID:", id); // Debugging log

    $.post("orderapi.php", { action: "confirm", id: id }, function (response) {
        console.log("Response from Server:", response); // Debugging log

        if (response.success) {
            $(button).closest("tr").fadeOut(300, function () {
                $(this).remove();
            });
        } else {
            alert("Error confirming order.");
        }
    }, "json").fail(function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
    });
}

function deleteOrder(id, button) {
    console.log("Deleting Order ID:", id); // Debugging log

    if (confirm("Are you sure you want to delete this order?")) {
        $.post("orderapi.php", { action: "delete", id: id }, function (response) {
            console.log("Response from Server:", response); // Debugging log

            if (response.success) {
                $(button).closest("tr").fadeOut(300, function () {
                    $(this).remove();
                });
            } else {
                alert("Error deleting order: " + response.error);
            }
        }, "json").fail(function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
        });
    }
}