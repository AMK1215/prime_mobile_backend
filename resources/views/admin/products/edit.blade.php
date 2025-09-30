@extends('layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Edit Product</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="border-radius: 20px;">
                        <div class="card-header">
                            <h3>Edit Product: {{ $product->name }}</h3>
                        </div>
                        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <!-- Basic Information -->
                                        <div class="form-group">
                                            <label for="name">Product Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Description <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_category_id">Category <span class="text-danger">*</span></label>
                                                    <select class="form-control select2bs4 @error('product_category_id') is-invalid @enderror" 
                                                            id="product_category_id" name="product_category_id" required>
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" 
                                                                    {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('product_category_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_status_id">Status <span class="text-danger">*</span></label>
                                                    <select class="form-control select2bs4 @error('product_status_id') is-invalid @enderror" 
                                                            id="product_status_id" name="product_status_id" required>
                                                        <option value="">Select Status</option>
                                                        @foreach($statuses as $status)
                                                            <option value="{{ $status->id }}" 
                                                                    {{ old('product_status_id', $product->product_status_id) == $status->id ? 'selected' : '' }}>
                                                                {{ $status->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('product_status_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="price">Price ($) <span class="text-danger">*</span></label>
                                                    <input type="number" step="0.01" min="0" 
                                                           class="form-control @error('price') is-invalid @enderror" 
                                                           id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                                    @error('price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                                    <input type="number" min="0" 
                                                           class="form-control @error('quantity') is-invalid @enderror" 
                                                           id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>
                                                    @error('quantity')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <!-- Current Image -->
                                        @if($product->image)
                                            <div class="form-group">
                                                <label>Current Image</label>
                                                <div class="border rounded p-3 text-center">
                                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                                         alt="{{ $product->name }}" 
                                                         class="img-fluid rounded" 
                                                         style="max-height: 200px;">
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Image Upload -->
                                        <div class="form-group">
                                            <label for="image">Update Product Image</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" 
                                                       id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                                <label class="custom-file-label" for="image">Choose new file</label>
                                            </div>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Leave empty to keep current image</small>
                                        </div>

                                        <!-- Image Preview -->
                                        <div class="form-group">
                                            <label>New Image Preview</label>
                                            <div id="imagePreview" class="border rounded p-3 text-center" style="min-height: 200px;">
                                                <i class="fas fa-image text-muted" style="font-size: 3rem;"></i>
                                                <p class="text-muted mt-2">No new image selected</p>
                                            </div>
                                        </div>

                                        <!-- Product Info -->
                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h3 class="card-title">Product Information</h3>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Created:</strong> {{ $product->created_at->format('M d, Y H:i') }}</p>
                                                <p><strong>Last Updated:</strong> {{ $product->updated_at->format('M d, Y H:i') }}</p>
                                                <p><strong>Total Sales:</strong> {{ $product->customers->count() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i>Back to Products
                                        </a>
                                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info">
                                            <i class="fas fa-eye mr-2"></i>View Product
                                        </a>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save mr-2"></i>Update Product
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        // Custom file input
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Form submission debugging
        $('form').on('submit', function(e) {
            console.log('Form submitted');
            console.log('Form data:', new FormData(this));
            
            // Check if image file is selected
            const imageInput = $('#image')[0];
            if (imageInput && imageInput.files && imageInput.files[0]) {
                console.log('Image file selected:', imageInput.files[0]);
                console.log('File size:', imageInput.files[0].size);
                console.log('File type:', imageInput.files[0].type);
            } else {
                console.log('No image file selected');
            }
        });
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            console.log('Previewing image:', input.files[0]);
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').html('<img src="' + e.target.result + '" class="img-fluid rounded" style="max-height: 200px;">');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            console.log('No file selected for preview');
        }
    }
</script>
@endsection
