$(document).ready(function () {
    const bell = $("#bell");
    const notificationCenter = $("#notification-center");
    const notificationList = $("#notification-list");
    const markAllReadButton = $("#mark-all-read");

    function fetchNotifications() {
        $.ajax({
            url: "fetch_notifications.php",
            method: "GET",
            dataType: "json",
            success: function (response) {
                notificationList.empty();

                if (response.length > 0) {
                    bell.addClass("has-notification");
                    response.forEach(notification => {
                        notificationList.append(`
                            <li class="${notification.status === 'read' ? 'read' : 'unread'}">
                                ${notification.message}
                                ${notification.status === 'read' ? '✔' : `<button class="mark-read" data-id="${notification.id}">✔</button>`}
                            </li>
                        `);
                    });
                } else {
                    bell.removeClass("has-notification");
                    notificationList.append('<li>No notifications</li>');
                }
            },
            error: function () {
                console.error("Error fetching notifications.");
            }
        });
    }

    $(document).on("click", ".mark-read", function () {
        const notificationId = $(this).data("id");

        $.ajax({
            url: "mark_notifications.php", // Corrected filename
            method: "POST",
            data: JSON.stringify({ id: notificationId }),
            contentType: "application/json",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    fetchNotifications(); // Refresh list after marking as read
                } else {
                    console.error("Error marking notification as read:", response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", xhr.status, error);
            }
        });
    });

    // Mark All as Read
    markAllReadButton.on("click", function () {
        $.ajax({
            url: "mark_notifications.php", // Corrected filename
            method: "POST",
            data: JSON.stringify({ mark_all: true }), // Indicate that all notifications should be marked as read
            contentType: "application/json",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    fetchNotifications(); // Refresh the notifications
                } else {
                    console.error("Error marking all as read:", response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", xhr.status, error);
            }
        });
    });

    // Toggle Notification Center
    bell.on("click", function (event) {
        event.stopPropagation();
        notificationCenter.toggle();
        fetchNotifications();
    });

    // Close when clicking outside
    $(document).on("click", function (event) {
        if (!notificationCenter.is(event.target) && notificationCenter.has(event.target).length === 0) {
            notificationCenter.hide();
        }
    });

    // Fetch notifications every 5 seconds
    setInterval(fetchNotifications, 5000);
});