
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
     
</head>
<body style="height: 100vh">
    <!-- form -->
    
    <div class="container ">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
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
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-light text-dark text-center">
                        <h3 class="text-center text-uppercase p-3">Reset Password</h3>
                    <div class="card-body bg-light text-dark text-center">
                        <form action="{{ route('password.update')}}" method="POST" id="reset-password-form">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                <div class="invalid-feedback" id="email-error"></div>
                            </div>
                           
                            <div class="mb-3">
                                <label for="password" class="form-label">Enter New Password</label>
                                <input type="password" class="form-control" maxlength="16" id="password" name="password" required>
                                <div class="invalid-feedback" id="password-error"></div>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" maxlength="16" id="password_confirmation" name="password_confirmation" required>
                                <div class="invalid-feedback" id="password-confirmation-error"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">Reset Password</button>

                           
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
         document.addEventListener('DOMContentLoaded', function(event) {
            const resetPasswordForm = document.getElementById('reset-password-form');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const emailError = document.getElementById('email-error');
            const passwordError = document.getElementById('password-error');
            const passwordConfirmationError = document.getElementById('password-confirmation-error');
            
            emailInput.addEventListener('input', validateEmail);
            passwordInput.addEventListener('input', validatePassword);
            passwordConfirmationInput.addEventListener('input', validatePasswordConfirmation);

            function validateEmail() {
                if(emailInput.value.trim().length === 0) {
                    setError(emailInput, emailError, 'Email is required');
                } else {
                    setSuccess(emailInput, emailError);
                }
            }

            function validatePassword() {
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;

                if (passwordInput.value.trim().length === 0) {
                    setError(passwordInput, passwordError, 'Password is required');
                } else if (passwordInput.value.length < 4 && passwordInput.value.length <=16) {
                    setError(passwordInput, passwordError, 'Password must be between 8 and 16 characters');
                } else if (!passwordRegex.test(passwordInput.value))
                {
                    setError(passwordInput, passwordError, 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character');
                } else {
                    setSuccess(passwordInput, passwordError);
                }
            }

            function validatePasswordConfirmation() {
                if (passwordConfirmationInput.value.trim().length === 0) {
                    setError(passwordConfirmationInput, passwordConfirmationError, 'Password is required');
                } else if (passwordConfirmationInput.value.length < 4 && passwordConfirmationInput.value.length <=16) {
                    setError(passwordConfirmationInput, passwordConfirmationError, 'Password must be between 8 and 16 characters');
                } else if (passwordConfirmationInput.value !== passwordInput.value) {
                    setError(passwordConfirmationInput, passwordConfirmationError, 'Passwords do not match');
                } else {
                    setSuccess(passwordConfirmationInput, passwordConfirmationError);
                }
            }

            function setError(input, errorElement, errorMessage) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                errorElement.textContent = errorMessage;
            }

            function setSuccess(input, errorElement) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                errorElement.textContent = '';
            }
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                validateEmail();
                validatePassword();
                validatePasswordConfirmation();
            })

            if (!form.querySelector('.is-invalid')) {
                // If no invalid fields, you can submit the form
                form.submit();
            }
        });


    </script>
    <!-- End of form -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js
    "></script> 
</body>

</html>