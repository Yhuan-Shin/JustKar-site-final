<form method="GET" action="/admin/dashboard">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-2">
                <select name="period" onchange="this.form.submit()" class="form-select">
                    <option value="today" {{ $selectedPeriod === 'today' ? 'selected' : '' }}>Today</option>
                    <option value="this_week" {{ $selectedPeriod === 'this_week' ? 'selected' : '' }}>This Week</option>
                    <option value="this_month" {{ $selectedPeriod === 'this_month' ? 'selected' : '' }}>This Month</option>
                    <option value="this_year" {{ $selectedPeriod === 'this_year' ? 'selected' : '' }}>This Year</option>
                </select>
            </div>
        </div>
    </div>
</form>

<div id="piechart_3d" style="width: 100%; height: 350px;" class="shadow"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Product Name', 'Total Price'],
            @foreach($data as $row)
                ['{{ $row['name'] }}', {{ $row['total_price'] }}],
            @endforeach
        ]);

        var options = {
            title: 'Sales by Product({{ $selectedPeriod }})',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
    }
</script>
