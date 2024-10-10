<div class="modal fade" id="add-admin" tabindex="-1" aria-labelledby="addcashier" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Admin</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('admin.store')}}" id="add-admin-form" method="post">
            @csrf
            @method('POST')
            <div class="mb-3">
                <input type="hidden" name="role" id="role" value="admin">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" maxlength="20" value="{{old('name')}}" id="admin-name" name="name" placeholder="Name" required>
                <div class="invalid-feedback" id="admin-name-error">
              
                </div>
              </div>
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control " id="admin-username" maxlength="20" value="{{old('username')}}" name="username" placeholder="Username" required>
                <div class="invalid-feedback" id="admin-username-error">
              
                </div>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" maxlength="16" class="form-control" value="{{old('password')}}" id="admin-password" name="password" placeholder="Password" required>
                <div class="invalid-feedback" id="admin-password-error">
                </div>
              </div>
              

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>

</div>
<script>
 document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('add-admin-form');
    const nameInput = document.getElementById('admin-name');
    const usernameInput = document.getElementById('admin-username');
    const passwordInput = document.getElementById('admin-password');

    const nameError = document.getElementById('admin-name-error');
    const usernameError = document.getElementById('admin-username-error');
    const passwordError = document.getElementById('admin-password-error');

    nameInput.addEventListener('input', validateName);
    usernameInput.addEventListener('input', validateUsername);
    passwordInput.addEventListener('input', validatePassword);

    function validateName() {
        if (nameInput.value.trim().length === 0) {
            setError(nameInput, nameError, 'Name is required');
        } else if (nameInput.value.length < 3) {
            setError(nameInput, nameError, 'Name must be 3 characters or more');
        } else {
            setSuccess(nameInput, nameError);
        }
    }

    function validateUsername() {
          if (usernameInput.value.trim().length === 0) {
    setError(usernameInput, usernameError, 'Username is required');
    } else if (usernameInput.value.length >= 1 && usernameInput.value.length <=3) {
    setError(usernameInput, usernameError, 'Password must be 3 characters or more');
    } else {
    setSuccess(usernameInput, usernameError);
    }
  }

    function validatePassword() {
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;

        if (passwordInput.value.trim().length === 0) {
            setError(passwordInput, passwordError, 'Password is required');
        } else if (passwordInput.value.length < 4 && passwordInput.value.length <=16) {
            setError(passwordInput, passwordError, 'Password must be between 8 and 16 characters');
        } else if (!passwordRegex.test(passwordInput.value)) {
            setError(passwordInput, passwordError, 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character');
        } else {
            setSuccess(passwordInput, passwordError);
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
        validateName();
        validateUsername();
        validatePassword();

        if (!form.querySelector('.is-invalid')) {
            // If no invalid fields, you can submit the form
            form.submit();
        }
    });
});

</script>