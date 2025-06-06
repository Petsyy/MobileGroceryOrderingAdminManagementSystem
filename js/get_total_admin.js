document.addEventListener("DOMContentLoaded", function () {
    fetch("http://localhost/EZMartOrderingSystem/get_total_admin.php")
    .then(response => response.json())
    .then(data => {
      console.log("Fetched total admins:", data); // Debugging step
      if (data.total !== undefined) {
        document.getElementById("totalUserCount").textContent = data.total;
      } else {
        console.error("API response does not contain 'total'", data);
      }
    })
    .catch(error => console.error("Error fetching total users:", error));
  
});