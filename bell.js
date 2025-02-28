$(document).ready(function () {
    const bell = $("#bell");
    const notificationContainer = $("#notification-container");
    const notificationTable = $("#notification-table tbody");
    const markAllReadButton = $("#mark-all-read");

    // Fetch Notifications
    function fetchNotifications() {
        $.ajax({
            url: "fetch_notifications.php",
            method: "GET",
            dataType: "json",
            success: function (response) {
                notificationTable.empty(); // Clear table

                if (response.length > 0) {
                    bell.addClass("has-notification"); // Add shake effect
                    response.forEach(notification => {
                        notificationTable.append(`
                            <tr>
                                <td>${notification.message}</td>
                                <td><button class="mark-read" data-id="${notification.id}">Mark as Read</button></td>
                            </tr>
                        `);
                    });
                } else {
                    bell.removeClass("has-notification");
                    notificationTable.append('<tr><td colspan="2">No new notifications</td></tr>');
                }
            },
            error: function () {
                console.error("Error fetching notifications.");
            }
        });
    }

    // Mark a Notification as Read
    $(document).on("click", ".mark-read", function () {
        const notificationId = $(this).data("id");

        $.ajax({
            url: "mark_notification_read.php",
            method: "POST",
            data: { id: notificationId },
            success: function () {
                fetchNotifications();
            }
        });
    });

    // Mark All as Read
    markAllReadButton.on("click", function () {
        $.ajax({
            url: "mark_all_read.php",
            method: "POST",
            success: function () {
                fetchNotifications();
            }
        });
    });

    // Toggle Notification Box
    bell.on("click", function () {
        notificationContainer.toggle();
        fetchNotifications(); // Fetch on open
    });

    // Fetch notifications every 5 seconds
    setInterval(fetchNotifications, 5000);
});
