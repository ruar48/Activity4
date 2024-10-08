{{-- resources/views/users.blade.php --}}
@extends('layouts.app')

@section('title', 'Users')

@section('content')
@include('admin.nav')

<!-- Main Content -->
<div class="container mt-4">
    <div class="row">
        <!-- User Form Section -->
        <div class="col-md-12 col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-light">
                    {{ isset($editUser) ? 'Edit User' : (isset($deleteUser) ? 'Delete User' : 'Add User') }}
                </div>
                <div class="card-body">
                    @if(isset($editUser))
                        <form action="{{ route('users.update', $editUser->id) }}" method="POST">
                        @method('PUT')
                    @elseif (isset($deleteUser))
                        <form action="{{ route('users.destroy', $deleteUser->id) }}" method="POST">
                            @method('DELETE')

                    @else
                        <form action="{{ route('users.store') }}" method="POST">
                    @endif
                        @csrf
                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" 
                                value="{{ old('name', $editUser->name ?? ($deleteUser->name ?? '')) }}" 
                                required {{ isset($deleteUser) ? 'disabled' : '' }}>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" 
                                value="{{ old('email', $editUser->email ?? ($deleteUser->email ?? '')) }}" 
                                required {{ isset($deleteUser) ? 'disabled' : '' }}>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <!-- Password Field (Only for Adding) -->
                        @if(!isset($editUser))
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" 
                                {{ isset($deleteUser) ? 'disabled' : 'required' }}>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @endif
                        
                        <!-- Role Field -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-control" id="role" name="role" required {{ isset($deleteUser) ? 'disabled' : '' }}>
                                <option value="">Select Role</option>
                                <option value="admin" {{ old('role', $editUser->role ?? ($deleteUser->role ?? '')) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ old('role', $editUser->role ?? ($deleteUser->role ?? '')) == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                            @error('role')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <!-- Account Status Field -->
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Account Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="is_active" name="is_active" required {{ isset($deleteUser) ? 'disabled' : '' }}>
                                <option value="">Select Status</option>
                                <option value="1" {{ old('is_active', $editUser->is_active ?? ($deleteUser->is_active ?? '')) == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $editUser->is_active ?? ($deleteUser->is_active ?? '')) == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <!-- Action Buttons Section -->
                        <div class="d-flex justify-content-between mt-3">
                            <!-- Update Button -->
                            <button type="submit" class="btn btn-success">
                                {{ isset($editUser) ? 'Update User' : (isset($deleteUser) ? 'Delete User' : 'Add User') }}
                            </button>
        
                            @if(isset($editUser) || isset($deleteUser))
                            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Data Table Section -->
        <div class="col-md-12 col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Users List</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="example">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Account Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>
                                        @if($user->is_active)
                                            <span class="badge bg-success"><i class="fas fa-check-circle"></i> Active</span>
                                        @else
                                            <span class="badge bg-secondary"><i class="fas fa-times-circle"></i> Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-start">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary me-2" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('users.delete', $user->id) }}" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No users found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Initialize DataTables -->
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "language": {
                "search": "Filter records:",
                "lengthMenu": "Display _MENU_ records per page",
                "zeroRecords": "No matching records found",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)"
            },
            "pagingType": "simple_numbers",
            "responsive": true
        });
    });
</script>
@endsection
