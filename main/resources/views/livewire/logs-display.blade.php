<div wire:poll.2000ms>
    @if (session()->has('warning'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('warning') }}
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-2">
                <input type="text" wire:model="search" placeholder="Search logs..." name="search" id="search" class="form-control">
            </div>
            <div class="col-md-4">
                <form method="GET" class="col-md mb-3 float-end">
                    <select name="filter" wire:model="filter" class="form-select">
                        <option value="all">All</option>
                        <option value="recent">Recent</option>
                        <option value="lastweek">Last Week</option>
                        <option value="lastmonth">Last Month</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
   
    <table class="table table-hover table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th scope="col">Ref. Number</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Type</th>
                <th scope="col">Brand</th>
                <th scope="col">Quantity</th>
                <th scope="col">Date</th>
                <th scope="col">Total</th>
                <th scope="col">Cashier Name</th>

            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($sales as $log)

            <tr>
                <td>{{ strtoupper($log->ref_no) }}</td>
                <td>{{ strtoupper($log->product_name) }}</td>
                <td>{{ strtoupper($log->product_type) }}</td>
                <td>{{ strtoupper($log->brand) }}</td>
                <td>{{ strtoupper($log->quantity) }}</td>
                <td>{{ $log->created_at ->timezone('Asia/Manila')->format('m/d/Y, h:i A') }}</td>
                <td>₱{{ number_format($log->total_price, 2) }}</td>
                <td>{{ strtoupper($log->cashier_name) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">{{ $sales->links() }}</div>
            <div class="col">
                <form action="{{ route('logs.export') }}" method="GET">
                    <button class="btn btn-danger mb-3 float-end" type="submit"><i class="bi bi-file-pdf-fill"></i> Export to PDF</button>
                </form>
            </div>
        </div>
        <div class="row">
            
        </div>
    </div>

</div>
