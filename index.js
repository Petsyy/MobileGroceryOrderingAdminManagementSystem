$(document).ready(function () {
    function fetchTotalProducts() {
        fetch('order/total_product.php') // Ensure this path is correct
            .then(response => response.json())
            .then(data => {
                console.log("Fetched total products:", data); // Debugging log
                if (data.total_products !== undefined) {
                    $("#totalProductCount").text(data.total_products);
                } else {
                    console.error("Error: Invalid response", data);
                }
            })
            .catch(error => console.error("Error fetching total products:", error));
    }

    // Call the function when the page loads
    fetchTotalProducts();
});
