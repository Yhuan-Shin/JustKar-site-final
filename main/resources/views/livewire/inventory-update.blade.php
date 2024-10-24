<div>
                   
    <div class="modal fade " tabindex="-1" wire:ignore.self aria-hidden="true" id="editModal" aria-labelledby="editInventoryModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInventoryModalLabel">Edit Inventory Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('update_success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('update_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session()->has('update_error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('update_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div wire:loading wire:target="update" class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <form wire:submit.prevent="update">
                        @csrf
                        <div class="form-group">
                            <fieldset disabled="disabled">
                                <label for="product_code">Product Code</label>
                                <input type="text" class="form-control" id="product_code" wire:model="product_code" readonly>
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" maxlength="50" class="form-control" id="product_name" wire:model="product_name" required>
                            @error('product_code') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="product_type">Product Type</label>
                            <select class="form-select" wire:model.live="selectedProduct" name="product_type" id="product_type" required>
                                <option value="">Select Product Type</option>
                                @foreach($product_types as $item)
                                    <option value="{{ $item->id }}">{{ $item->product_type }}</option>
                                @endforeach
                                {{$selectedProduct}}
                            </select>
                            @error('product_type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" wire:model="selectedCategory" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $item)
                                    <option value="{{ $item->id}}">{{ $item->category }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" min="1" class="form-control" id="quantity" wire:model="quantity" required>
                            @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input type="text" maxlength="16" class="form-control" id="brand" wire:model="brand" required>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                            <button type="submit" class="btn btn-success" wire:click="update">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('open-modal', event => {
            $('#editModal').modal('show');
        });
        window.addEventListener('closeEditModal', event => {
            $('#editModal').modal('hide');
        });
    </script>
</div>
