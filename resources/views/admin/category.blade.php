{{-- resources/views/admin/categories.blade.php --}}
@extends('layouts.app')

@section('title', 'Categories')

@section('content')
@include('admin.nav')

<!-- Main Content -->
<div class="container mt-4">
    <div class="row">
        <!-- Category Form Section -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-light">
                    {{ isset($editCategory) ? 'Edit Category' : (isset($deleteCategory) ? 'Delete Category' : 'Add Category') }}
                </div>
                <div class="card-body">
                    @if(isset($editCategory))
                        <form action="{{ route('categories.update', $editCategory->id) }}" method="POST">
                            @method('PUT')
                    @elseif (isset($deleteCategory))
                        <form action="{{ route('categories.destroy', $deleteCategory->id) }}" method="POST">
                            @method('DELETE')
                    @else
                        <form action="{{ route('categories.store') }}" method="POST">
                    @endif
                        @csrf
        
                        <!-- Category Name Field -->
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="category_name" name="category_name" 
                                value="{{ old('category_name', $editCategory->category_name ?? ($deleteCategory->category_name ?? '')) }}" 
                                required {{ isset($deleteCategory) ? 'disabled' : '' }}>
                            @error('category_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
        
                        <!-- Action Buttons Section (Update, Cancel, Delete) -->
                        <div class="d-flex justify-content-between mt-3">
                            <button type="submit" class="btn btn-success">
                                {{ isset($editCategory) ? 'Update Category' : (isset($deleteCategory) ? 'Delete Category' : 'Add Category') }}
                            </button>
        
                            @if(isset($editCategory) || isset($deleteCategory))
                                <a href="{{ route('category') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            @endif
                        </div>
        
                    </form>
                </div>
            </div>
        </div>
        

        <!-- Data Table Section -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Categories List</h5>
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
                    <table class="table table-bordered table-hover" id="example">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->category_name }}</td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary me-2" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('categories.delete', $category->id) }}" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No categories found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                "infoFiltered": "(filtered from _MAX total records)"
            }
        });
    });
</script>
@endsection
