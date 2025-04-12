$(document).ready(function () {
    let allCustomers = []; // Store customers for search filtering

    // Fetch customers when the page loads
    fetchCustomers();

    // Fetch customers function
    function fetchCustomers() {
        $.get('customerapi.php', function (response) {
            allCustomers = response; // Store data for filtering
            displayCustomers(response);
        }, 'json');
    }

    // Display customers function
    function displayCustomers(customers) {
        let customerHtml = '<table><tr><th>Name</th><th>Product</th><th>Total Price</th><th>Actions</th></tr>';
        customers.forEach(function (customer) {
            customerHtml += `
                <tr>
                    <td>${customer.name}</td>
                    <td>${customer.product || 'N/A'}</td>
                    <td>${customer.total_price || 'N/A'}</td>
                    <td>
                        <button class="view" onclick="viewTransactions(${customer.id})">View</button>
                        <button class="edit" onclick="updateCustomer(${customer.id})">Edit</button>
                        <button class="delete" onclick="deleteCustomer(${customer.id})">Delete</button>
                    </td>
                </tr>
            `;
        });
        customerHtml += '</table>';
        $('#customerList').html(customerHtml);
    }

    // Fetch and display previous transactions
function viewTransactions(customerId) {
    $.get('customerapi.php', { customer_id: customerId }, function(response) {
        let transactionHtml = '<ul>';
        if (response.length > 0) {
            response.forEach(function(transaction) {
                transactionHtml += `<li>Order ID: ${transaction.id}, Total: ${transaction.total_price}</li>`;
            });
        } else {
            transactionHtml += '<li>No previous transactions found.</li>';
        }
        transactionHtml += '</ul>';
        
        $('#transactionList').html(transactionHtml);
        
        // Ensure modal only appears when the function is called
        $('#transactionModal').css('display', 'flex');  
    }, 'json');
}

// Ensure modal is hidden on page load
$(document).ready(function() {
    $('#transactionModal').hide();
});


    // Search functionality
    $('#searchCustomer').on('input', function () {
        let searchTerm = $(this).val().toLowerCase();
        let filteredCustomers = allCustomers.filter(customer =>
            customer.name.toLowerCase().includes(searchTerm)
        );
        displayCustomers(filteredCustomers);
    });

    // Delete customer function
    function deleteCustomer(id) {
        if (confirm('Are you sure you want to delete this customer?')) {
            $.post('customerapi.php', { action: 'delete', id: id }, function (response) {
                alert(response.message);
                if (response.success) {
                    fetchCustomers();
                }
            }, 'json');
        }
    }

    // Update customer functionality (future implementation)
    function updateCustomer(id) {
        alert("Update functionality is not implemented yet for customer ID: " + id);
    }

    // Expose functions globally
    window.viewTransactions = viewTransactions;
    window.deleteCustomer = deleteCustomer;
    window.updateCustomer = updateCustomer;
});
