document.addEventListener("DOMContentLoaded", function () {
    console.log("Page loaded, fetching chart data...");

    fetch('order/orderapi.php?action=most_sold_product')
        .then(response => response.json())
        .then(data => {
            console.log("API Response:", data); // ✅ Debugging

            // Check if data is valid
            if (data && data.product_name && data.total_sold) {
                console.log("Most sold product:", data.product_name, "Sold:", data.total_sold);

                const ctx = document.getElementById('mostSoldChart')?.getContext('2d');
                if (!ctx) {
                    console.error("Canvas element not found!");
                    return;
                }

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [data.product_name],
                        datasets: [{
                            label: 'Most Sold Product',
                            data: [data.total_sold],
                            backgroundColor: 'rgba(255, 159, 64, 0.5)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, stepSize: 1 }
                        }
                    }
                });
            } else {
                console.error("No valid sales data received.");
            }
        })
        .catch(error => console.error("Error fetching most sold product:", error));
});
