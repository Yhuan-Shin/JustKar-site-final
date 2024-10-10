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
            <tr class="items">
                @foreach($sales as $item)
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
                        ₱{{ number_format($item->total_price, 2) }}
                    </td>
                    <td>
                        ₱{{ number_format($item->total_price, 2) }}
                    </td>
                @endforeach
            </tr>
        </table>
    </div>
 
    <div class="total">
        @php
            $total = DB::table('order_items')->sum('total_price');
        @endphp
            Total: ₱{{ number_format($total, 2) }}
    </div>
 
    <div class="footer margin-top">
        <div>Phone: 09123456789</div>
        <div>Tandoc Street Pecson Ville Subdivision</div>

    </div>
</body>
</html>