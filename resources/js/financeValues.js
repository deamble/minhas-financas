document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('financeValues').getContext('2d');
    var financeValuesChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Entradas R$', 'Saídas R$', 'Total R$'],
            datasets: [{
                data: [
                    // ... seu código PHP aqui
                ],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 193, 7, 0.2)',
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 193, 7, 1)',
                ],
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
                        usePointStyle: true,
                        generateLabels: function(chart) {
                            var data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map(function(label, i) {
                                    var dataset = data.datasets[0];
                                    var value = dataset.data[i];
                                    return {
                                        text: label + ' ' + value + ' R$',
                                        fillStyle: dataset.backgroundColor[i],
                                        hidden: isNaN(dataset.data[i]),
                                        lineCap: 'butt',
                                        lineDash: [],
                                        lineDashOffset: 0,
                                        lineJoin: 'miter',
                                        lineWidth: 1,
                                        strokeStyle: dataset.borderColor[i],
                                        pointStyle: 'circle',
                                        rotation: 0
                                    };
                                });
                            } else {
                                return [];
                            }
                        }
                    }
                }
            }
        }
    });
});
