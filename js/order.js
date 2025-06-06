$(document).ready(function () {
    fetchOrders();

    // Event delegation for dynamically created buttons
    $(document).on("click", ".view-btn", function () {
        let row = $(this).closest("tr");
        let name = row.find("td:nth-child(1)").text().trim();
        let order = row.find("td:nth-child(2)").text().trim();
        let totalPrice = row.find("td:nth-child(3)").text().trim();
        let status = row.find("td:nth-child(4)").text().trim();
        viewOrder(name, order, totalPrice, status);
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

    $(document).on("click", ".ready-btn", function () {
        let id = $(this).attr("data-id");
        readyToPickup(id, this);
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
    $.getJSON("/EZMartOrderingSystem/api/orderapi.php?action=fetch", function (data) {
        console.log("API Response:", data);

        let tableBody = $(".order-table tbody");
        tableBody.empty();

        if (data.success === false) {
            tableBody.append('<tr><td colspan="5">No orders found.</td></tr>');
            return;
        }

        if (!Array.isArray(data)) {
            console.error("Unexpected API response format:", data);
            tableBody.append('<tr><td colspan="5">No orders found.</td></tr>');
            return;
        }

        data.forEach(order => {
            const totalPrice = parseFloat(order.order_total_price || 0);
            const formattedPrice = isNaN(totalPrice) ? '₱0.00' : '₱' + totalPrice.toFixed(2);
            
            // Create action buttons based on status
            let actionButtons = '';
            if (order.status === 'Pending') {
                actionButtons = `
                    <button class="view-btn" data-id="${order.order_id}">View</button>
                    <button class="confirm-btn" data-id="${order.order_id}">Confirm</button>
                    <button class="delete-btn" data-id="${order.order_id}">Delete</button>
                `;
            } else if (order.status === 'Paid') {
                actionButtons = `
                    <button class="view-btn" data-id="${order.order_id}">View</button>
                    <button class="ready-btn" data-id="${order.order_id}">Ready to Pick Up</button>
                `;
            } else if (order.status === 'Ready to Pick Up') {
                actionButtons = `
                    <button class="view-btn" data-id="${order.order_id}">View</button>
                    <span class="ready-text">Ready</span>
                `;
            } else {
                actionButtons = `<button class="view-btn" data-id="${order.order_id}">View</button>`;
            }
            
            let row = `<tr>
                <td>${order.customer_name}</td>
                <td>${order.order_details}</td>
                <td>${formattedPrice}</td>
                <td class="status-${order.status.toLowerCase().replace(/ /g, '-')}">${order.status}</td>
                <td class="action-buttons">
                    ${actionButtons}
                </td>
            </tr>`;
            tableBody.append(row);
        });
    }).fail(function (xhr, status, error) {
        console.error("Error fetching orders:", status, error);
    });
}

function readyToPickup(id, button) {
    const $btn = $(button);
    $btn.prop('disabled', true).text('Processing...');

    $.ajax({
        url: '/EZMartOrderingSystem/api/orderapi.php',
        type: 'POST',
        data: { action: 'readyToPickup', id: id },
        dataType: 'json'
    })
    .done(function(response) {
        if (response.success) {
            // Update UI
            const $row = $btn.closest('tr');
            $row.find('td:nth-child(4)')
                .removeClass()
                .addClass('status-ready-to-pick-up')
                .text('Ready to Pick Up');

            $row.find('.action-buttons').html(`
                <button class="view-btn" data-id="${id}">View</button>
                <span class="ready-text">Ready</span>
            `);

            // Show appropriate message
            if (response.token_invalid) {
                alert('Status updated, but customer notification failed (app not installed)');
            } else if (response.notification_sent) {
                alert('Order ready! Customer notified.');
            } else {
                alert('Order status updated');
            }
        } else {
            alert('Error: ' + (response.error || 'Request failed'));
            $btn.prop('disabled', false).text('Ready to Pick Up');
        }
    })
    .fail(function(xhr) {
        alert('Server error. Please try again.');
        $btn.prop('disabled', false).text('Ready to Pick Up');
    });
}

function showAlert(type, message) {
    // Replace with your preferred notification system
    alert(`${type.toUpperCase()}: ${message}`);
}

// View Order Modal
function viewOrder(name, order, totalPrice, status) {
    // Create HTML content for the modal
    let detailsHTML = `
        <div class="order-details-container">
            <div class="detail-row">
                <span class="detail-label">Customer Name:</span>
                <span class="detail-value">${name}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Order Items:</span>
                <span class="detail-value">${order}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Total Price:</span>
                <span class="detail-value">${totalPrice}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value status-${status.toLowerCase()}">${status}</span>
            </div>
        </div>
    `;
    
    $("#orderDetails").html(detailsHTML);
    $("#orderModal").fadeIn(200);
}

// Close Modal
function closeModal() {
    $("#orderModal").fadeOut(200);
}

// Confirm Order (Remove Row on Success)
function confirmOrder(id, button) {
    const $btn = $(button);
    $btn.prop('disabled', true).text('Processing...');

    $.ajax({
        url: '/EZMartOrderingSystem/api/orderapi.php',
        type: 'POST',
        data: { 
            action: 'confirm', 
            id: id 
        },
        dataType: 'json'
    })
    .done(function(response) {
        console.log("Confirmation Response:", response);
        
        if (response.success) {
            // Remove the row or update status visually
            $(button).closest('tr').fadeOut(300, function() {
                $(this).remove();
            });
            
            // Show appropriate message
            if (response.token_invalid) {
                alert('Order confirmed, but customer notification failed (app not installed)');
            } else if (response.notification_sent) {
                alert('Order confirmed and customer notified!');
            } else {
                alert('Order confirmed successfully');
            }
        } else {
            alert('Error: ' + (response.error || 'Failed to confirm order'));
            $btn.prop('disabled', false).text('Confirm');
        }
    })
    .fail(function(xhr) {
        alert('Server error. Please try again.');
        $btn.prop('disabled', false).text('Confirm');
    });
}

function deleteOrder(id, button) {
    console.log("Deleting Order ID:", id);

    if (confirm("Are you sure you want to delete this order?")) {
        $.post("/EZMartOrderingSystem/api/orderapi.php", { action: "delete", id: id }, function (response) {
            console.log("Response from Server:", response);

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