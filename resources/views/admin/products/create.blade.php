@extends('layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Add New Product</li>
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
                            <h3>Add New Product</h3>
                        </div>
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <!-- Basic Information -->
                                        <div class="form-group">
                                            <label for="name">Product Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Description <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Phone Information Section -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Phone Information</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="ram">RAM</label>
                                                            <input type="text" 
                                                                   class="form-control @error('ram') is-invalid @enderror" 
                                                                   id="ram" name="ram" value="{{ old('ram') }}" 
                                                                   placeholder="e.g., 8GB, 12GB">
                                                            @error('ram')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="storage">Storage</label>
                                                            <input type="text" 
                                                                   class="form-control @error('storage') is-invalid @enderror" 
                                                                   id="storage" name="storage" value="{{ old('storage') }}" 
                                                                   placeholder="e.g., 128GB, 256GB, 512GB">
                                                            @error('storage')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="screen_size">Screen Size</label>
                                                            <input type="text" 
                                                                   class="form-control @error('screen_size') is-invalid @enderror" 
                                                                   id="screen_size" name="screen_size" value="{{ old('screen_size') }}" 
                                                                   placeholder="e.g., 6.1 inches, 6.7 inches">
                                                            @error('screen_size')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="color">Color</label>
                                                            <input type="text" 
                                                                   class="form-control @error('color') is-invalid @enderror" 
                                                                   id="color" name="color" value="{{ old('color') }}" 
                                                                   placeholder="e.g., Black, White, Blue, Gold">
                                                            @error('color')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="battery_capacity">Battery Capacity</label>
                                                            <input type="text" 
                                                                   class="form-control @error('battery_capacity') is-invalid @enderror" 
                                                                   id="battery_capacity" name="battery_capacity" value="{{ old('battery_capacity') }}" 
                                                                   placeholder="e.g., 4000mAh, 5000mAh">
                                                            @error('battery_capacity')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="battery_watt">Battery Watt</label>
                                                            <input type="text" 
                                                                   class="form-control @error('battery_watt') is-invalid @enderror" 
                                                                   id="battery_watt" name="battery_watt" value="{{ old('battery_watt') }}" 
                                                                   placeholder="e.g., 25W, 45W, 65W">
                                                            @error('battery_watt')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_category_id">Category <span class="text-danger">*</span></label>
                                                    <select class="form-control select2bs4 @error('product_category_id') is-invalid @enderror" 
                                                            id="product_category_id" name="product_category_id" required>
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
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
                                                            <option value="{{ $status->id }}" {{ old('product_status_id') == $status->id ? 'selected' : '' }}>
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
                                                           id="price" name="price" value="{{ old('price') }}" required>
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
                                                           id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                                                    @error('quantity')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <!-- Multiple Image Upload -->
                                        <div class="form-group">
                                            <label for="images">Product Images <small class="text-muted">(Up to 10 images)</small></label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('images.*') is-invalid @enderror" 
                                                       id="images" name="images[]" accept="image/*" multiple onchange="previewImages(this)">
                                                <label class="custom-file-label" for="images">Choose multiple files</label>
                                            </div>
                                            @error('images.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @error('images')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                First image will be set as primary. Supported formats: JPEG, PNG, JPG, GIF, WebP. Max size: 20MB per image.
                                            </small>
                                        </div>

                                        <!-- Image Preview -->
                                        <div class="form-group">
                                            <label>Image Preview</label>
                                            <div id="imagePreview" class="border rounded p-3 text-center" style="min-height: 200px;">
                                                <i class="fas fa-images text-muted" style="font-size: 3rem;"></i>
                                                <p class="text-muted mt-2">No images selected</p>
                                            </div>
                                        </div>

                                        <!-- Quick Actions -->
                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h3 class="card-title">Quick Actions</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-info btn-block" onclick="fillSampleData()">
                                                        <i class="fas fa-magic mr-2"></i>Fill Sample Data
                                                    </button>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-warning btn-block" onclick="clearForm()">
                                                        <i class="fas fa-eraser mr-2"></i>Clear Form
                                                    </button>
                                                </div>
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
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save mr-2"></i>Create Product
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
            let files = this.files;
            if (files.length > 0) {
                let fileName = files.length === 1 ? files[0].name : files.length + ' files selected';
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            }
        });

        // Form submission debugging
        $('form').on('submit', function(e) {
            console.log('Form submitted');
            console.log('Form data:', new FormData(this));
            
            // Check if image files are selected
            const imageInput = $('#images')[0];
            if (imageInput && imageInput.files && imageInput.files.length > 0) {
                console.log('Image files selected:', imageInput.files.length);
                for (let i = 0; i < imageInput.files.length; i++) {
                    console.log(`File ${i + 1}:`, imageInput.files[i].name, 'Size:', imageInput.files[i].size);
                }
            } else {
                console.log('No image files selected');
            }
        });
    });

    function previewImages(input) {
        if (input.files && input.files.length > 0) {
            console.log('Previewing images:', input.files.length);
            let previewHtml = '';
            
            for (let i = 0; i < input.files.length; i++) {
                let file = input.files[i];
                let reader = new FileReader();
                
                reader.onload = function(e) {
                    previewHtml += `
                        <div class="position-relative d-inline-block m-1">
                            <img src="${e.target.result}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                            ${i === 0 ? '<span class="badge badge-primary position-absolute" style="top: -5px; right: -5px;">Primary</span>' : ''}
                        </div>
                    `;
                    
                    // Update preview after all images are loaded
                    if (i === input.files.length - 1) {
                        setTimeout(() => {
                            $('#imagePreview').html(previewHtml);
                        }, 100);
                    }
                };
                
                reader.readAsDataURL(file);
            }
        } else {
            console.log('No files selected for preview');
            $('#imagePreview').html('<i class="fas fa-images text-muted" style="font-size: 3rem;"></i><p class="text-muted mt-2">No images selected</p>');
        }
    }

    function fillSampleData() {
        $('#name').val('iPhone 15 Pro Max');
        $('#description').val('The latest iPhone with advanced camera system, titanium design, and A17 Pro chip. Features include 48MP main camera, Action Button, and USB-C connectivity.');
        $('#price').val('1199.99');
        $('#quantity').val('25');
        $('#product_category_id').val('1').trigger('change');
        $('#product_status_id').val('2').trigger('change');
    }

    function clearForm() {
        if (confirm('Are you sure you want to clear all form data?')) {
            $('form')[0].reset();
            $('.select2bs4').val('').trigger('change');
            $('#imagePreview').html('<i class="fas fa-image text-muted" style="font-size: 3rem;"></i><p class="text-muted mt-2">No image selected</p>');
        }
    }
</script>
@endsection
