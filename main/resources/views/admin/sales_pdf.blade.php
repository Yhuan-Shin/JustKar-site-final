<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Logs</title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Sales Logs</h1>
    <table>
        <thead>
            <tr>
                <th>Ref. Number</th>
                <th>Product</th>
                <th>Product Type</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Total</th>
                <th>Cashier Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $log)
            <tr>
                <td>{{ $log->ref_no }}</td>
                <td>{{ $log->product_name }}</td>
                <td>{{ $log->product_type }}</td>
                <td>{{ $log->quantity }}</td>
                <td>{{ $log->created_at->format('m/d/Y, h:i A') }}</td>
                <td>₱{{ number_format($log->total_price, 2) }}</td>
                <td>{{ $log->cashier_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
