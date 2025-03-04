const myChart = new Chart(ctxOrders, {
    type: 'pie',
    data: {
        labels: ['Total Products', 'Total Orders'],
        datasets: [{
            label: 'Total Products and Orders',
            data: [0, 0],
            backgroundColor: ['rgba(75, 192, 192, 0.5)', 'rgba(255, 99, 132, 0.5)'],
            borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: false,  // Disable automatic resizing
        maintainAspectRatio: false, // Allow custom sizing
        plugins: {
            title: {
                display: true,
                text: 'Total Products and Orders',
                font: { size: 20 } // Increase font size
            }
        }
    }
});

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
        responsive: false, 
        maintainAspectRatio: false,
        scales: { 
            y: { beginAtZero: true, stepSize: 1 }
        }
    }
});
