
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Managament</title>
    <link rel="icon" type="image/x-icon" href="/images/logo.png">

    <link rel="stylesheet" href="/style.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

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
                                            <button class="btn btn-outline-dark" data-bs-target="#sidebar" data-bs-toggle="collapse"><i class="bi bi-list bi-lg py-2 p-1"></i>Menu</button>
                                        </div>
                                        
                                        <div class="col text-end m-2">
                                            <i class="bi bi-person-circle"></i>
                                            @include('components/profile/user')

                                        </div>
                                        
                                </div>

                                <div class="row bg-light p-2 rounded">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col">
                                                {{-- content --}}
                                    <!-- Delete Confirmation Modal -->
                                    @foreach($cashiers as $cashier)
                                    <div class="modal fade" id="modal-delete{{ $cashier->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this account?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('cashier.destroy', $cashier->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                                <button type="button" class="btn btn-outline-success float-end mb-3" data-bs-target="#add-cashier" data-bs-toggle="modal"><i class=" py-2 bi bi-plus-circle"></i> Add Cashier</button>

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
                                                <table class="table table-hover table-striped table-responsive">

                                                    <thead class="table-dark text-center">
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

                                                       @foreach ($cashiers as $cashier)

                                                       <tr class="text-center">
                                                           <td>{{ $cashier->name }}</td>
                                                           <td>{{ $cashier->username }}</td>
                                                           <td>{{ $cashier->created_at->timezone('Asia/Manila')->format('h:i A, d/m/Y') }}</td>
                                                           <td>{{ $cashier->updated_at->timezone('Asia/Manila')->format('h:i A, d/m/Y') }}</td>
                                                           <td>@if($cashier->archive == 0) <span class="badge bg-success">Active</span> @else <span class="badge bg-danger">Archived</span> @endif</td>
                                                           <td>
                                                            <button type="button" class="btn btn-primary" data-bs-target="#edit-cashier{{$cashier->id}}" data-bs-toggle="modal" value="{{ $cashier->id }}"><i class="bi bi-pencil-square"></i></button>
{{-- 
                                                         <button type="button" class="btn btn-danger" data-bs-target="#modal-delete{{ $cashier->id}}" data-bs-toggle="modal"><i class="bi bi-trash"></i></button> --}}
                                                        @if($cashier->archive == 0)
                                                        <button type="button" class="btn btn-warning" data-bs-target="#modal-archive-confirmation{{ $cashier->id}}" data-bs-toggle="modal"><i class="bi bi-archive"></i></button>
                                                        @endif
                                                        @if($cashier->archive == 1)
                                                            <form action="{{ route('cashier.restore', $cashier->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button class="btn btn-success" type="submit"><i class="bi bi-arrow-clockwise"></i></button>
                                                            </form>
                                                        @endif
                                                        <!-- Archive Confirmation Modal -->
                                                        <div class="modal fade" id="modal-archive-confirmation{{ $cashier->id }}" tabindex="-1" aria-labelledby="archiveConfirmationModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="archiveConfirmationModalLabel">Confirm Archive</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to archive this cashier?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                        <form action="{{ route('cashier.archive', $cashier->id) }}" method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-primary">Archive</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            </form>

                                                           </td>
                                                       </tr>
                                                       @endforeach

                                                    </tbody>
                                                </table>
                                    
                                            </div>
                                            
                                        </div>
                                        @include('components/user_management/add_cashier')

                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @include('components/user_management/cashier_update')
    <!-- End of sidebar -->
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    
</body>

</html>
