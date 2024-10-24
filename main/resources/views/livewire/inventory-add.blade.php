<div wire:poll.3000ms>
    
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inventoryAddModal">
        <i class="bi bi-plus-circle"></i> Add Product 
    </button>

    <!-- Create Modal -->
    <div class="modal fade" id="inventoryAddModal" wire:ignore.self tabindex="-1" aria-labelledby="inventoryAddModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inventoryAddModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="submit">
                        @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                        <div class="form-group">
                            <label for="product_code">Code</label>
                            <input type="text" maxlength="6" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()" id="product_code" class="form-control" wire:model="product_code" required>
                            @error('product_code') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" maxlength="50" id="product_name" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()" class="form-control" wire:model="product_name" required>
                            @error('product_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="product_type">Product Type</label>
                            <select class="form-select" name="product_type" id="product_type" wire:model="selectedProduct" required>
                                <option value="">Select Product Type</option>
                                @foreach($product_type as $item)
                                    <option value="{{ $item->id }}">{{ $item->product_type }}</option>
                                @endforeach
                            </select>
                            @error('product_type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        @if(!is_null($categories))
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select id="category" wire:model="selectedCategory" required class="form-select">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $item)
                                        <option value="{{ $item->id}}">{{ $item->category }}</option>
                                    @endforeach
                                </select>
                                @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" min="1" value="1" id="quantity" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()" class="form-control" wire:model="quantity" required>
                            @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input type="text" maxlength="16" id="brand" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()" class="form-control" wire:model="brand" required>
                            @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                
                        <div class="form-group">
                            <label for="size">Size</label>
                            <input type="text" id="size" class="form-control" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()" wire:model="size" required oninput="this.value = this.value.replace(/\s/g, '')">
                            @error('size') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" id="description" class="form-control" style="text-transform:uppercase" oninput="this.value = this.value.toUpperCase()" wire:model="description" oninput="this.value = this.value.replace(/\s/g, '')" required>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="close">Close</button>
                    <button type="button" class="btn btn-success" wire:click="submit" data-bs-dismiss="modal">Add</button>
                </div>
            </div>
        </div>
    </div>

</div>
