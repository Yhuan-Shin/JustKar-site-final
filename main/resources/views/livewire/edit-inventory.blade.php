<div wire:poll.2000ms>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show">
                {{-- product code display --}}

                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session()->has('error'))
         <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       @endif
    </div>
    <form wire:submit.prevent="update">
        <div class="form-group">
            <fieldset disabled="disabled">
                <label for="product_code">Product Code</label>
                <input type="text" class="form-control"  id="product_code" wire:model="product_code" value="{{ $product_code }}"  readonly>
            </fieldset>
        </div>
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" maxlength="50" class="form-control" id="product_name" wire:model="product_name" required>
            @error('product_code') <span class="text-danger">{{ $message }}</span> @enderror

        </div>
        <div class="form-group">
            <label for="product_type">Product Type</label>
            <select class="form-select" wire:model="selectedProduct" name="product_type" id="product_type" required >
                <option value="" >Select Product Type</option>
                @foreach($productTypes as $item)
                    <option value="{{ $item->id }}">{{ $item->product_type }}</option>
                @endforeach
                {{$selectedProduct}}

            </select>
            @error('product_type') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        @if(!is_null($categories))
        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" wire:model="selectedCategory" class="form-select" required>
                <option value="" >Select Category</option>
                @foreach($categories as $item)
                    <option value="{{ $item->id}}">{{ $item->category }}</option>
                @endforeach
            </select>
            @error('category') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    @endif
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" min="1" class="form-control" id="quantity"  wire:model="quantity" required ">
            @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror

        </div>
        <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" maxlength="16"  class="form-control" id="brand" wire:model="brand" required>
            @error('brand') <span class="text-danger">{{ $message }}</span> @enderror

        </div>
        <div class="form-group">
            <label for="size">Size</label>
            <input type="text" class="form-control" id="size" wire:model="size" required>
            @error('size') <span class="text-danger">{{ $message }}</span> @enderror

        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" id="description" class="form-control" wire:model="description" required>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="$dispatch('close-modal')">Close</button>
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>

</div>

