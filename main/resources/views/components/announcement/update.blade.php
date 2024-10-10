@foreach($announcements as $item) 
<div class="modal fade" id="edit-announcement{{ $item->id }}" tabindex="-1" aria-labelledby="editAnnouncementLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAnnouncementLabel">Edit Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('announcement.update', $item->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 ">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $item->title}}">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" rows="3" name="content">{{ $item->content}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Attach Image</label>
                        <input type="file" class="form-control" id="image" accept=".jpg,.jpeg,.png" name="image">
                        <img src="{{asset('uploads/images/'.$item->image)}}"  width="150px" height="100px">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
            </div>
                </form>
</div>
</div>
</div>
@endforeach