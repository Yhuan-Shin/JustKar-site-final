
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@livewireStyles
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-dark bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img src="{{ asset('images/logo.png') }}" alt="" style="width: 60px; height: 60px"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ">
              <li class="nav-item">
                <a class="nav-link text-white text-center" href="#"> 
                    <i class="bi bi-person-circle"></i>
                    <span class="text-white">
                        @if (Auth::check())
                            <span class="mx-1 ">
                            @if (Auth::guard('cashier')->check())
                                {{ Auth::guard('cashier')->user()->username }}
                            @endif</span>
                        @else
                            <span class="mx-1">Guest</span>
                        @endif
    
                    </span>
                </a>
              </li>
              <li class="nav-item d-flex justify-content-center">
                <button type="button" class="btn btn-danger col-md" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    Logout
                </button>

                <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-dark" id="logoutModalLabel">Logout</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-dark">
                                Are you sure you want to logout?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="{{ route('user.logout') }}">
                                    <button type="button" class="btn btn-danger">Logout</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- confirm checkout --}}
                <div class="modal fade" id="confirmCheckoutModal" tabindex="-1" aria-labelledby="confirmCheckoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmCheckoutModalLabel">Confirm Checkout</h5>
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

                                <h6 class="text-center">Enter Payment Amount</h6>

                                <div class="input-group mb-3">
                        
                                    <span class="input-group-text">₱</span>
                                    <form action="{{ route('order.checkout') }}" method="POST"> 
                                        @csrf
                                        @method('POST')
                                    <input type="number" name="amount" wire:model="amount" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" style="appearance: textfield" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Checkout</button>
                             </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>     
      <div class="container-fluid">
            <div class="col">
                <div class="container">
                    <div class="row ">
                        <div class="col-md-8 ">
                            <div class="container">
                                @foreach($orderItems as $item)
                                    <div class="modal fade" id="modal-delete{{ $item->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this item from the cart?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('order.destroy', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"  class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- @if (session('success')) --}}
                                @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show mt-3">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                



                                @if (session('error'))
                                    <div class="alert alert-danger  alert-dismissible fade show mt-3" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                    
                                {{-- display product --}}
                                <div class="row mt-3">
                                 @livewire('order-display')
                                  
                                </div>
                             
                            </div>
                        </div>

                        {{-- display orders --}}
                        <div class="col-md-4  mt-2 p-3 rounded float-end">
                            <h4 class="text-center mt-5"> <i class="bi bi-bag-fill"></i> Orders</h4>
                        @if(!empty($orderItems) && $orderItems->count($orderItems) > 0)
                             @livewire('cart-display')
                        @else
                            <h6 class="text-center text-danger"> <i class="bi bi-exclamation-circle-fill"></i> Your cart is empty</h6>
                        @endif
                       
                      
                    </div>
                </div>
            </div>
    </div>

    <!-- End of sidebar -->
    @livewireScripts
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
