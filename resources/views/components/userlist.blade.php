@props(['users'])

<div class="container">
    <h3>User List</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Mobile No</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->firstname }}</td>
                    <td>{{ $user->lastname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role_type }}</td>
                    <td>{{ $user->mobile_no }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-warning btn-sm edit-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal"
                                data-id="{{ $user->id }}"
                                data-firstname="{{ $user->firstname }}"
                                data-lastname="{{ $user->lastname }}"
                                data-email="{{ $user->email }}"
                                data-role="{{ $user->role_type }}"
                                data-mobile="{{ $user->mobile_no }}">
                            Modify
                        </button>
                        <x-edit-user :user="$user" />
                        <!-- Delete Form -->
                        <form action="{{ route('admin.deleteuser', $user->id) }}" method="POST" style="display:inline;" 
                              onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
