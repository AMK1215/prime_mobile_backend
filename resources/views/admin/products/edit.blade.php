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
                                                                   id="ram" name="ram" value="{{ old('ram', $product->ram) }}" 
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
                                                                   id="storage" name="storage" value="{{ old('storage', $product->storage) }}" 
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
                                                                   id="screen_size" name="screen_size" value="{{ old('screen_size', $product->screen_size) }}" 
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
                                                                   id="color" name="color" value="{{ old('color', $product->color) }}" 
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
                                                                   id="battery_capacity" name="battery_capacity" value="{{ old('battery_capacity', $product->battery_capacity) }}" 
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
                                                                   id="battery_watt" name="battery_watt" value="{{ old('battery_watt', $product->battery_watt) }}" 
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
                                        <!-- Current Images -->
                                        @if($product->images->count() > 0)
                                            <div class="form-group">
                                                <label>Current Images</label>
                                                <div class="border rounded p-3">
                                                    <div class="row" id="currentImages">
                                                        @foreach($product->images as $image)
                                                            <div class="col-6 mb-2 position-relative" data-image-id="{{ $image->id }}">
                                                                <img src="{{ $image->image_url }}" 
                                                                     alt="{{ $product->name }}" 
                                                                     class="img-thumbnail w-100" 
                                                                     style="height: 80px; object-fit: cover;">
                                                                @if($image->is_primary)
                                                                    <span class="badge badge-primary position-absolute" style="top: -5px; right: -5px;">Primary</span>
                                                                @endif
                                                                <div class="btn-group btn-group-sm position-absolute" style="bottom: 5px; right: 5px;">
                                                                    @if(!$image->is_primary)
                                                                        <button type="button" class="btn btn-info btn-xs" 
                                                                                onclick="setPrimaryImage({{ $product->id }}, {{ $image->id }})" 
                                                                                title="Set as Primary">
                                                                            <i class="fas fa-star"></i>
                                                                        </button>
                                                                    @endif
                                                                    <button type="button" class="btn btn-danger btn-xs" 
                                                                            onclick="removeImage({{ $product->id }}, {{ $image->id }})" 
                                                                            title="Remove Image">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($product->image)
                                            <!-- Legacy single image support -->
                                            <div class="form-group">
                                                <label>Current Image (Legacy)</label>
                                                <div class="border rounded p-3 text-center">
                                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                                         alt="{{ $product->name }}" 
                                                         class="img-fluid rounded" 
                                                         style="max-height: 200px;">
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Add New Images -->
                                        <div class="form-group">
                                            <label for="images">Add New Images <small class="text-muted">(Up to 10 total)</small></label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('images.*') is-invalid @enderror" 
                                                       id="images" name="images[]" accept="image/*" multiple onchange="previewNewImages(this)">
                                                <label class="custom-file-label" for="images">Choose new files</label>
                                            </div>
                                            @error('images.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @error('images')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Supported formats: JPEG, PNG, JPG, GIF, WebP. Max size: 20MB per image.
                                            </small>
                                        </div>

                                        <!-- New Images Preview -->
                                        <div class="form-group">
                                            <label>New Images Preview</label>
                                            <div id="newImagePreview" class="border rounded p-3 text-center" style="min-height: 200px;">
                                                <i class="fas fa-images text-muted" style="font-size: 3rem;"></i>
                                                <p class="text-muted mt-2">No new images selected</p>
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
                console.log('New image files selected:', imageInput.files.length);
                for (let i = 0; i < imageInput.files.length; i++) {
                    console.log(`File ${i + 1}:`, imageInput.files[i].name, 'Size:', imageInput.files[i].size);
                }
            } else {
                console.log('No new image files selected');
            }
        });
    });

    function previewNewImages(input) {
        if (input.files && input.files.length > 0) {
            console.log('Previewing new images:', input.files.length);
            let previewHtml = '';
            
            for (let i = 0; i < input.files.length; i++) {
                let file = input.files[i];
                let reader = new FileReader();
                
                reader.onload = function(e) {
                    previewHtml += `
                        <div class="position-relative d-inline-block m-1">
                            <img src="${e.target.result}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                            <span class="badge badge-success position-absolute" style="top: -5px; right: -5px;">New</span>
                        </div>
                    `;
                    
                    // Update preview after all images are loaded
                    if (i === input.files.length - 1) {
                        setTimeout(() => {
                            $('#newImagePreview').html(previewHtml);
                        }, 100);
                    }
                };
                
                reader.readAsDataURL(file);
            }
        } else {
            console.log('No new files selected for preview');
            $('#newImagePreview').html('<i class="fas fa-images text-muted" style="font-size: 3rem;"></i><p class="text-muted mt-2">No new images selected</p>');
        }
    }

    function setPrimaryImage(productId, imageId) {
        if (confirm('Set this image as primary?')) {
            $.ajax({
                url: `/admin/products/${productId}/images/${imageId}/set-primary`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + response.error);
                    }
                },
                error: function() {
                    alert('Error setting primary image');
                }
            });
        }
    }

    function removeImage(productId, imageId) {
        if (confirm('Are you sure you want to remove this image?')) {
            $.ajax({
                url: `/admin/products/${productId}/images/${imageId}`,
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $(`[data-image-id="${imageId}"]`).fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        alert('Error: ' + response.error);
                    }
                },
                error: function() {
                    alert('Error removing image');
                }
            });
        }
    }
</script>
@endsection
