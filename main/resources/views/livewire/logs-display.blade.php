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
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4 mb-2">
                <input type="text" wire:model="search" placeholder="Search logs..." name="search" id="search" class="form-control">
            </div>
            <div class="col-md-2">
                    <select name="filter" wire:model="filter" class="form-select">
                        <option value="all">All</option>
                        <option value="recent">Recent</option>
                        <option value="lastweek">Last Week</option>
                        <option value="lastmonth">Last Month</option>
                    </select>
            </div>
        </div>
    </div>
   
   <div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="table-dark text-center " style="white-space: nowrap">
            <tr style="white-space: no-wrap">
                <th scope="col">Transaction No</th>
                <th scope="col">Ref. Number</th>
                <th scope="col">Invoice No.</th>
                <th scope="col">Product Code</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Type</th>
                <th scope="col">Brand</th>
                <th scope="col">Sold Quantity</th>
                <th scope="col">Date</th>
                <th scope="col">Total</th>
                <th scope="col">Cashier Name</th>

            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($sales as $log)

            <tr style="white-space: nowrap">
                <td class="border">{{ strtoupper($log->transaction_no) }}</td>
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

                <td>{{ strtoupper($log->product_code) }}</td>
                <td>{{ strtoupper($log->product_name) }}</td>
                <td>{{ strtoupper($log->product_type) }}</td>
                <td>{{ strtoupper($log->brand) }}</td>
                <td>@if($log->quantity == 0) 
                        <span class="badge bg-danger">All of the items was refunded</span>
                    @else
                        {{ $log->quantity }}
                    @endif
                   
                </td>
                <td>{{ $log->created_at ->timezone('Asia/Manila')->format('m/d/Y, h:i A') }}</td>
                <td>
                    @if($log->total_price == 0) 
                        <span class="badge bg-danger">All of the items was refunded</span>
                    @else
                        <span style="font-family: DejaVu Sans; sans-serif;"> &#8369;</span>{{ number_format($log->total_price, 2) }}
                    @endif
                </td>
                <td>{{ strtoupper($log->cashier_name) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
   </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">{{ $sales->links() }}</div>
            <div class="col">
                @if($sales->count() > 0)
                    <form action="{{ route('logs.export') }}" method="GET">
                        <button class="btn btn-danger mb-3 float-end" type="submit"><i class="bi bi-file-pdf-fill"></i> Export to PDF</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

</div>
