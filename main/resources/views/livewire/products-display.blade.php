<div wire:poll.3000ms>
    @include('components/products/editInfo')
   <div class="container">
    <div class="row mb-4 justify-content-center">
        <div class="col-md-4">
            <input type="text" wire:model="search" placeholder="Search product..." name="search" id="search" class="form-control">
        </div>
    </div>
   </div>
    <div class="row">
        @forelse ($products as $item)
            <div class="col-md-4 d-flex justify-content-center">
                {{-- card --}}
                <div class="card p-3 mb-3 text-center text-uppercase" style="width: 18rem;">
                    <div class="card-body"> 
                        <div class="container mb-2">
                            @if($item->product_image == null)
                            <p class="alert alert-danger" >No Image</p>
                            @elseif($item->product_image != null)
                            <img src="{{asset('uploads/product_images/'.$item->product_image)}}" class="card-img-top img-fluid rounded" alt="..." >
                            @endif
                            <p class="badge bg-dark">{{ $item->product_type }}</p>
                            <p class="badge bg-primary">{{ $item->product_code }}</p>
                            <h5 class="card-title">{{  $item->product_name}}</h5>
                             <div class="container mb-2">
                                @if($item->quantity == 0)
                                <span class="badge bg-danger">Out of Stock</span>
                                @elseif($item->quantity <= $item->critical_level)
                                <span class="badge bg-warning">Low Stock
                                </span>
                                @elseif($item->quantity > $item->critical_level)
                                <span class="badge bg-success">In Stock</span>
                                @endif
                             </div>
                            <div class="container ">
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <p class="card-text badge bg-primary">{{ $item->category }}</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="card-text badge bg-primary">{{ $item->size }}</p>
                                    </div>
                                </div>
                                <div class="row mb-2 border rounded">
                                    <div class="col">
                                        @if($item->description == null)
                                        <p class="badge bg-danger">No Description</p>
                                        @elseif($item->description != null)
                                        <p class="card-text text-start">{{ $item->description }}</p>
                                        @endif
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
                                    <button class="btn btn-primary" data-bs-target="#editInfo{{ $item->id }}" data-bs-toggle="modal">Edit</button>
                                </div>
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

