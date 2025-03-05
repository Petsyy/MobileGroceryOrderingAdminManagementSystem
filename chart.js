document.addEventListener("DOMContentLoaded", function () {
    console.log("Fetching most sold products...");

    fetch('order/orderapi.php?action=most_sold_product')
        .then(response => response.json())
        .then(data => {
            console.log("API Response:", data); // ✅ Debugging

            if (Array.isArray(data) && data.length > 0) {
                const productNames = data.map(item => item.product_name);
                const totalSold = data.map(item => item.total_sold);

                const ctx = document.getElementById('mostSoldChart')?.getContext('2d');
                if (!ctx) {
                    console.error("Canvas element not found!");
                    return;
                }

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: productNames,
                        datasets: [{
                            label: 'Top 5 Most Sold Products',
                            data: totalSold,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
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
        .catch(error => console.error("Error fetching most sold products:", error));
});
