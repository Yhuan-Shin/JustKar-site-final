
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Announcements</title>
    <link rel="icon" type="image/x-icon" href="/images/logo.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <!-- sidebar -->
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark collapse collapse-horizontal show border-end" id="sidebar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <div class="container">
                       <div class="row">
                            <div class="col d-flex align-items-center">
                                <a href="/admin/dashboard" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                                <div class="container">
                                    <img src="/images/logo.png" alt="" style="width: 60px; height: 60px">
                                </div>
                            </a>
                        </div>
                     
                       </div>
                    </div>
            
                    @include('components/navigation')
                    <hr>
                    
                    
                  
                </div>
            </div>
            <!-- content -->
            <div class="col">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="container">
                                <div class="row">
                                        <div class="col m-2">
                                            <button class="btn btn-outline-dark" data-bs-target="#sidebar" data-bs-toggle="collapse"><i class="bi bi-list bi-lg py-2 p-1"></i> Menu</button>

                                        </div>
                                        <div class="col text-end m-2">
                                            <i class="bi bi-person-circle"></i>
                                            @include('components/profile/user')

                                           </div>
                                </div>
                                <div class="row">
                                    <div class="container">
                                    @foreach($announcements as $announcement)
                                    <div class="modal fade" id="modal-delete{{ $announcement->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this announcement?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('announcement.destroy', $announcement->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                        <div class="row d-flex justify-content-center ">
                                            <div class="col-md-12 mb-2 ">
                                                @include('components/announcement/add-announcement')  
                                                @include('components/announcement/update')        
      
                                                <button type="button" class="btn btn-outline-success float-end" data-bs-target="#announcement" data-bs-toggle="modal">Create Announcement</button>                                  
                                            </div>
                                          
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table table-striped">
                                        <thead class="table-dark text-center">
                                          <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Content</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($announcements as $announcement)
                                          <tr class="text-center">
                                            <td>{{$announcement->title}}</td>
                                            <td>{{$announcement->content}}</td>
                                            <td><img src="{{asset('uploads/images/'.$announcement->image)}}" alt="" width="150px" height="100px"></td>
                                            <td>
                                                <button type="button" class="btn btn-primary " data-bs-target="#edit-announcement{{$announcement->id}}" data-bs-toggle="modal" value="{{ $announcement->id }}"><i class="bi bi-pencil-square"></i></button>
                                               <button type="button" class="btn btn-danger" data-bs-target="#modal-delete{{ $announcement->id }}" data-bs-toggle="modal"><i class="bi bi-trash"></i></button>
                                            </td>
                                          </tr>
                                          @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- End of sidebar -->
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
