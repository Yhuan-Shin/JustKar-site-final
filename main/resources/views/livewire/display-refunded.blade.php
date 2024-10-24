<div wire:poll.3000ms>
    {{-- The Master doesn't talk, he acts. --}}
    <table class="table table-hover table-bordered caption-top">
        <caption class="text-dark fs-5">List of Refunded Items</caption>

        <thead class="table-dark text-center">
            <tr>
                <th class="col">Invoice No.</th>
                <th class="col">Transaction No.</th>
                <th class="col">Product Code</th>
                <th class="col">Refunded Quantity</th>
                <th class="col">Reason</th>
                <th class="col">Refunded Amount</th>
                <th class="col">Refunded Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($refunded as $refund)
                <tr class="text-center">
                    @if ($loop->first || $refunded[$loop->index - 1]->invoice_no !== $refund->invoice_no)
                        @php
                            $rowspan = $refunded->where('invoice_no', $refund->invoice_no)->count();
                        @endphp
                        <td rowspan="{{ $rowspan }}" class="align-middle border">{{ $refund->invoice_no }}</td>
                    @endif
                    <td >{{ $refund->transaction_no }}</td>
                    <td >{{ $refund->product_code }}</td>
                    <td >{{ $refund->quantity }}</td>
                    <td >{{ $refund->reason }}</td>
                    <td >₱{{ number_format($refund->amount, 2) }}</td>
                    <td >{{ $refund->updated_at->timezone('Asia/Manila')->format('m/d/Y, h:i A') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

