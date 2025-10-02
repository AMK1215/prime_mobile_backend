@extends('layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Product Details</li>
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
                    <div class="d-flex justify-content-between mb-3">
                        <h3>Product Details</h3>
                        <div class="btn-group">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit mr-2"></i>Edit Product
                            </a>
                            <button type="button" class="btn btn-warning" 
                                    onclick="updateStock({{ $product->id }}, '{{ $product->name }}', {{ $product->quantity }})">
                                <i class="fas fa-warehouse mr-2"></i>Update Stock
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Products
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Product Information -->
                        <div class="col-md-8">
                            <div class="card" style="border-radius: 20px;">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $product->name }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Product ID:</strong></td>
                                                    <td>#{{ $product->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Category:</strong></td>
                                                    <td><span class="badge badge-info">{{ $product->productCategory->name }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status:</strong></td>
                                                    <td>
                                                        @switch($product->productStatus->name)
                                                            @case('Available')
                                                                <span class="badge badge-success">{{ $product->productStatus->name }}</span>
                                                                @break
                                                            @case('Best Seller')
                                                                <span class="badge badge-primary">{{ $product->productStatus->name }}</span>
                                                                @break
                                                            @case('New Arrival')
                                                                <span class="badge badge-info">{{ $product->productStatus->name }}</span>
                                                                @break
                                                            @case('On Sale')
                                                                <span class="badge badge-warning">{{ $product->productStatus->name }}</span>
                                                                @break
                                                            @case('Limited Stock')
                                                                <span class="badge badge-danger">{{ $product->productStatus->name }}</span>
                                                                @break
                                                            @default
                                                                <span class="badge badge-secondary">{{ $product->productStatus->name }}</span>
                                                        @endswitch
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Price:</strong></td>
                                                    <td><span class="h4 text-success">${{ number_format($product->price, 2) }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Stock Quantity:</strong></td>
                                                    <td>
                                                        @if($product->quantity > 10)
                                                            <span class="badge badge-success badge-lg">{{ $product->quantity }}</span>
                                                        @elseif($product->quantity > 0)
                                                            <span class="badge badge-warning badge-lg">{{ $product->quantity }}</span>
                                                        @else
                                                            <span class="badge badge-danger badge-lg">0</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Stock Status:</strong></td>
                                                    <td>
                                                        @if($product->isInStock())
                                                            <span class="badge badge-success">In Stock</span>
                                                        @else
                                                            <span class="badge badge-danger">Out of Stock</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Created:</strong></td>
                                                    <td>{{ $product->created_at->format('M d, Y H:i') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Last Updated:</strong></td>
                                                    <td>{{ $product->updated_at->format('M d, Y H:i') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Total Sales:</strong></td>
                                                    <td><span class="badge badge-primary">{{ $product->customers->count() }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Availability:</strong></td>
                                                    <td>
                                                        @if($product->isAvailable())
                                                            <span class="badge badge-success">Available for Sale</span>
                                                        @else
                                                            <span class="badge badge-danger">Not Available</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h5>Description</h5>
                                        <p class="text-muted">{{ $product->description }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sales History -->
                            <div class="card" style="border-radius: 20px;">
                                <div class="card-header">
                                    <h3 class="card-title">Sales History</h3>
                                </div>
                                <div class="card-body">
                                    @if($product->customers->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>Sale Date</th>
                                                        <th>Sale Price</th>
                                                        <th>Status</th>
                                                        <th>Warranty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($product->customers as $customer)
                                                        <tr>
                                                            <td>{{ $customer->customer_name }}</td>
                                                            <td>{{ $customer->sale_date->format('M d, Y') }}</td>
                                                            <td><strong class="text-success">${{ number_format($customer->sale_price, 2) }}</strong></td>
                                                            <td>
                                                                @switch($customer->sale_status)
                                                                    @case('sold')
                                                                        <span class="badge badge-success">Sold</span>
                                                                        @break
                                                                    @case('returned')
                                                                        <span class="badge badge-warning">Returned</span>
                                                                        @break
                                                                    @case('warranty_claim')
                                                                        <span class="badge badge-info">Warranty Claim</span>
                                                                        @break
                                                                    @case('refunded')
                                                                        <span class="badge badge-danger">Refunded</span>
                                                                        @break
                                                                    @default
                                                                        <span class="badge badge-secondary">{{ ucfirst($customer->sale_status) }}</span>
                                                                @endswitch
                                                            </td>
                                                            <td>
                                                                @if($customer->isWarrantyValid())
                                                                    <span class="badge badge-success">
                                                                        Valid ({{ $customer->getWarrantyDaysRemaining() }} days)
                                                                    </span>
                                                                @else
                                                                    <span class="badge badge-danger">Expired</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-shopping-cart text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-2">No sales recorded for this product yet.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Product Images & Quick Stats -->
                        <div class="col-md-4">
                            <!-- Product Images -->
                            <div class="card" style="border-radius: 20px;">
                                <div class="card-header">
                                    <h3 class="card-title">Product Images</h3>
                                </div>
                                <div class="card-body">
                                    @if($product->images->count() > 0)
                                        <!-- Primary Image -->
                                        <div class="text-center mb-3">
                                            <img src="{{ $product->primaryImage ? $product->primaryImage->image_url : $product->images->first()->image_url }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="img-fluid rounded" 
                                                 style="max-height: 250px; cursor: pointer;"
                                                 onclick="openImageGallery()">
                                        </div>
                                        
                                        <!-- Thumbnail Gallery -->
                                        @if($product->images->count() > 1)
                                            <div class="row">
                                                @foreach($product->images->take(4) as $image)
                                                    <div class="col-3 mb-2">
                                                        <img src="{{ $image->image_url }}" 
                                                             alt="{{ $product->name }}" 
                                                             class="img-thumbnail w-100" 
                                                             style="height: 60px; object-fit: cover; cursor: pointer;"
                                                             onclick="openImageGallery({{ $loop->index }})">
                                                        @if($image->is_primary)
                                                            <span class="badge badge-primary position-absolute" style="top: -5px; right: -5px; font-size: 0.6rem;">P</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                @if($product->images->count() > 4)
                                                    <div class="col-3 mb-2">
                                                        <div class="img-thumbnail w-100 d-flex align-items-center justify-content-center" 
                                                             style="height: 60px; background: #f8f9fa; cursor: pointer;"
                                                             onclick="openImageGallery()">
                                                            <span class="text-muted">+{{ $product->images->count() - 4 }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @elseif($product->image)
                                        <!-- Legacy single image support -->
                                        <div class="text-center">
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="img-fluid rounded" 
                                                 style="max-height: 300px;">
                                        </div>
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 300px;">
                                            <div>
                                                <i class="fas fa-mobile-alt text-muted" style="font-size: 4rem;"></i>
                                                <p class="text-muted mt-2">No images available</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="card" style="border-radius: 20px;">
                                <div class="card-header">
                                    <h3 class="card-title">Quick Stats</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="small-box bg-info">
                                                <div class="inner">
                                                    <h3>{{ $product->customers->count() }}</h3>
                                                    <p>Total Sales</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>${{ number_format($product->customers->sum('sale_price'), 2) }}</h3>
                                                    <p>Total Revenue</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock Alert -->
                            @if($product->quantity <= 5)
                                <div class="card card-warning" style="border-radius: 20px;">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>Stock Alert
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-2">This product is running low on stock!</p>
                                        <p class="mb-3"><strong>Current Stock: {{ $product->quantity }}</strong></p>
                                        <button type="button" class="btn btn-warning btn-block" 
                                                onclick="updateStock({{ $product->id }}, '{{ $product->name }}', {{ $product->quantity }})">
                                            <i class="fas fa-warehouse mr-2"></i>Update Stock
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stock Update Modal -->
    <div class="modal fade" id="stockModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Stock</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="stockForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" id="productName" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="newQuantity">New Quantity</label>
                            <input type="number" id="newQuantity" name="quantity" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Stock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Gallery Modal -->
    <div class="modal fade" id="imageGalleryModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $product->name }} - Image Gallery</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="imageGalleryCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @if($product->images->count() > 0)
                                @foreach($product->images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ $image->image_url }}" class="d-block w-100" style="max-height: 500px; object-fit: contain;" alt="{{ $product->name }}">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5>Image {{ $index + 1 }}</h5>
                                            @if($image->is_primary)
                                                <span class="badge badge-primary">Primary Image</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="carousel-item active">
                                    <div class="d-flex align-items-center justify-content-center" style="height: 400px;">
                                        <div class="text-center">
                                            <i class="fas fa-image text-muted" style="font-size: 4rem;"></i>
                                            <p class="text-muted mt-2">No images available</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if($product->images->count() > 1)
                            <a class="carousel-control-prev" href="#imageGalleryCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#imageGalleryCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    function updateStock(productId, productName, currentQuantity) {
        $('#productName').val(productName);
        $('#newQuantity').val(currentQuantity);
        $('#stockForm').attr('action', '{{ route("admin.products.update-stock", ":id") }}'.replace(':id', productId));
        $('#stockModal').modal('show');
    }

    function openImageGallery(startIndex = 0) {
        $('#imageGalleryModal').modal('show');
        
        // Set the active slide if startIndex is provided
        if (startIndex > 0) {
            setTimeout(() => {
                $('#imageGalleryCarousel').carousel(startIndex);
            }, 100);
        }
    }
</script>
@endsection
