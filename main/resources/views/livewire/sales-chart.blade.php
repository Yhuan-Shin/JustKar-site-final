<div>
    <div style="width: 100%; margin: auto;">
        <!-- Canvas element for the Chart.js chart -->
        <canvas id="salesChart" class="border border-1 p-2 shadow" height="250"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 
    
    <script>
            document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('salesChart').getContext('2d');
            var categoriesObject = @json($categories);
            
            // Convert categories object into an array of values
            var categories = Object.values(categoriesObject);

            var salesData = @json($salesData);

            var datasets = Object.keys(salesData).map(function (brand) {
                return {
                    label: brand,
                    data: categories.map(function (category) {
                        return salesData[brand][category] || 0;
                    }),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                };
            });

            var salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: categories,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

    </script>
</div>