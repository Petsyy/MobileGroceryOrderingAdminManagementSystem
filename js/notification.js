document.addEventListener("DOMContentLoaded", function () {
  const bell = document.getElementById("bell");
  const notificationCenter = document.getElementById("notification-center");
  const notificationList = document.getElementById("notification-list");
  const notificationCount = document.getElementById("notification-count");

  if (!bell || !notificationCenter || !notificationList) {
    console.error("Critical elements missing!");
    return;
  }

  // Function to load notifications
  async function loadNotifications() {
    try {
      notificationList.innerHTML =
        '<li class="loading-notice">Loading notifications...</li>';

      const response = await fetch(
        "./api/orderapi.php?action=fetchNotifications",
        {
          headers: {
            "Cache-Control": "no-cache",
            Pragma: "no-cache",
          },
        }
      );

      if (!response.ok) throw new Error(`HTTP ${response.status}`);

      const data = await response.json();
      if (!data.success) throw new Error(data.error || "Unknown API error");

      renderNotifications(data.notifications || []);

      // Update unread count
      if (notificationCount) {
        const unreadCount = data.notifications.filter(
          (n) => n.status === "unread"
        ).length;
        notificationCount.textContent = unreadCount > 0 ? unreadCount : "";
        notificationCount.style.display = unreadCount > 0 ? "block" : "none";
      }
    } catch (error) {
      console.error("Notification error:", error);
      notificationList.innerHTML = `
                <li class="error-notice">
                    <span>⚠️ Failed to load notifications. Please try again later.</span>
                </li>
            `;
    }
  }

  // Initial load
  loadNotifications();

  // Click handler for bell icon
  bell.addEventListener("click", async function (e) {
    e.stopPropagation();
    notificationCenter.classList.toggle("show");
    if (notificationCenter.classList.contains("show")) {
      await loadNotifications();
    }
  });

  function renderNotifications(notifications) {
    notificationList.innerHTML = "";
    if (notifications.length === 0) {
      notificationList.innerHTML =
        '<li class="empty-notice">No notifications yet</li>';
      return;
    }

    notifications.forEach((notif) => {
      const li = document.createElement("li");
      li.className = `notification ${notif.status}`;
      li.innerHTML = `
                <div class="notification-message">${notif.message}</div>
                <div class="notification-meta">
                    <time>${formatDate(notif.created_at)}</time>
                    ${
                      notif.status === "unread"
                        ? '<span class="unread-dot"></span>'
                        : ""
                    }
                </div>
            `;

      // Add click handler to mark as read
      li.addEventListener("click", async () => {
        if (notif.status === "unread") {
          await markAsRead(notif.id);
          li.classList.replace("unread", "read");
          li.querySelector(".unread-dot")?.remove();
          if (notificationCount) {
            const current = parseInt(notificationCount.textContent) || 0;
            const newCount = current - 1;
            notificationCount.textContent = newCount > 0 ? newCount : "";
            notificationCount.style.display = newCount > 0 ? "block" : "none";
          }
        }
      });

      notificationList.appendChild(li);
    });
  }

  async function markAsRead(notificationId) {
    try {
      await fetch("./api/orderapi.php?action=markAsRead", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${notificationId}`,
      });
    } catch (error) {
      console.error("Failed to mark as read:", error);
    }
  }

  function formatDate(dateString) {
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return "Invalid date";
    const options = {
      year: "numeric",
      month: "short",
      day: "numeric",
      hour: "2-digit",
      minute: "2-digit",
      hour12: true,
    };
    return date.toLocaleString("en-US", options);
  }

  document.addEventListener("click", function (e) {
    if (!notificationCenter.contains(e.target) && e.target !== bell) {
      notificationCenter.classList.remove("show");
    }
  });
});
