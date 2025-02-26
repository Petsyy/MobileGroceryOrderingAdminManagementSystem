$(document).ready(function() {
    // Fetch customers when the page loads
    fetchCustomers();

    // Add customer functionality
    $('#addCustomerBtn').click(function() {
        $('#addCustomerModal').css('display', 'flex');
    });

    // Close the modal
    $('.close').click(function() {
        $('#addCustomerModal').hide();
    });

    // Add customer form submission
    $('#addCustomerForm').submit(function(e) {
        e.preventDefault();
        let name = $('#name').val();
        let product = $('#product').val();
        let total_price = $('#total_price').val();

        $.post('customerapi.php', {
            action: 'add',
            name: name,
            product: product,
            total_price: total_price
        }, function(response) {
            alert(response.message);
            if (response.success) {
                fetchCustomers();
                $('#addCustomerModal').hide();
            }
        }, 'json');
    });
});

// Fetch customers function
function fetchCustomers() {
    $.get('customerapi.php', function(response) {
        let customerHtml = '<table><tr><th>Name</th><th>Product</th><th>Total Price</th><th>Actions</th></tr>';
        response.forEach(function(customer) {
            customerHtml += `
                <tr>
                    <td>${customer.name}</td>
                    <td>${customer.product}</td>
                    <td>${customer.total_price}</td>
                    <td>
                        <button class="edit" onclick="updateCustomer(${customer.id})">Edit</button>
                        <button class="delete" onclick="deleteCustomer(${customer.id})">Delete</button>
                    </td>
                </tr>
            `;
        });
        customerHtml += '</table>';
        $('#customerList').html(customerHtml);
    }, 'json');
}

// Delete customer function
function deleteCustomer(id) {
    if (confirm('Are you sure you want to delete this customer?')) {
        $.post('customerapi.php', { action: 'delete', id: id }, function(response) {
            alert(response.message);
            if (response.success) {
                fetchCustomers();
            }
        }, 'json');
    }
}

// Update customer functionality (to be implemented in the future)
function updateCustomer(id) {
    alert("Update functionality is not implemented yet for customer ID: " + id);
}