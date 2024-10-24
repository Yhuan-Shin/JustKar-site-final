<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Justkar Tire Supply</title>
</head>
<style>
    h4 {
    margin: 0;
}
.w-full {
    width: 100%;
}
.w-half {
    width: 50%;
}
.margin-top {
    margin-top: 1.25rem;
}
.footer {
    font-size: 0.875rem;
    padding: 1rem;
    background-color: rgb(241 245 249);
}
table {
    width: 100%;
    border-spacing: 0;
}
table.products {
    font-size: 0.875rem;
}
table.products tr {
    background-color: black;
}
table.products th {
    color: #ffffff;
    padding: 0.5rem;
}
table tr.items {
    background-color: rgb(241 245 249);
    text-align: center
}
table tr.items td {
    padding: 0.5rem;
}
.total {
    text-align: right;
    margin-top: 1rem;
    font-size: 0.875rem;
}
</style>
<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <h4>Justkar Tire Supply</h4>
                <h6>Phone: 09123456789</h6>
                <h6>Address: Tandoc Street Pecson Ville Subdivision</h6>
            </td>
            <td class="w-half">
                <h6>TIN: 274-162-585-00000</h6>
                <h6>BIR ATP: OCN 25BAAU20230000007</h6>

            </td>
        </tr>
    </table>
 
    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <h3 style="color: red">Invoice #: {{ $invoiceNo }}</h3>
                    <h5 style="font-style: uppercase">Payment Method: {{$paymentMethod}} 
                        <br>
                    @if($paymentMethod == 'gcash' || $paymentMethod == 'bank'|| $paymentMethod == 'credit_card')
                       Reference No: {{$refNo}}
                    @endif
                    </h5>
                    <div>This receipt is not official, for sales tracking only</div>
                    <div>Date: {{ date('d/m/Y') }}</div>
                </td>
            </tr>
        </table>
    </div>
 
    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Product Name</th>
                <th>Product Type</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
            </tr>
            @foreach($sales as $item)

            <tr class="items">
                    <td>
                        {{ $item->product_name }}
                    </td>
                    <td>
                        {{ $item->product_type }}
                    </td>
                    <td>
                        {{ $item->quantity }}
                    </td>
                    <td>
                        <span style="font-family: DejaVu Sans; sans-serif;"> &#8369;</span>{{ number_format($item->total_price, 2) }}
                    </td>
                    <td>
                        <span style="font-family: DejaVu Sans; sans-serif;"> &#8369;</span>{{ number_format($item->total_price, 2) }}
                    </td>
            </tr>
            @endforeach

        </table>
    </div>
 
    <div class="total">
        @php
           $total = DB::table('order_items')->sum('total_price');

        @endphp
        Total:<span style="font-family: DejaVu Sans; sans-serif;"> &#8369;</span>{{ number_format($total, 2) }} <br>
        @if($paymentMethod == 'cash')
        Amount Paid: <span style="font-family: DejaVu Sans, sans-serif;"> &#8369;</span>{{ number_format( $amountPaid, 2) }} <br>
        <span style="font-family: DejaVu Sans; sans-serif;"> &#8369;</span>{{ number_format($amountPaid, 2) }} - <span style="font-family: DejaVu Sans; sans-serif;"> &#8369;</span>{{ number_format($total, 2) }} = <br>
        Change:<span style="font-family: DejaVu Sans; sans-serif;"> &#8369;</span>{{ number_format($amountPaid - $total, 2) }}
        @endif
    </div>
 
    <div class="footer margin-top">
        <div>Phone: 09123456789</div>
        <div>Tandoc Street Pecson Ville Subdivision</div>

    </div>
</body>
</html>