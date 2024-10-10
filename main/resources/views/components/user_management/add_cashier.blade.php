<div class="modal fade" id="add-cashier" tabindex="-1" aria-labelledby="addcashier" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Cashier</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('cashier.store')}}" method="post" id="add-cashier-form">
            @csrf
            @method('POST')
              <div class="mb-3">
                <input type="hidden" name="role" id="role" value="cashier">
                <label for="name" class="form-label">Name</label>
                <input type="text" maxlength="20" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                <div class="invalid-feedback" id="name-error"></div>
            </div>
        
            <div class="mb-3">
                <label for="username"  class="form-label">Username</label>
                <input type="text" class="form-control " id="username" name="username" maxlength="20" value="{{ old('username') }}" required>
                <div class="invalid-feedback" id="username-error"></div>
            </div>
        
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" maxlength="16" class="" id="password" name="password" required>
                <div class="invalid-feedback" id="password-error">
              
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
const form = document.getElementById('add-cashier-form');
const nameInput = document.getElementById('name');
const usernameInput = document.getElementById('username');
const passwordInput = document.getElementById('password');

const nameError = document.getElementById('name-error');
const usernameError = document.getElementById('username-error');
const passwordError = document.getElementById('password-error');

nameInput.addEventListener('input', validateName);
usernameInput.addEventListener('input', validateUsername);
passwordInput.addEventListener('input', validatePassword);

function validateName() {
if (nameInput.value.trim().length === 0) {
setError(nameInput, nameError, 'Name is required');
} else if (nameInput.value.length >= 1 && nameInput.value.length <=3) {
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
} else if (passwordInput.value.length <=16 && passwordInput.value.length <4) {
setError(passwordInput, passwordError, 'Password must be 16 characters or less');
}else if (!passwordRegex.test(passwordInput.value)) {
setError(passwordInput, passwordError, 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character');
}
else {
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