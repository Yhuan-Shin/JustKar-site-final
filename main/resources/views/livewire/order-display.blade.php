<div wire:poll.3000ms>
    <div class="row ">
        @forelse ($product as $item)
            <div class="col-md">
                {{-- card --}}
                <div class="card mb-2 text-center text-uppercase" style="width: 16rem;">
                    <div class="card-body"> 

                        @if($item->product_image == null)
                        <p class="alert alert-danger">No Image</p>
                       @elseif($item->product_image != null)
                       <img src="{{asset('uploads/product_images/'.$item->product_image)}}" class="card-img-top" alt="..."style="height: 70px; width: 70px">
                       @endif
                       <h5 class="card-title">{{$item->product_name}}</h5>
                       <p class="card-text badge bg-primary">{{ $item->product_type }}</p>

                           @if($item->quantity == 0)
                           <span class="badge bg-danger">Out of Stock</span>
                           @elseif($item->quantity <= $item->critical_level)
                           <span class="badge bg-warning">Low Stock <span class="badge bg-dark">{{$item->quantity}}</span></span>
                           @elseif($item->quantity > $item->critical_level)
                           <span class="badge bg-success">In Stock <span class="badge bg-dark">{{$item->quantity}}</span></span>
                           @endif
                           {{-- get the quantity --}}


                           <div class="container">
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <p class="card-text badge bg-primary">{{ $item->category }}</p>
                                </div>
                                <div class="col-md-8 ">
                                    <p class="card-text">{{ $item->size }}</p>
                                </div>
                            </div>
                            <div class="row mb-2 border rounded">
                                <div class="col">
                                    <p class="card-text">{{ $item->description }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="container d-flex justify-content-center">
                           <div class="row">
                            <div class="col">
                                 @if($item->price == null)
                                <p class="alert alert-danger">No Price Set</p>
                                @elseif($item->price != null)
                                <p class="card-text text-start badge bg-success">₱{{ number_format($item->price,2) }}</p>
                                @endif
                            </div>
                            <div class="col">
                                <form action="{{ route('order.store', $item->id) }}" method="POST">
                                    @csrf
                                        <button type="submit" class="btn btn-primary" >Add</button>
                                </form>
                            </div>
                    
                           </div>
                    </div>
                </div>
            </div>
            </div>
      
        
            {{-- end card --}}
            
        @empty
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fs-4 bi bi-exclamation-circle-fill p-3"></i> No items in inventory
            </div>
            
        @endforelse
        </div>
</div>
