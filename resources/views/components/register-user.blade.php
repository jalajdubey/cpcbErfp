
@props(['userRoles'])
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:70%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">User Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('admin.addnewuser') }}" autocomplete="off">
                    @csrf

                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                               value="{{ old('firstname') }}" id="firstname" name="firstname" required>
                        @error('firstname')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                               value="{{ old('lastname') }}" id="lastname" name="lastname" required>
                        @error('lastname')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" id="email" name="email" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role_type">Role Type</label>
                        <!-- <select name="role_type" class="form-control @error('role_type') is-invalid @enderror">
                            <option value="">Select Role</option>
                            <option value="monitoring officer" {{ old('role_type') == 'monitoring officer' ? 'selected' : '' }}>Monitoring Officer</option>
                            <option value="user" {{ old('role_type') == 'user' ? 'selected' : '' }}>user</option>
                        </select> -->

                        <select name="role_type" class="form-control @error('role_type') is-invalid @enderror">
                            @foreach($userRoles as $userRole)
                                <option value="{{ $userRole->id }}">{{ $userRole->role }}</option>
                            @endforeach
                        </select>
                        @error('role_type')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mobile_no" class="form-label">Contact number</label>
                        <input type="number" name="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror"
                               value="{{ old('mobile_no') }}" id="mobile_no" required>
                        @error('mobile_no')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">Accept Terms & Conditions</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('password').addEventListener('input', function(e) {
    const value = e.target.value;
    const patterns = /(abc|123|password|qwerty|abc@1245)/i;
    if (patterns.test(value)) {
        alert('The password is too simple or has been restricted due to common patterns.');
    }
});
</script>