@extends('layouts.app')

@section('title', 'Products')

@section('content')
@include('admin.nav')

<!-- Main Content -->
<div class="container mt-4">
    <div class="row">
        <!-- Product Form Section -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header bg-light">
                    {{ isset($product) ? (isset($deleteProduct) ? 'Delete Product' : 'Edit Product') : 'Add Product' }}
                </div>
                <div class="card-body">
                    @if(isset($deleteProduct))
                    <form action="{{ route('products.destroy', $deleteProduct->id) }}" method="POST">
                        @method('DELETE')
                    @elseif(isset($product))
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                    @else
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                    
                        @csrf
            
                        <!-- Category Select Field -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-control" required {{ isset($deleteProduct) ? 'disabled' : '' }}>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (isset($deleteProduct) && $deleteProduct->category_id == $category->id) ? 'selected' : (isset($product) && $product->category_id == $category->id ? 'selected' : '') }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
            
                        <!-- Product Name Field -->
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="product_name" name="product_name" 
                                value="{{ old('product_name', isset($deleteProduct) ? $deleteProduct->product_name : ($product->product_name ?? '')) }}" required {{ isset($deleteProduct) ? 'disabled' : '' }}>
                            @error('product_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <!-- Description Field -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3" required {{ isset($deleteProduct) ? 'disabled' : '' }}>{{ old('description', isset($deleteProduct) ? $deleteProduct->description : ($product->description ?? '')) }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
            
                        <!-- Price Field -->
                        <div class="mb-3">
                            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" 
                                value="{{ old('price', isset($deleteProduct) ? $deleteProduct->price : ($product->price ?? '')) }}" required {{ isset($deleteProduct) ? 'disabled' : '' }}>
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
            
                        <!-- Stock Quantity Field -->
                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" 
                                value="{{ old('stock_quantity', isset($deleteProduct) ? $deleteProduct->stock_quantity : ($product->stock_quantity ?? '')) }}" required {{ isset($deleteProduct) ? 'disabled' : '' }}>
                            @error('stock_quantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
            
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" onchange="previewImage(event)" {{ isset($deleteProduct) ? 'disabled' : '' }}>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
            
                        <!-- Image Preview -->
                        @if((isset($deleteProduct) && $deleteProduct->image) || (isset($product) && $product->image))
                        <div class="mb-3">
                            <label>Current Image:</label>
                            <img src="{{ asset((isset($deleteProduct) ? $deleteProduct->image : $product->image)) }}" alt="{{ (isset($deleteProduct) ? $deleteProduct->product_name : $product->product_name) }}" class="img-thumbnail" style="max-width: 150px;">
                        </div>
                        @endif
            
                        <!-- Action Buttons Section -->
                        <div class="d-flex justify-content-between mt-3">
                            @if(isset($deleteProduct))
                                <button type="submit" class="btn btn-danger">Delete Product</button>
                                <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            @else
                                <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Add' }}</button>
                                <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            @endif
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>

        <!-- Product List Section -->
        <div class="col-lg-8 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-light">
                    Product List
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->product_name }}
                                        <small>
                                        <p class="mb-0"><b>Description:</b> {{ $product->description }}</p> <!-- Added description here -->
                                        </small>
                                    </td>
                                    <td>{{ $product->category->category_name }}</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->stock_quantity }}</td>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->product_name }}" class="img-thumbnail" style="max-width: 100px;">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-start">
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary me-2" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('products.delete', $product->id) }}" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const previewContainer = document.getElementById('imagePreview');
        const previewImage = document.getElementById('preview');

        // Check if a file was selected
        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result; // Set the image source to the file reader result
                previewContainer.style.display = 'block'; // Show the image preview container
            };

            reader.readAsDataURL(event.target.files[0]); // Read the selected file as a data URL
        } else {
            previewContainer.style.display = 'none'; // Hide the preview if no file is selected
        }
    }
</script>
@endsection
