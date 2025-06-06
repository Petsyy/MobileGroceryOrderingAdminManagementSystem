document.addEventListener('DOMContentLoaded', function() {
    // Function to fetch and display recent orders
    function loadRecentOrders() {
        fetch('/EZMartOrderingSystem/api/orderapi.php?action=getRecentOrders&limit=5')
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success && data.orders) {
                    displayRecentOrders(data.orders);
                } else {
                    console.error('Failed to load recent orders:', data.error);
                    showErrorInRecentOrders();
                }
            })
            .catch(error => {
                console.error('Error fetching recent orders:', error);
                showErrorInRecentOrders();
            });
    }

    // Function to display orders in the table
    function displayRecentOrders(orders) {
        const tbody = document.getElementById('recent-orders-body');
        tbody.innerHTML = ''; // Clear existing content
    
        if (orders.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = '<td colspan="5" style="text-align: center;">No recent orders found</td>';
            tbody.appendChild(row);
            return;
        }
    
        orders.forEach(order => {
            const row = document.createElement('tr');
            row.style.cursor = 'pointer';
            row.addEventListener('click', () => {
                window.location.href = `./modules/orders/order.php?id=${order.id}`;
            });
    
            // Format the date
            const orderDate = new Date(order.created_at);
            const formattedDate = orderDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
    
            // Format the amount in PHP (₱)
            const formattedAmount = new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP'
            }).format(order.total_price);
    
            // Determine status class
            const statusClass = `status-${order.status.toLowerCase()}`;
            
            row.innerHTML = `
                <td>#${order.id}</td>
                <td>${order.customer_name}</td>
                <td>${formattedAmount}</td>
                <td class="${statusClass}">${order.status}</td>
                <td>${formattedDate}</td>
            `;
            
            tbody.appendChild(row);
        });
    }
    
    // Function to show error message
    function showErrorInRecentOrders() {
        const tbody = document.getElementById('recent-orders-body');
        tbody.innerHTML = `
            <tr>
                <td colspan="5" style="text-align: center; color: #dc3545;">
                    Failed to load recent orders. Please try again later.
                </td>
            </tr>
        `;
    }
    
    // Load orders initially
    loadRecentOrders();
    
    // Auto-refresh every 30 seconds
    setInterval(loadRecentOrders, 30000);
    
});