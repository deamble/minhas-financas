// monthlyEntriesChart.js
document.addEventListener('DOMContentLoaded', function() {
    var ctxMonthlyEntries = document.getElementById('monthlyEntriesChart').getContext('2d');

    var data = entriesChartData ? entriesChartData.map(function(entry) {
        return entry.entry_count;
    }) : [];

    var monthlyEntriesChart = new Chart(ctxMonthlyEntries, {
        type: 'pie',
        data: {
            labels: ['Entradas', 'Saídas'],
            datasets: [{
                data: data,
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    display: false,
                },
                x: {
                    display: false,
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 20,
                        padding: 10,
                        usePointStyle: true
                    }
                }
            }
        }
    });
});
