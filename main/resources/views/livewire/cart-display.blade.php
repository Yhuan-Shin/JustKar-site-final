<div wire:poll.3000ms>
    {{-- confirm checkout --}}
    <div class="modal fade" id="confirmCheckoutModal" wire:ignore.self tabindex="-1" aria-labelledby="confirmCheckoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmCheckoutModalLabel">Generate Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        @foreach($orderItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                <h6> {{ $item->product_name }} - {{$item->quantity}}</h6>
                                    <small class="text-muted">{{ $item->size }}</small>
                                </div>
                                <span class="text-muted">₱{{ number_format($item->total_price,2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    @php
                    $total = DB::table('order_items')->sum('total_price');
                    @endphp
                    <p class="text-end mt-2">Total: ₱{{ number_format($total,2) }}</p>

                    <hr>

                    <form action="{{ route('order.checkout') }}" method="POST" autocomplete="off"> 
                        @csrf
                        @method('POST')
                    <h6>Payment Method:</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" wire:model="payment_method" required>
                        <label class="form-check-label" for="cash">
                            Cash
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="gcash" value="gcash" wire:model="payment_method" required>
                        <label class="form-check-label" for="gcash">
                            GCash
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" wire:model.defer="payment_method" required>
                        <label class="form-check-label" for="check">
                             Card
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" id="Bank" value="bank" wire:model.defer="payment_method" required>
                        <label class="form-check-label" for="Bank">
                            Bank Transfer
                        </label>
                    </div>
                    <h6 >Enter Payment Amount</h6>
                    
                    <div class="input-group mb-3">
                        <span class="input-group-text">₱</span>
                       
                            <input type="text" name="amount" wire:model="amount" class="form-control" 
                            aria-label="Dollar amount (with dot and two decimal places)" style="appearance: textfield" 
                            required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                            @if($payment_method === 'gcash' || $payment_method === 'bank' || $payment_method === 'credit_card')
                            placeholder="{{ number_format($total,2) }}"
                            @endif
                            >
                            
                    </div>
                    <label for="ref_no">Reference No:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">REF-</span>
                        <input type="number" onKeyPress="if(this.value.length==30) return false;" name="ref_no" wire:model="ref_no" class="form-control" style="appearance: textfield" required 
                        @if($payment_method === 'cash') 
                        disabled 
                        value=""
                        placeholder="Reference No. for Online Payment Only"
                        @endif>
                    </div>
                    <label for="invoice_no">Invoice No:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">INV-</span>
                        <input type="number" onKeyPress="if(this.value.length==30) return false;" name="invoice_no" wire:model="invoice_no" class="form-control"  style="appearance: textfield"   required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-file-earmark-pdf-fill"></i> Generate Receipt
                    </button>
                 </form>

                </div>
            </div>
        </div>
    </div>
    
    {{-- cart display --}}
    
    @if(session()->has('quantity'))
    <div class="alert alert-warning alert-dismissible fade show">
        {{ session('quantity') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @foreach($orderItems as $item )
    <div class="row mb-4">
        <div class="col-md p-3 text-uppercase" >
            <div class="container">
                <div class="row">
                    <div class="col">
                        <p class="card-text text-start fw-bold">{{ $item->product_name }}</p>
                    </div>
                    <div class="col">
                        <p class="card-text text-end badge bg-primary">₱{{ number_format($item->price,2) }}</p>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <p class="card-text text-start">{{ $item->size}}</p>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <p class="card-text text-start">TOTAL PRICE: </p>
                    </div>
                    <div class="col">
                        <p class="card-text text-end badge bg-primary">{{ $item->quantity }} x ₱{{ number_format($item->total_price,2) }}</p>
                    </div>
            </div>
            <div class="row mt-3">
                    <div class="col">
                          {{-- edit quantity --}}
                              
                                <label for="quantity">Quantity:</label>                        
                                
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group mb-3 col-md-8">
                                            <button type="submit" name="decrement" value="1" wire:click.prevent="decrement({{ $item->id }})" class="btn btn-outline-secondary">-</button>
                                            <input type="number" id="quantity" name="quantity" class="form-control text-center" value="{{ $item->quantity }}" min="1" readonly>
                                            <button type="submit" name="increment" wire:click.prevent="increment({{ $item->id }})" value="1" class="btn btn-outline-secondary">+</button>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <button class="btn btn-danger" type="button" data-bs-target="#modal-delete{{ $item->id}}" data-bs-toggle="modal">Delete</button>
                                    </div>

                                </div>
                    </div>                 
            </div>
        </div>
    </div>
    </div>

        <hr>
@endforeach
@if(!$orderItems->isEmpty())
<button type="button" class="btn btn-primary float-end w-75" data-bs-toggle="modal" data-bs-target="#confirmCheckoutModal"> <i class="bi bi-check-circle-fill"></i> Confirm</button>
@endif

</div>
