<div wire:poll.active>
    
    <div>
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
    
        <form wire:submit="submit">
           
            <div class="form-group">
                <label for="product_code">Code</label>
                <input type="text" maxlength="6" id="product_code" class="form-control" wire:model="product_code" required>
                @error('product_code') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
    
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" maxlength="50" id="product_name" class="form-control" wire:model="product_name"required>
                @error('product_name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="product_type">Product Type</label>
                <select class="form-select" name="product_type" id="product_type" wire:model="selectedProduct" required">
                    <option value=""></option>
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
                <input type="number" min="1" value="1" id="quantity" class="form-control" wire:model="quantity" required>
                @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
    
            <div class="form-group">
                <label for="brand">Brand</label>
                <input type="text" maxlength="16" id="brand" class="form-control" wire:model="brand" required>
                @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
    
            <div class="form-group">
                <label for="size">Size</label>
                <input type="text" id="size" class="form-control" wire:model="size" required>
                @error('size') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" id="description" class="form-control" wire:model="description" required>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetForm">Close</button>
                <button type="submit" class="btn btn-success">Add</button>
            </div>

        </form>
    </div>
    <script>

    </script>
</div>
