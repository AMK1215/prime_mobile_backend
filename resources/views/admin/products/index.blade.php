@extends('layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Product Management</li>
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
                        <h3>Product Management</h3>
                        <div class="btn-group">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                                <i class="fas fa-plus text-white mr-2"></i>Add New Product
                            </a>
                            <a href="{{ route('admin.product-categories.index') }}" class="btn btn-info">
                                <i class="fas fa-tags text-white mr-2"></i>Manage Categories
                            </a>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $totalProducts }}</h3>
                                    <p>Total Products</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $availableProducts }}</h3>
                                    <p>Available Products</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $lowStockProducts }}</h3>
                                    <p>Low Stock</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $outOfStockProducts }}</h3>
                                    <p>Out of Stock</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="border-radius: 20px;">
                        <div class="card-header">
                            <h3>Products List</h3>
                        </div>
                        <div class="card-body">
                            <!-- Filters -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <select id="categoryFilter" class="form-control select2bs4">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="statusFilter" class="form-control select2bs4">
                                        <option value="">All Statuses</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="stockFilter" class="form-control select2bs4">
                                        <option value="">All Stock Levels</option>
                                        <option value="in_stock">In Stock</option>
                                        <option value="low_stock">Low Stock</option>
                                        <option value="out_of_stock">Out of Stock</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search products...">
                                </div>
                            </div>

                            <table id="productsTable" class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">#</th>
                                        <th class="text-center" style="width: 80px;">Image</th>
                                        <th>Product Name</th>
                                        <th class="text-center" style="width: 150px;">Category</th>
                                        <th class="text-center" style="width: 100px;">Price</th>
                                        <th class="text-center" style="width: 80px;">Stock</th>
                                        <th class="text-center" style="width: 120px;">Status</th>
                                        <th class="text-center" style="width: 120px;">Created</th>
                                        <th class="text-center" style="width: 180px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                            <td class="text-center align-middle">
                                                @if($product->images->count() > 0)
                                                    <div class="position-relative d-inline-block">
                                                        <img src="{{ $product->primaryImage ? $product->primaryImage->image_url : $product->images->first()->image_url }}" 
                                                             alt="{{ $product->name }}" 
                                                             class="img-thumbnail rounded" 
                                                             style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                                             onclick="viewImageGallery({{ $product->id }}, '{{ $product->name }}')">
                                                        @if($product->images->count() > 1)
                                                            <span class="badge badge-info position-absolute" style="top: -5px; right: -5px; font-size: 0.7rem;">
                                                                +{{ $product->images->count() - 1 }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @elseif($product->image)
                                                    <!-- Legacy single image support -->
                                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                                         alt="{{ $product->name }}" 
                                                         class="img-thumbnail rounded" 
                                                         style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                                         onclick="viewImage('{{ asset('storage/' . $product->image) }}', '{{ $product->name }}')">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center rounded border" 
                                                         style="width: 60px; height: 60px; margin: 0 auto;">
                                                        <i class="fas fa-mobile-alt text-muted fa-2x"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <strong>{{ $product->name }}</strong><br>
                                                <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge badge-info">{{ $product->productCategory->name }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <strong class="text-success">${{ number_format($product->price, 2) }}</strong>
                                            </td>
                                            <td class="text-center align-middle">
                                                @if($product->quantity > 10)
                                                    <span class="badge badge-success">{{ $product->quantity }}</span>
                                                @elseif($product->quantity > 0)
                                                    <span class="badge badge-warning">{{ $product->quantity }}</span>
                                                @else
                                                    <span class="badge badge-danger">0</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
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
                                            <td class="text-center align-middle">{{ $product->created_at->format('M d, Y') }}</td>
                                            <td class="text-center align-middle">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.products.show', $product->id) }}" 
                                                       class="btn btn-info btn-sm" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                                       class="btn btn-primary btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-warning btn-sm" 
                                                            onclick="updateStock({{ $product->id }}, '{{ $product->name }}', {{ $product->quantity }})" 
                                                            title="Update Stock">
                                                        <i class="fas fa-warehouse"></i>
                                                    </button>
                                                    <form class="d-inline" action="{{ route('admin.products.destroy', $product->id) }}" 
                                                          method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
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

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalTitle">Product Image</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="previewImage" src="" alt="" class="img-fluid rounded" style="max-height: 500px;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Gallery Modal -->
    <div class="modal fade" id="imageGalleryModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageGalleryTitle">Product Images</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="imageGalleryContent" class="row">
                        <!-- Images will be loaded here -->
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
    $(document).ready(function() {
        var table = $('#productsTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "order": [[7, "desc"]], // Sort by created date descending
            "pageLength": 25,
            "columnDefs": [
                { "orderable": false, "targets": [1, 8] } // Disable sorting on Image and Actions columns
            ]
        });

        // Category filter
        $('#categoryFilter').on('change', function() {
            var category = $(this).val();
            if (category) {
                table.column(3).search(category, true, false).draw();
            } else {
                table.column(3).search('').draw();
            }
        });

        // Status filter
        $('#statusFilter').on('change', function() {
            var status = $(this).val();
            if (status) {
                table.column(6).search(status, true, false).draw();
            } else {
                table.column(6).search('').draw();
            }
        });

        // Stock filter
        $('#stockFilter').on('change', function() {
            var stock = $(this).val();
            if (stock === 'in_stock') {
                table.column(5).search('^[1-9][0-9]*$', true, false).draw();
            } else if (stock === 'low_stock') {
                table.column(5).search('^[1-9]$', true, false).draw();
            } else if (stock === 'out_of_stock') {
                table.column(5).search('^0$', true, false).draw();
            } else {
                table.column(5).search('').draw();
            }
        });

        // Search input
        $('#searchInput').on('keyup', function() {
            table.search(this.value).draw();
        });
    });

    function updateStock(productId, productName, currentQuantity) {
        $('#productName').val(productName);
        $('#newQuantity').val(currentQuantity);
        $('#stockForm').attr('action', '{{ route("admin.products.update-stock", ":id") }}'.replace(':id', productId));
        $('#stockModal').modal('show');
    }

    function viewImage(imageUrl, productName) {
        $('#imageModalTitle').text(productName);
        $('#previewImage').attr('src', imageUrl);
        $('#previewImage').attr('alt', productName);
        $('#imageModal').modal('show');
    }

    function viewImageGallery(productId, productName) {
        $('#imageGalleryTitle').text(productName + ' - Image Gallery');
        $('#imageGalleryContent').html('<div class="col-12 text-center"><i class="fas fa-spinner fa-spin fa-2x"></i><p>Loading images...</p></div>');
        $('#imageGalleryModal').modal('show');
        
        // Load product images via AJAX
        $.ajax({
            url: `/admin/products/${productId}/images`,
            method: 'GET',
            success: function(response) {
                let galleryHtml = '';
                if (response.images && response.images.length > 0) {
                    response.images.forEach(function(image, index) {
                        galleryHtml += `
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <img src="${image.image_url}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="${productName}">
                                    <div class="card-body p-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Image ${index + 1}</small>
                                            ${image.is_primary ? '<span class="badge badge-primary">Primary</span>' : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    galleryHtml = '<div class="col-12 text-center"><i class="fas fa-image text-muted fa-3x"></i><p class="text-muted mt-2">No images available</p></div>';
                }
                $('#imageGalleryContent').html(galleryHtml);
            },
            error: function() {
                $('#imageGalleryContent').html('<div class="col-12 text-center"><i class="fas fa-exclamation-triangle text-danger fa-3x"></i><p class="text-danger mt-2">Error loading images</p></div>');
            }
        });
    }
</script>
@endsection
