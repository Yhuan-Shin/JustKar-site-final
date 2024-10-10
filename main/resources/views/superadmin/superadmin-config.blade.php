
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @livewireScripts
</head>
<body>

    <!-- sidebar -->
    
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark collapse collapse-horizontal show border-end" id="sidebar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <div class="container">
                       <div class="row">
                            <div class="col d-flex align-items-center">
                                <a href="/superadmin/dashboard" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
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
            {{-- add modal --}}
            <div class="modal fade " id="add-whitelist" tabindex="-1" aria-labelledby="addWhitelist" aria-hidden="true" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addWhitelist">Add Whitelist Devices</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{-- crate a form for whitelist --}}
                            <form action="{{route('whitelist.store')}}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="mac_address" class="form-label">IP Address:</label>
                                    <input type="text" class="form-control" placeholder="127.0.0.1" id="ip_address" name="ip_address" required pattern="{12}">
                                </div>
                            
                                <button type="submit" class="btn btn-primary float-end">Add to Whitelist</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end and modal --}}


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
                                            <span class="d-none d-sm-inline text-dark mx-1">{{ Auth::guard('superadmin')->user()->name }}</span>
                                        </div>
                                </div>
                                
                                <div class="row">
                                    <div class="container">
                                        <div class="row">
                                                {{-- content --}}

                                                <div class="col">
                                                    <button type="button" class="btn btn-outline-success float-end mb-3" data-bs-target="#add-whitelist" data-bs-toggle="modal" ><i class=" py-2 bi bi-plus-circle"></i> Add Whitelist Devices</button>
                                                </div>

                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-striped table-bordered">
                                                        <thead class="table-dark text-center">
                                                            <tr>
                                                                <th scope="col">IP Address</th>
                                                                <th scope="col">Created At</th>
                                                                <th scope="col">Updated At</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">
                                                            @foreach ($whitelists as $whitelist)
                                                                <tr>
                                                                    <td>{{ $whitelist->ip_address }}</td>
                                                                    <td>{{ $whitelist->created_at->timezone('Asia/Manila')->format('m/d/Y, h:i A') }}</td>
                                                                    <td>{{ $whitelist->updated_at->timezone('Asia/Manila')->format('m/d/Y, h:i A') }}</td>
                                                                    <td class="text-center">
                                                                        <button type="button" class="btn btn-primary" data-bs-target="#edit-whitelist{{ $whitelist->id }}" data-bs-toggle="modal"><i class="bi bi-pencil-square"></i></button>

                                                                        <!-- Edit Whitelist Modal -->
                                                                        <div class="modal fade" id="edit-whitelist{{ $whitelist->id }}" tabindex="-1" aria-labelledby="editWhitelistModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="editWhitelistModalLabel">Edit Whitelist</h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <form action="{{ route('whitelist.update', $whitelist->id) }}" method="POST">
                                                                                        @csrf
                                                                                        @method('PUT')
                                                                                        <div class="modal-body">
                                                                                            <div class="mb-3">
                                                                                                <label for="ip_address" class="form-label">IP Address</label>
                                                                                                <input type="text" class="form-control" id="ip_address" name="ip_address" value="{{ $whitelist->ip_address }}" required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <button class="btn btn-danger" type="button" aria-modal="true" data-bs-target="#modal-delete{{ $whitelist->id }}" data-bs-toggle="modal"><i class="bi bi-trash"></i></button>



                                                                        <!-- Delete Confirmation Modal -->
                                                                        <div class="modal fade " id="modal-delete{{ $whitelist->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        Are you sure you want to delete this whitelist?
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                                        <form action="{{ route('whitelist.destroy', $whitelist->id) }}" method="post">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>                                                                  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                  @livewire('notifications')
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- End of sidebar -->
    @livewireScripts
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
