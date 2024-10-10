
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Managament</title>
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

    <!-- sidebar -->
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark collapse collapse-horizontal show border-end" id="sidebar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <div class="container">
                       <div class="row">
                            <div class="col d-flex align-items-center">
                                <a href="/superadmin/user_management" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                                <div class="container">
                                    <img src="/images/logo.png" alt="" style="width: 60px; height: 60px">
                                </div>
                            </a>
                        </div>
                     
                       </div>
                    </div>
            
                    @include('components/superadmin/nav')
                    
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
                                            <button class="btn btn-outline-dark" data-bs-target="#sidebar" data-bs-toggle="collapse"><i class="bi bi-list bi-lg py-2 p-1"></i>Menu</button>
                                        </div>
                                        
                                        <div class="col text-end m-2">
                                            <i class="bi bi-person-circle"></i>
                                            <span class="d-none d-sm-inline text-dark mx-1">{{ Auth::guard('superadmin')->user()->name }}</span>
                                        </div>                                        
                                </div>

                                <div class="row bg-light p-2 rounded">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col">
                                                {{-- content --}}

                                                
                                                @if(session()->has('success'))
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                 {{ session('success') }}
                                                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                               </div>
                                               @endif

                                               @if($errors->any())
                                               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                   @if ($errors->has('username'))
                                                       <div>{{ $errors->first('username') }}</div>
                                                   @endif
                                                   @if ($errors->has('password'))
                                                       <div>{{ $errors->first('password') }}</div>
                                                   @endif
                                                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                               </div>
                                               
                                                </div>
                                               @endif
                                               
                                               @if(session()->has('error'))
                                               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                   {{session('error') }}
                                                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                               </div>
                                               @endif
                                               @include('components/superadmin/update-admin')
                                               <button type="button" class="btn btn-outline-success float-end mb-3" data-bs-target="#add-admin" data-bs-toggle="modal"><i class=" py-2 bi bi-plus-circle"></i> Add Admin</button>
                                                <table class="table table-hover table-responsive">

                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Username</th>
                                                            <th scope="col">Date Created</th>
                                                            <th scope="col">Date Updated</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Action</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                                                                        

                                                       {{-- display data--}}
                                                       @foreach ($admins as $admin)

                                                       <tr>
                                                           <td>{{ $admin->name }}</td>
                                                           <td>{{ $admin->username }}</td>
                                                           <td>{{ $admin->created_at->timezone('Asia/Manila')->format('h:i A, d/m/Y') }}</td>
                                                           <td>{{ $admin->updated_at->timezone('Asia/Manila')->format('h:i A, d/m/Y') }}</td>
                                                           <td>
                                                                @if($admin->archive == 0)
                                                                    <span class="badge bg-success">Active</span>
                                                                @else 
                                                                    <span class="badge bg-danger">Archived</span> 
                                                                @endif
                                                            </td>
                                                           <td>
                                                            <button type="button" class="btn btn-primary " data-bs-target="#edit-admin{{$admin->id}}" data-bs-toggle="modal" value="{{ $admin->id }}"><i class="bi bi-pencil-square"></i></button>

                                                            {{-- <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger "> <i class="bi bi-trash"></i></button>
                                                            </form> --}}
                                                            @if($admin->archive == 0)
                                                            <form action="{{ route('admin.archive', $admin->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-warning "><i class="bi bi-archive"></i></button>
                                                            </form>
                                                           </td>
                                                           @endif
                                                           @if($admin->archive == 1)
                                                           <form action="{{ route('admin.restore', $admin->id) }}" method="POST" style="display:inline;">
                                                               @csrf
                                                               <button type="submit" class="btn btn-success "><i class="bi bi-arrow-clockwise"></i></button>
                                                           </form>
                                                           @endif
                                                       </tr>
                                                       @endforeach
                                                    </tbody>
                                                </table>
                                             


                                            </div>
                                            
                                        </div>
                                        @include('components/superadmin/add-admin')

                                    </div>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    
    </body>

</html>
