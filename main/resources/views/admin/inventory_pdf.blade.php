<!DOCTYPE html>
<html>
<head>
    <title>Inventory Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
table,th, td{
    border: 1px solid black;   
    padding: 3px;
 
}
</style>
<body>
    <h1>JustKar Inventory Report</h1>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">Product Code</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Type</th>
                <th scope="col">Category</th>
                <th scope="col">Quantity</th>
                <th scope="col">Status</th>
                <th scope="col">Brand</th>
                <th scope="col">Size</th>
                <th scope="col">Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $item)
            <tr>
                <td>{{ $item->product_code }}</td>
                <td>{{ $item->product_name }}</td> 
                <td>{{ $item->product_type }}</td>
                <td>{{ $item->category }}</td>
                <td>{{ $item->quantity }}</td>
                <td>
                    @if($item->quantity == 0)
                    <span class="badge bg-danger">Out of Stock</span>
                    @elseif($item->quantity <= $item->critical_level)
                    <span class="badge bg-warning">Low Stock</span>
                    @else
                    <span class="badge bg-success">In Stock</span>
                    @endif
                </td>
                <td>{{ $item->brand }}</td>
                <td>{{ $item->size }}</td>
                <td>{{ $item->description }}</td>
                <!-- Display more attributes -->
            </tr>
            @endforeach
        </tbody>
    </table>
 
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
