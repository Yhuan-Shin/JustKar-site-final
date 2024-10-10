
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js
    "></script>  
    <link href="admin/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="height: 100vh; background-image: url(images/background.png); background-repeat:no-repeat; background-size:cover">
    <!-- form -->
    
    <div class="container ">
        @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex " role="alert">
            <i class="fs-4 bi bi-exclamation-circle-fill"> </i>
            <p class="p-2">{{ Session::get('error') }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger mt-2 text-center alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if (session('status'))
        <div class="alert alert-success mt-2">{{ session('status') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        
        @endif
        <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('superadmin.forgot-password')}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Enter Email</label>
                                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                                <div id="emailHelp" class="form-text">Enter your registered email to reset your password</div>
                            </div>
                            <button type="submit" class="btn btn-primary float-end">Send Link</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-md-5">
               
                <div class="card mt-5">
                    <div class="card-header text-center text-white bg-dark">
                        <img src="{{asset('images/logo.png')}}" alt="" width="25%" height="25%">
                        <h6 class="text-center text-uppercase">Super Admin LOGIN</h6>
                    </div>
                    <div class="card-body bg-dark ">
                        <form action="{{route('superadmin.login')}}" method="post">
                        @csrf
                        @method('POST')
                            <div class="mb-3">
                                <label for="name" class="form-label text-white">Username</label>
                                <div class="input-group">
                                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-circle"></i></span>
                                    <input type="text" class="form-control" placeholder="Enter Username" aria-label="Username"  name="username" maxlength="20" aria-describedby="basic-addon1" required>
                                  </div>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label text-white">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-shield-lock-fill"></i></span>
                                    <input type="password" name="password" maxlength="16" class="form-control" placeholder="Enter Password" aria-label="password" aria-describedby="basic-addon1" required>
                                  </div>
                            </div>
                            <div class="mb-3">
                                <div class="container">
                                    <div class="row-md-12 justify-content-end">
                                        <a class="text-white text-decoration-none float-end py-2" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot Password?</a>
                                    </div>

                                   
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="container">
                                    <div class="row-md-12">
                                        <input type="Submit"  name="submit" id="submit" class="btn btn-danger w-25 me-3 text-uppercase text-white offset-9" value="login"></input>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End of form -->
</body>
</html>