<div wire:poll.2000ms>

@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        setTimeout(function() {
            document.querySelector('.alert-success').style.display = 'none';
        }, 5000);
    </script>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        setTimeout(function() {
            document.querySelector('.alert-danger').style.display = 'none';
        }, 5000);
    </script>
@endif
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4 mb-2">
                <input type="text" wire:model="search_list" placeholder="Search..." class="form-control mb-3" ">
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
    
    <table class="table table-hover table-bordered caption-top">
        <caption class="text-dark fs-5">List of Available Refund</caption>
        <thead class="table-dark text-center">
            <tr class="text-center text-uppercase" style="white-space: nowrap">
                <th>Transaction No.</th>
                <th scope="col">Ref No.</th>
                <th scope="col">Invoice No.</th>
                <th scope="col">Product Code</th>
                <th scope="col">Product Name</th>
                <th scope="col">Available Quantity</th>
                <th scope="col">Total</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($sales as $item)
                    <tr class="text-center text-uppercase">
                        <td>{{ $item->transaction_no }}</td>
                    @if ($loop->first || $sales[$loop->index - 1]->invoice_no !== $item->invoice_no)
                    @php
                                $rowspan = $sales->where('invoice_no', $item->invoice_no)->count();
                    @endphp
                    <td rowspan="{{ $rowspan }}" class="align-middle border">
                        {{ strtoupper($item->ref_no) }}
                        @if($item->payment->payment_method == 'cash') 
                            <span class="badge bg-success">CASH</span> 
                        @elseif($item->payment->payment_method == 'credit_card')
                            <span class="badge bg-warning">CARD</span>
                        @elseif($item->payment->payment_method == 'gcash')
                            <span class="badge bg-primary">GCASH</span>
                        @elseif($item->payment->payment_method == 'bank')
                            <span class="badge bg-dark">BANK</span>
                        @endif
                    </td>
                @endif
                        @if ($loop->first || $sales[$loop->index - 1]->invoice_no !== $item->invoice_no)
                            @php
                                $rowspan = $sales->where('invoice_no', $item->invoice_no)->count();
                            @endphp
                            <td rowspan="{{ $rowspan }}" class="align-middle border">{{ $item->invoice_no }}</td>
                        @endif
                        <td>{{ $item->product_code }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₱{{number_format($item->total_price, 2) }}</td>
                        <td>{{ $item->created_at ->timezone('Asia/Manila')->format('m/d/Y, h:i A') }}</td>
                        <td>
                            
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $item->id }}">Add to List</button>

                            <!-- Confirm Modal -->
                            <div class="modal fade" id="confirmModal{{ $item->id }}" wire:ignore.self tabindex="-1" aria-labelledby="confirmModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmModalLabel{{ $item->id }}">Add to List of Approval for Refund</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to add this item? <br>
                                            <div class="d-flex justify-content-center">
                                               
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Transaction No.</th>
                                                    <th>Invoice No.</th>
                                                    <th>Product</th>
                                                    <th>Code</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $item->transaction_no }}</td>
                                                    <td>{{ $item->invoice_no }}</td>
                                                    <td>{{ $item->product_name }}</td>
                                                    <td>{{ $item->product_code }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>₱{{ number_format($item->total_price, 2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                           
                                            </div>
                                            <br>
                                            <br>
                                            <label for="refundQuantity">Enter Quantity</label>
                                            <input type="number" wire:model="refundQuantity" class="form-control" required style="width: 30%;margin: 0 auto" min="1">
                                            @error('refundQuantity') <span class="text-danger">{{ $message }}</span> @enderror
                                            <br>
                                            <label for="refundAmount">Enter Amount</label>
                                            <div class="input-group mb-3" style="width: 30%; margin: 0 auto;">
                                                <span class="input-group-text">₱</span>
                                                <input type="number" wire:model="refundAmount" class="form-control" required min="0.01" step="0.01">
                                                @error('refundAmount') <span class="text-danger">{{ $message }}</span> @enderror

                                            </div>
                                            <label for="reason">Reason</label>
                                            <input type="text" wire:model="reason" class="form-control" required style="width: 50%;margin: 0 auto">
                                            @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="close">Cancel</button>
                                            <button type="button" class="btn btn-primary" wire:click="refund({{ $item->id }})" data-bs-dismiss="modal">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
            @endforeach
        </tbody>
    </table>
    {{ $sales->links() }}
    
</div>
