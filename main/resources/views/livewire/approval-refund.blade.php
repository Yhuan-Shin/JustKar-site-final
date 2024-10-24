
<div wire:poll.3000ms>
@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div>
    <input type="text" wire:model="search_refund" placeholder="Search..." class="form-control mb-3" style="width: 20%;">
</div>
    <table class="table table-hover table-bordered">
                        <thead class="table-dark text-center">
                            <tr>
                                <th scope="col">Transaction No.</th>
                                <th scope="col">Invoice No.</th>
                                <th scope="col">Product Code</th>
                                <th scope="col">Refund Quantity</th>
                                <th scope="col">Reason</th>
                                <th scope="col">Refund Amount</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse ($refunds as $refund)
                                <tr>
                                    <td>{{ $refund->transaction_no }}</td>
                                    @if($loop->first || $refunds[$loop->index - 1]->invoice_no !== $refund->invoice_no)
                                        @php
                                            $rowspan = $refunds->where('invoice_no', $refund->invoice_no)->count();
                                        @endphp
                                        <td rowspan="{{ $rowspan }}" class="align-middle border">{{ $refund->invoice_no }}</td>
                                    @endif
                                    <td>{{ $refund->product_code }}</td>
                                    <td>{{ $refund->quantity }}</td>
                                    <td>{{ $refund->reason }}</td>
                                    <td>₱{{ number_format($refund->amount, 2) }}</td>
                                    <td>{{ $refund->created_at->format('Y-m-d') }}</td>
                                    <td><button class="btn btn-danger" wire:click="decline({{ $refund->id }})">Decline</button>
                                        <button class="btn btn-primary" wire:click="approve({{ $refund->id }})">Approve</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No refunded items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
    </table>
    {{ $refunds->links() }}
</div>
