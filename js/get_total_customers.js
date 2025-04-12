document.addEventListener("DOMContentLoaded", function () {
    fetch("http://localhost/EZ-WEB/get_total_customers.php")
    .then(response => response.json())
    .then(data => {
        console.log("Fetched total unique customers:", data); // Debugging

        const totalCountElement = document.getElementById("totalCustomerCount");

        if (totalCountElement && data.total !== undefined) {
            totalCountElement.textContent = data.total;
        } else {
            console.error("Element #totalCustomerCount not found or API response invalid", data);
        }
    })
    .catch(error => console.error("Error fetching total customers:", error));
});
