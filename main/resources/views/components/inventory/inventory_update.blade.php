  @livewireStyles
  @foreach($inventory as $item)
    <div class="modal fade " id="modal-update{{$item->id}}" wire:ignore tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Product</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <livewire:edit-inventory :inventory="$item" :wire:key="'edit-inventory-'.$item->id" />
              </div>
          </div>
        </div>
      </div>
  @endforeach

  @livewireScripts
