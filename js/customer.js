$(document).ready(function() {
    fetchOrders();

    function fetchOrders() {
        $.ajax({
            url: '../../api/orderapi.php',
            method: 'GET',
            data: { action: 'fetch' },
            dataType: 'json',
            success: function(response) {
                console.log('API Response:', response);
                
                if (Array.isArray(response)) {
                    displayOrders(response);
                } else {
                    console.error('Invalid API response:', response);
                    $('#customerList').html('<tr><td colspan="4">Error loading orders</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#customerList').html('<tr><td colspan="4">Failed to load orders</td></tr>');
            }
        });
    }

    function displayOrders(orders) {
        const customerList = $('#customerList');
        customerList.empty();

        if (orders.length === 0) {
            customerList.append('<tr><td colspan="4">No orders found</td></tr>');
            return;
        }

        // Group orders by customer name
        const customers = {};
        orders.forEach(order => {
            if (!customers[order.customer_name]) {
                customers[order.customer_name] = {
                    order_count: 0,
                    total_spent: 0,
                    latest_order: order
                };
            }
            customers[order.customer_name].order_count++;
            customers[order.customer_name].total_spent += parseFloat(order.order_total_price);
        });

        // Display each customer
        for (const [name, data] of Object.entries(customers)) {
            const row = `<tr>
                <td>${name}</td>
                <td>${data.order_count} order(s)</td>
                <td>₱${data.total_spent.toFixed(2)}</td>
                <td>
                    <button class="view-btn" data-customer="${encodeURIComponent(name)}">View Orders</button>
                </td>
            </tr>`;
            customerList.append(row);
        }

        // Attach click handlers
        $('.view-btn').click(function() {
            const customerName = decodeURIComponent($(this).data('customer'));
            fetchCustomerOrders(customerName);
        });
    }

    function fetchCustomerOrders(customerName) {
        $.ajax({
            url: '../../api/orderapi.php',
            method: 'GET',
            data: { 
                action: 'fetchPreviousOrders',
                customer_name: customerName 
            },
            dataType: 'json',
            success: function(response) {
                if (response.success && Array.isArray(response.orders)) {
                    displayCustomerOrders(customerName, response.orders);
                } else {
                    console.error('Invalid response:', response);
                    alert('Failed to load customer orders');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('Error loading customer orders');
            }
        });
    }

    function displayCustomerOrders(customerName, orders) {
        // Calculate total spent
        const totalSpent = orders.reduce((sum, order) => sum + parseFloat(order.total_price), 0);
        const orderCount = orders.length;
        
        const modalContent = `
            <div class="modal-header">
                <h2>Order History for ${customerName}</h2>
            </div>
            
            <div class="table-container">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${orders.map(order => `
                            <tr>
                                <td>#${order.id}</td>
                                <td>${new Date(order.created_at).toLocaleDateString('en-US', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                })}</td>
                                <td>
                                    <span class="status-badge status-${order.status.toLowerCase().replace(/\s+/g, '-')}">
                                        ${order.status}
                                    </span>
                                </td>
                                <td>₱${parseFloat(order.total_price).toFixed(2)}</td>
                                <td class="order-details" title="${order.order_details}">
                                    ${order.order_details}
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
            
            <div class="total-summary">
                <span>Total Orders: ${orderCount}</span>
                <span>Total Spent: ₱${totalSpent.toFixed(2)}</span>
            </div>
        `;
        
        $('#previousOrdersContainer').html(modalContent);
        $('#previousOrdersModal').show();
        
        // Re-attach close handler
        $('#closeModal').click(function() {
            $('#previousOrdersModal').hide();
        });
    }

    // Close modal when clicking outside
    $(window).click(function(event) {
        if ($(event.target).is('#previousOrdersModal')) {
            $('#previousOrdersModal').hide();
        }
    });
});