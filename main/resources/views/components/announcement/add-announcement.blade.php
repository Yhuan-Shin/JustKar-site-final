{{-- <!-- add announcement --}}
<div class="modal fade" id="announcement" tabindex="-1" aria-labelledby="announcement" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="announcement">Add Announcement</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route('announcement.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="mb-3 ">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" rows="3" name="content" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Attach Image</label>
                    <input type="file"  accept=".jpg,.jpeg,.png."  class="form-control" id="image" name="image" required>
                </div>
                <button type="submit" class="btn btn-primary float-end">Submit</button>
            </form>     
        </div>

      </div>
    </div>
</div>
