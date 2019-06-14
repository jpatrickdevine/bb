<!-- Chart JS -->
<script>
        // Graphs
        var ctx = document.getElementById('myChart')
        // eslint-disable-next-line no-unused-vars
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    '5:30pm',
                    '7:30pm',
                    '9:30pm',
                ],
                datasets: [{
                    data: [
                        <?php echo $covers1730 / 2; ?>,
                        <?php echo $covers1930 / 2; ?>,
                        <?php echo $covers2130 / 2; ?>,
                    ],
                    lineTension: 0,
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    borderWidth: 4,
                    pointBackgroundColor: '#007bff'
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            suggestedMax: 12
                        }
                    }]
                },
                legend: {
                    display: false
                }
            }
        })
</script>