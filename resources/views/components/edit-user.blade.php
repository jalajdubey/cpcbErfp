<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="editUserId">

                    <div class="mb-3">
                        <label for="editFirstname" class="form-label">First Name</label>
                        <input type="text" name="firstname" id="editFirstname" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="editLastname" class="form-label">Last Name</label>
                        <input type="text" name="lastname" id="editLastname" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="editRole" class="form-label">Role</label>
                        <select name="role_type" id="editRole" class="form-control" required>
                            <option value="admin">Admin</option>
                            
                            <option value="monitoring officer">Monitoring Officer</option>
                            <option value="user">user</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editMobile" class="form-label">Mobile Number</label>
                        <input type="text" name="mobile_no" id="editMobile" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
