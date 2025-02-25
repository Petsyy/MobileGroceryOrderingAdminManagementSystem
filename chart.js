document.addEventListener("DOMContentLoaded", function () {
    // Get the canvas elements
    const ordersCanvas = document.getElementById('myChart');
    const customersCanvas = document.getElementById('customerChart');

    if (!ordersCanvas || !customersCanvas) {
        console.error('One or more chart elements are missing in the HTML.');
        return; // Exit script if canvas elements are missing
    }

    const ctxOrders = ordersCanvas.getContext('2d');
    const ctxCustomers = customersCanvas.getContext('2d');

    // Initialize the Orders Per Day Chart (Pie Chart)
    const myChart = new Chart(ctxOrders, {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
                label: 'Total Orders Per Day',
                data: [],
                backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                borderWidth: 1
            }]
        },
        options: { responsive: true }
    });

    // Fetch order stats (Total Orders Per Day)
    fetch('order/orderapi.php?action=getOrderStats')
        .then(response => response.json())
        .then(data => {
            myChart.data.labels = data.labels;
            myChart.data.datasets[0].data = data.values;
            myChart.update();
        })
        .catch(error => console.error('Error fetching order data:', error));

    // Initialize the Orders Per Customer Chart (Bar Chart)
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
            scales: { y: { beginAtZero: true, stepSize: 1 } }
        }
    });

    // Fetch customer order stats
    fetch('order/orderapi.php?action=customerOrderStats')
        .then(response => response.json())
        .then(data => {
            customerChart.data.labels = data.labels;
            customerChart.data.datasets[0].data = data.values;
            customerChart.update();
        })
        .catch(error => console.error('Error fetching customer order data:', error));
});
