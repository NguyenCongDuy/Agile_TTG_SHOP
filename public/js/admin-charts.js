// Admin Dashboard Charts

document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    if (document.getElementById('sales-chart')) {
        const salesChartCanvas = document.getElementById('sales-chart').getContext('2d');
        
        const salesChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [
                {
                    label: 'This Year',
                    backgroundColor: 'rgba(60,141,188,0.2)',
                    borderColor: 'rgba(60,141,188,1)',
                    pointRadius: 3,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [2800, 4800, 4000, 6000, 8000, 9000, 8500, 11000, 12500, 10000, 14000, 15000]
                },
                {
                    label: 'Last Year',
                    backgroundColor: 'rgba(210, 214, 222, 0.2)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    pointRadius: 3,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: [1000, 3000, 2500, 5000, 6500, 7000, 7500, 8500, 9000, 8000, 10000, 12000]
                }
            ]
        };

        const salesChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    grid: {
                        display: true
                    }
                }
            }
        };

        new Chart(salesChartCanvas, {
            type: 'line',
            data: salesChartData,
            options: salesChartOptions
        });
    }

    // Categories Pie Chart
    if (document.getElementById('categories-chart')) {
        const categoriesChartCanvas = document.getElementById('categories-chart').getContext('2d');
        
        const categoriesChartData = {
            labels: ['Electronics', 'Clothing', 'Home & Garden', 'Sports', 'Others'],
            datasets: [
                {
                    data: [45, 25, 15, 10, 5],
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d']
                }
            ]
        };

        const categoriesChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        };

        new Chart(categoriesChartCanvas, {
            type: 'doughnut',
            data: categoriesChartData,
            options: categoriesChartOptions
        });
    }
});
