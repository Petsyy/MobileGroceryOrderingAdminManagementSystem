$(document).ready(function () {
    function loadUsers() {
        $.ajax({
            url: "http://localhost/EZ-WEB/api/admin.php", // Updated path
            method: "GET",
            dataType: "json",
            success: function (response) {
                let tableBody = $("#usersTableBody");
                tableBody.empty();

                if (!response.success) {
                    tableBody.append("<tr><td colspan='5' class='error'>" + response.error + "</td></tr>");
                    return;
                }

                if (response.admins.length === 0) {
                    tableBody.append("<tr><td colspan='5' class='no-data'>No admin accounts found</td></tr>");
                    return;
                }

                response.admins.forEach(admin => {
                    let userRow = `
                        <tr>
                            <td>${admin.username}</td>
                            <td>${admin.email}</td>
                            <td>${admin.role}</td>
                            <td>${admin.status}</td>
                            <td>
                                <button class="edit-btn view-btn" data-id="${admin.id}">View</button>
                                <button class="delete-btn" data-id="${admin.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                    tableBody.append(userRow);
                });
            },
            error: function () {
                $("#usersTableBody").append("<tr><td colspan='5' class='error'>Failed to load user data.</td></tr>");
            }
        });
    }

    loadUsers();

    // View Admin Details
    $(document).on('click', '.view-btn', function() {
        const adminId = $(this).data('id');
        $.ajax({
            url: "http://localhost/EZ-WEB/get_admin.php", // Updated path
            method: "GET",
            data: { id: adminId },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    // Create and show modal with admin details
                    const admin = response.admin;
                    const modalHtml = `
                        <div id="adminDetailsModal" class="modal">
                            <div class="modal-content">
                                <span class="close-btn">&times;</span>
                                <h2>Admin Details</h2>
                                <div class="admin-details">
                                    <p><strong>Username:</strong> ${admin.username}</p>
                                    <p><strong>Email:</strong> ${admin.email}</p>
                                    <p><strong>Role:</strong> ${admin.role}</p>
                                    <p><strong>Status:</strong> ${admin.status}</p>
                                    <p><strong>Created At:</strong> ${admin.created_at}</p>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $('body').append(modalHtml);
                    $('#adminDetailsModal').show();
                    
                    // Close modal
                    $('.close-btn').on('click', function() {
                        $('#adminDetailsModal').remove();
                    });
                    
                    $(window).on('click', function(e) {
                        if ($(e.target).is('#adminDetailsModal')) {
                            $('#adminDetailsModal').remove();
                        }
                    });
                } else {
                    alert("Error: " + response.error);
                }
            },
            error: function() {
                alert("Failed to load admin details.");
            }
        });
    });

    // Delete Admin
    $(document).on('click', '.delete-btn', function() {
        if (!confirm("Are you sure you want to delete this admin?")) {
            return;
        }
        
        const adminId = $(this).data('id');
        $.ajax({
            url: "http://localhost/EZ-WEB/delete-admin.php", // Updated path
            method: "POST",
            data: { id: adminId },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    alert("Admin deleted successfully!");
                    loadUsers();
                } else {
                    alert("Error: " + response.error);
                }
            },
            error: function() {
                alert("Failed to delete admin.");
            }
        });
    });

    // Modal Logic for Add Admin
    const modal = $("#addAdminModal");
    $("#addUserBtn").on("click", function() {
        modal.show();
    });

    $(".close-btn").on("click", function() {
        modal.hide();
    });

    $(window).on("click", function(e) {
        if ($(e.target).is(modal)) {
            modal.hide();
        }
    });

    // Handle Form Submission
    $("#addAdminForm").submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "http://localhost/EZ-WEB/delete-admin.php", // Updated path
            method: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    alert("Admin added successfully!");
                    modal.hide();
                    $("#addAdminForm")[0].reset();
                    loadUsers();
                } else {
                    alert("Error: " + response.error);
                }
            },
            error: function() {
                alert("Failed to add admin.");
            }
        });
    });
});