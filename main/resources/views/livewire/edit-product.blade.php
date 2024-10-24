<div wire:poll.2000ms>
  {{-- @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif --}}
@foreach ($products as $item)

<div class="modal fade" id="edit-product{{ $item->id }}" wire:ignore.self  tabindex="-1" aria-labelledby="editInfoLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editInfoLabel">Edit Product Information</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form action="{{ route('products.update', $item->id)}}" method="post" enctype="multipart/form-data">
                @csrf
              @method('POST')
              <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="product_name" aria-label="Name" aria-describedby="name-addon" value="{{ $item->product_name }}" required>
              </div>

              <div class="mb-3">
                <label for="size" class="form-label">Size</label>
                <input type="text" class="form-control" id="size" oninput="this.value = this.value.replace(/\s/g, '')" name="size" aria-label="Size" aria-describedby="size-addon" value="{{ $item->size }}" required>
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend3">₱</span>
                    <input type="number" class="form-control" min="1" onKeyPress="if(this.value.length==5) return false;" id="price" name="price" aria-label="Price" aria-describedby="inputGroupPrepend3" value="{{ $item->price }}" required>
                </div>
              </div>
              <div class="mb-3">
                <label for="discount" class="form-label">Discount</label>
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend3">%</span>
                    <input type="number" class="form-control" onKeyPress="if(this.value.length==3) return false;" value="{{ $item->discount }}" id="discount" name="discount" aria-label="Discount" aria-describedby="inputGroupPrepend3" value="{{ $item->discount }}" >
                </div>
              </div>
              
              <div class="mb-3">
                  <label for="image" class="form-label">Image</label>
                  <input type="file" class="form-control" accept=".jpg,.jpeg,.png. "id="product_image" name="product_image" value="{{ $item->product_image }}">
              </div>
              <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <input type="text" class="form-control" id="description"  value="{{ $item->description }}" name="description">
              </div>
              <button type="submit" class="btn btn-primary float-end" id="submitBtn">Set</button>
            </form>
        </div>
      </div>
    </div>
</div>
@endforeach

</div>
