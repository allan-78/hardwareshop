// Chart Configuration
const chartConfig = {
    // Dark theme defaults
    defaults: {
        color: '#fff',
        borderColor: 'rgba(255,255,255,0.1)',
        grid: {
            color: 'rgba(255,255,255,0.1)'
        }
    },
    colors: {
        primary: '#4e73df',
        success: '#1cc88a',
        info: '#36b9cc',
        warning: '#f6c23e',
        danger: '#e74a3b'
    }
};

// Initialize Charts
function initializeCharts() {
    Chart.defaults.color = chartConfig.defaults.color;
    Chart.defaults.borderColor = chartConfig.defaults.borderColor;

    // Sales Chart
    const salesChart = new Chart(document.getElementById('salesChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Monthly Sales',
                data: monthlySales,
                backgroundColor: chartConfig.colors.primary + '80',
                borderColor: chartConfig.colors.primary,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#fff'
                    }
                },
                title: {
                    display: true,
                    text: 'Monthly Sales Overview',
                    color: '#fff'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: chartConfig.defaults.grid,
                    ticks: {
                        callback: value => '₱' + value.toLocaleString()
                    }
                },
                x: {
                    grid: chartConfig.defaults.grid
                }
            }
        }
    });

    // Product Sales Distribution
    const productChart = new Chart(document.getElementById('productSalesChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: productLabels,
            datasets: [{
                data: productSales,
                backgroundColor: [
                    chartConfig.colors.primary,
                    chartConfig.colors.success,
                    chartConfig.colors.info,
                    chartConfig.colors.warning,
                    chartConfig.colors.danger
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#fff',
                        padding: 20
                    }
                }
            },
            cutout: '70%'
        }
    });

    // Date Range Picker
    $('#salesDateRange').daterangepicker({
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')]
        }
    }, function(start, end) {
        updateCharts(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    });
}

// Update charts with new data
function updateCharts(startDate, endDate) {
    fetch(`/admin/dashboard/chart-data?start=${startDate}&end=${endDate}`)
        .then(response => response.json())
        .then(data => {
            salesChart.data.labels = data.labels;
            salesChart.data.datasets[0].data = data.sales;
            salesChart.update();

            productChart.data.labels = data.productLabels;
            productChart.data.datasets[0].data = data.productSales;
            productChart.update();
        });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', initializeCharts);