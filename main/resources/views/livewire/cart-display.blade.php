<div wire:poll.3000ms>
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
        <hr>
@endforeach
@if(!$orderItems->isEmpty())
<button type="button" class="btn btn-primary float-end w-75" data-bs-toggle="modal" data-bs-target="#confirmCheckoutModal"> <i class="bi bi-bag-check-fill"></i> Checkout</button>
@endif

</div>
