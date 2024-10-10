<div wire:poll.3000ms>
      <!-- Delete Confirmation Modal -->
      @foreach($inventory as $item)
        <div class="modal fade" id="modal-delete{{ $item->id }}" wire:ignore tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this item?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('inventory.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      @endforeach
    <div class="container" style="padding: 0px; width: 100%;">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">

                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show">

                {{ session('error') }}
            </div>
        @endif
        @if($inventory->isEmpty() && $search)
            <div class="alert alert-warning mt-4" role="alert">
                No results found for "{{ $search }}".
            </div>
        @endif
        <div class="row">
            <div class="col-md">
                <input type="checkbox" wire:model="selectAll"> Select All
            </div>
            <div class="col-md mb-2">
                <input type="text" wire:model="search" placeholder="Search product..." name="search" id="search" class="form-control">
            </div>
            <div class="col-md">
                {{-- call the inventory add component --}}
                <button class="btn btn-success float-end" type="submit" data-bs-target="#add-product" data-bs-toggle="modal"><i class="bi bi-plus-circle"></i> Add Product</button> 
            </div>
            <div class="col-md">
                    <button wire:click="archiveSelected" class="btn btn-warning">    
                        <i class="bi bi-archive"></i> Archive</button>
            </div>
            <div class="col-md-4">
                <form method="GET" class="col-md mb-3 float-end">
                    <select name="filter" wire:model="filter" class="form-select">
                        <option value="all">All</option>
                        <option value="instock">In Stock</option>
                        <option value="lowstock">Low Stock</option>
                        <option value="outofstock">Out of Stock</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="row" style="padding: 0px">
            <div class="col-md-12">
                <div class="table-responsive mt-3 border rounded p-2 shadow">
                    <!-- table -->
                    <table class="table table-striped table-hover">
                     <thead class="table-dark   ">
                       <tr class="text-center" style="white-space: nowrap;">
                         <th scope="col" >Product Code</th>
                         <th scope="col">Product Name</th>
                         <th scope="col" >Product Type</th>
                         <th scope="col">Category</th>
                         <th scope="col">Quantity</th>
                         <th scope="col">Status</th>
                         <th scope="col">Brand</th>
                         <th scope="col">Size</th>
                         <th scope="col">Description</th>
                         <th scope="col">Actions</th>
            
                       </tr>
                     </thead>
                     <tbody>
            
                         @if(isset($error))
                             <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                 {{ $error }}
                                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                             </div>
                         @endif
                         {{-- row --}}
                         
                       
                         @forelse($inventory as $item)
                         <tr class="text-center" style="white-space: nowrap;">
                             <th scope="row">
                                <input type="checkbox" wire:model="selectedItems" value="{{ $item->id }}"> {{ $item->product_code }}
                            </th>
                             <td class="text-uppercase" >{{ $item->product_name }}</td>
                             <td class="text-uppercase">{{ $item->product_type }}</td>
                             <td>{{ $item->category }}</td>
                           
                             <td>{{ $item->quantity }}</td>
                             <td>
                                 @if($item->quantity == 0)
                                     <span class="badge bg-danger">Out of Stock</span>
                                 @elseif($item->quantity <= $item->critical_level)
                                     <span class="badge bg-warning">Low Stock</span>
                                 @elseif($item->quantity > $item->critical_level)
                                     <span class="badge bg-success">In Stock</span>
                                 @endif
                             </td>
                             <td class="text-uppercase">{{ $item->brand }}</td>
                             <td class="text-uppercase">{{ $item->size }}</td>
                             <td class="text-uppercase">{{ $item->description }}</td>
                             <td style="white-space: nowrap">
                                 <div class="btn-group" role="group" aria-label="Basic example">
                                     <button type="button" class="btn btn-primary" data-bs-target="#modal-update{{ $item->id}}" data-bs-toggle="modal" value="{{ $item->id }}"><i class="bi bi-pencil-square"></i></button>
                                     <button class="btn btn-danger" type="button" data-bs-target="#modal-delete{{ $item->id}}" data-bs-toggle="modal"><i class="bi bi-trash3-fill"></i></button>
                                 </div>
                                 </td>
                         </tr>
                         @empty
                         <tr>
                             <td colspan="9" class="text-center">No records found</td>
                         </tr>
                         @endforelse
                       </tbody>
                   </table>
                  
                   <div class="container">
                        <div class="row ">

                            <div class="col-md d-flex  justify-content-end">
                                <div class="btn-group " role="group" aria-label="Basic example">
                                    <a href="{{ route('inventory.archived')}}" class="btn btn-primary me-2"><i class="bi bi-binoculars-fill"></i> View Archived</a>

                                    <form action="{{ route('inventory.export')}}" method="GET">
                                        <button class="btn btn-danger">
                                            <i class="bi bi-file-pdf-fill"></i> Export to PDF</button>
                                    </form>   
                                </div>   
                            </div>
                            {{-- <div class="col">
                                <a  href="{{ route('inventory.exportToExcel')}}" class="btn btn-outline-success">Export to Excel</a>
                            </div> --}}
                        
                        </div>
                        <div class="row">
                            <div class="col">
                                {{ $inventory->links() }}

                            </div>
                        </div>

                   </div>
                 <!--  end table -->
                 </div>
                </div>
            
            </div>
        </div>
    {{-- modal update product --}}
    @include('components/inventory/inventory_update')
    {{-- end modal --}}
 
   
</div>

{{-- If you're not using Pusher, you can remove or comment out these scripts --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/pusher-js@latest/dist/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@latest/dist/echo.min.js"></script> --}}
