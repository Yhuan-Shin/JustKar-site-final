<div wire:poll.3000ms="updateQuantity">
    <h5>Overview</h5>
    Instock
    @if ($quantity > 0)
        <p class="badge bg-success">{{ $quantity }}</p>
    @else
        <div class="badge bg-danger">No Items Available</div>
    @endif
    <p >By Category</p>
    <div wire:poll.3000ms="updateCategories">
        @foreach($categories as $category => $quantity)
           <div class="container">
            <div class="row">
                <div class="col">
                     <p class="badge bg-primary" style="white-space: nowrap">{{ $category }}</p>
                </div>
                <div class="col">
                    <p class="badge bg-success">{{ $quantity }}</p>

                </div>
            </div>
           </div>
        @endforeach
    </div>
    
</div>
