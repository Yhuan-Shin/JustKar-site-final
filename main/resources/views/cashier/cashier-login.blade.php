
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js
    "></script>  
    <link href="admin/style.css" rel="stylesheet" type="text/css" />
</head>
<body style="height: 100vh">
    <!-- form -->
    <div class="container">
        @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex " role="alert">
            <i class="fs-4 bi bi-exclamation-circle-fill"> </i>
            <p class="p-2">{{ Session::get('error') }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-md-5">
                <div class="card mt-3 bg-dark">
                    <div class="card-header text-center text-white">
                        <i class="bi bi-person-circle" style="font-size: 50px;"></i>
                        <h3 class="text-center text-uppercase">Cashier LOGIN</h3>
                    </div>
                    <div class="card-body text-white">
                        <form action="{{route('cashier.login')}}" method="post">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group mb-3">
                                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-circle"></i></span>
                                <input type="text" name="username" class="form-control" placeholder="Username" maxlength="20" aria-label="Username" aria-describedby="basic-addon1">
                              </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group mb-3">
                                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-shield-lock-fill"></i></span>
                                <input type="password" name="password" maxlength="16" class="form-control" placeholder="Password" aria-label="password" aria-describedby="basic-addon1">
                              </div>
                        </div>
                        {{-- <div class="mb-3">
                         
                           <a href="#" class="float-end text-white text-decoration-none p-2">Forget Password <i class="bi bi-question" style="font-size: 20px;"></i></a>
                        </div> --}}
                        <div class="mb-3 mt-5">
                            <div class="container">
                                <div class="row-md-12 ">
                                    <input type="Submit"  name="submit" id="submit" class="btn btn-primary w-25 me-3 text-uppercase text-white offset-9" value="login"></input>
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