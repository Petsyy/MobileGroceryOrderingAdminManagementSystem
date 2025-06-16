$(document).ready(function () {
  function fetchTotalProducts() {
    fetch("api/total_product.php") // Ensure this path is correct
      .then((response) => response.json())
      .then((data) => {
        console.log("Fetched total products:", data); // Debugging log
        if (data.total_products !== undefined) {
          $("#totalProductCount").text(data.total_products);
        } else {
          console.error("Error: Invalid response", data);
        }
      })
      .catch((error) => console.error("Error fetching total products:", error));
  }

  function fetchTotalOrder() {
    fetch("api/total_order.php") // Ensure this path is correct
      .then((response) => response.json())
      .then((data) => {
        console.log("Fetched total orders:", data);
        if (data.total_order !== undefined) {
          $("#totalOrderCount").text(data.total_order);
        } else {
          console.error("Error: Invalid response", data);
        }
      })
      .catch((error) => console.error("Error fetching total orders:", error));
  }

  fetchTotalProducts();
  fetchTotalOrder();
});
