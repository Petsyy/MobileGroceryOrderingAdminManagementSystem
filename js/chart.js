document.addEventListener("DOMContentLoaded", function () {
    // Get the canvas elements
    const salesCanvas = document.getElementById('myChart');
    const customersCanvas = document.getElementById('customerChart');

    if (!salesCanvas || !customersCanvas) {
        console.error('One or more chart elements are missing in the HTML.');
        return;
    }

    const ctxSales = salesCanvas.getContext('2d');
    const ctxCustomers = customersCanvas.getContext('2d');

    // Initialize the Pie Chart for Sales by Category
    const salesChart = new Chart(ctxSales, {
        type: 'pie',
        data: {
            labels: [], // Will be populated with categories
            datasets: [{
                label: 'Sales by Category',
                data: [], // Will be populated with sales data
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(199, 199, 199, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(199, 199, 199, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Sales by Category',
                    font: { size: 16 }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw} items`;
                        }
                    }
                }
            }
        }
    });

    // Initialize the Orders Per Customer Chart (Bar Chart) - UNCHANGED
    const customerChart = new Chart(ctxCustomers, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Orders per Customer',
                data: [],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { 
                y: { 
                    beginAtZero: true, 
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.raw} orders`;
                        }
                    }
                }
            }
        }
    });

    // Fetch data in parallel and update charts
    Promise.all([
        fetchSalesByCategory('/EZMartOrderingSystem/api/orderapi.php?action=getSalesByCategory', salesChart),
        fetchCustomerStats('/EZMartOrderingSystem/api/orderapi.php?action=customerOrderStats', customerChart)
    ]).catch(error => console.error("Error updating charts:", error));
});

// Function to fetch sales by category
function fetchSalesByCategory(url, chart) {
    return fetch(url)
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.success && data.categories && data.sales) {
                chart.data.labels = data.categories;
                chart.data.datasets[0].data = data.sales;
                chart.update();
            } else {
                console.error('Invalid sales by category data:', data);
            }
        })
        .catch(error => {
            console.error('Error fetching sales by category:', error);
            // Set some default data if the fetch fails
            chart.data.labels = ['No Data'];
            chart.data.datasets[0].data = [1];
            chart.update();
        });
}

// Function to fetch customer stats (unchanged except for error handling)
function fetchCustomerStats(url, chart) {
    return fetch(url)
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.labels && data.values) {
                chart.data.labels = data.labels;
                chart.data.datasets[0].data = data.values;
                chart.update();
            } else {
                console.error('Invalid customer order stats data:', data);
            }
        })
        .catch(error => {
            console.error('Error fetching customer stats:', error);
            // Set some default data if the fetch fails
            chart.data.labels = ['No Data'];
            chart.data.datasets[0].data = [0];
            chart.update();
        });
}

