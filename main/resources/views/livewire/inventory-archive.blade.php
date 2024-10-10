<div wire:poll.3000ms>
    <div class="container mt-3">
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('success') }}
        </div>
        @endif

        @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('error') }}
        </div>
        @endif

        <div class="row">
            <div class="col-md">
                <input type="checkbox" wire:model="selectAll"> Select All
            </div>
            <div class="col-md mb-2">
                <input type="text" wire:model="searchArchive" placeholder="Search product..." name="searchArchive" id="searchArchive" class="form-control">
            </div>
            
            <div class="col-md">
                <button wire:click="unarchiveSelected" class="btn btn-success">
                    <i class="bi bi-archive-fill"></i> Restore
                </button>
            </div>
            <div class="col-md-4">
                <form method="GET" class="col-md mb-3 float-end">
                    <select name="archiveFilter" wire:model="archiveFilter" class="form-select">
                        <option value="">Select Stock Status</option>
                        <option value="all">All</option>
                        <option value="instock">In Stock</option>
                        <option value="lowstock">Low Stock</option>
                        <option value="outofstock">Out of Stock</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <!-- table -->
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th scope="col">Product Code</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Type</th>
                                <th scope="col">Category</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Status</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Size</th>
                                <th scope="col">Description</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($inventoryArchived as $item)
                            <tr class="text-center">
                                <th scope="row">
                                    <input type="checkbox" wire:model="selectedItems" value="{{ $item->id }}"> 
                                    {{ $item->product_code }}
                                </th>
                                <td class="text-uppercase">{{ $item->product_name }}</td>
                                <td>{{ $item->product_type }}</td>
                                <td class="text-uppercase">{{ $item->category }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    @if($item->quantity == 0)
                                    <span class="badge bg-danger">Out of Stock</span>
                                    @elseif($item->quantity <= $item->critical_level)
                                    <span class="badge bg-warning">Low Stock</span>
                                    @else
                                    <span class="badge bg-success">In Stock</span>
                                    @endif
                                </td>
                                <td class="text-uppercase">{{ $item->brand }}</td>
                                <td>{{ $item->size }}</td>
                                <td>{{ $item->description }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No records found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- end table -->
                    <div class="container d-flex justify-content-end">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('inventory.display') }}" class="btn btn-primary float-end"> Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

