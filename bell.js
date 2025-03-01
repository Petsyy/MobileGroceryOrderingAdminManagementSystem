$(document).ready(function () {
    const bell = $("#bell");
    const notificationContainer = $("#notification-container");
    const notificationTable = $("#notification-table tbody");
    const markAllReadButton = $("#mark-all-read");

    function fetchNotifications() {
        $.ajax({
            url: "fetch_notifications.php",
            method: "GET",
            dataType: "json",
            success: function (response) {
                notificationTable.empty(); 

                if (response.length > 0) {
                    bell.addClass("has-notification"); 
                    response.forEach(notification => {
                        notificationTable.append(`
                            <tr>
                                <td>${notification.message}</td>
                                <td><button class="mark-read" data-id="${notification.id}">✓</button></td>
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

        $(this).closest("tr").fadeOut(300, function () { $(this).remove(); }); // Smooth removal
    });

    markAllReadButton.on("click", function () {
        $.ajax({
            url: "mark_all_read.php",
            method: "POST",
            success: function () {
                fetchNotifications();
            }
        });

        notificationTable.find("tr").fadeOut(300, function () { $(this).remove(); }); 
    });

    bell.on("click", function () {
        notificationContainer.toggleClass("show");
        fetchNotifications();
    });

    setInterval(fetchNotifications, 5000);
});
