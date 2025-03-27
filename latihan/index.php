<!DOCTYPE html>
<html>

<body>
    <canvas id="myChart" style="position: relative; height: 50vh; width: 75vw;"></canvas>
</body>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Penjualan',
                data: [10, 20, 30, 40, 50, 60],
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true,
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: "Bulan",
                    },
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Jumlah Penjualan",
                    },
                },
            },
        },
    });
</script>
</html>