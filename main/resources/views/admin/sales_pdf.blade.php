<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Logs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        h6 {
            text-align: right;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .badge {
            padding: 3px 7px;
            border-radius: 3px;
            color: #fff;
            font-size: 0.8em;
        }
        .bg-success {
            background-color: #28a745;
        }
        .bg-warning {
            background-color: #ffc107;
        }
        .bg-primary {
            background-color: #007bff;
        }
        .bg-dark {
            background-color: #343a40;
        }
    </style>
</head>
<body>
    <h1>Sales Report JustKar</h1>

    <h6>Date: {{ date('d/m/Y') }}</h6>
    <table>
        <thead style="white-space: nowrap">
            <tr>
                <th>Transaction No.</th>
                <th>Ref. Number</th>
                <th>Invoice No.</th>
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
                <td>{{ $log->transaction_no }}</td>
                @if ($loop->first || $sales[$loop->index - 1]->invoice_no !== $log->invoice_no)
                @php
                    $rowspan = $sales->where('invoice_no', $log->invoice_no)->count();
                @endphp
                <td rowspan="{{ $rowspan }}" class="align-middle border">
                    {{ strtoupper($log->ref_no) }}
                    @if($log->payment->payment_method == 'cash') 
                        <span class="badge bg-success">CASH</span> 
                    @elseif($log->payment->payment_method == 'credit_card')
                        <span class="badge bg-warning">CARD</span>
                    @elseif($log->payment->payment_method == 'gcash')
                        <span class="badge bg-primary">GCASH</span>
                    @elseif($log->payment->payment_method == 'bank')
                        <span class="badge bg-dark">BANK</span>
                    @endif
                </td>
            @endif
            @if ($loop->first || $sales[$loop->index - 1]->invoice_no !== $log->invoice_no)
                @php
                    $rowspan = $sales->where('invoice_no', $log->invoice_no)->count();
                @endphp
                 <td rowspan="{{ $rowspan }}" class="align-middle border">{{ $log->invoice_no }}</td>
             @endif
                <td>{{ $log->product_name }}</td>
                <td>{{ $log->product_type }}</td>
                <td>{{ $log->quantity }}</td>
                <td>{{ $log->created_at->format('m/d/Y, h:i A') }}</td>
                <td style="white-space: nowrap"><span style="font-family: DejaVu Sans; sans-serif;"> &#8369;</span>{{ number_format($log->total_price, 2) }}</td>
                <td>{{ $log->cashier_name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
