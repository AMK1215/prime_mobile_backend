@extends('layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.product-categories.index') }}">Categories</a></li>
                        <li class="breadcrumb-item active">Category Details</li>
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
                        <h3>Category Details: {{ $productCategory->name }}</h3>
                        <div class="btn-group">
                            <a href="{{ route('admin.product-categories.edit', $productCategory->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit mr-2"></i>Edit Category
                            </a>
                            <a href="{{ route('admin.product-categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Categories
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Category Information -->
                        <div class="col-md-8">
                            <div class="card" style="border-radius: 20px;">
                                <div class="card-header">
                                    <h3 class="card-title">Category Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Category ID:</strong></td>
                                                    <td>#{{ $productCategory->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Category Name:</strong></td>
                                                    <td><span class="h4 text-primary">{{ $productCategory->name }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Parent Category:</strong></td>
                                                    <td>
                                                        @if($productCategory->parent)
                                                            <span class="badge badge-info">{{ $productCategory->parent->name }}</span>
                                                        @else
                                                            <span class="text-muted">Root Category</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Sub Categories:</strong></td>
                                                    <td><span class="badge badge-success">{{ $productCategory->children->count() }}</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Total Products:</strong></td>
                                                    <td><span class="badge badge-primary">{{ $productCategory->products->count() }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Created:</strong></td>
                                                    <td>{{ $productCategory->created_at->format('M d, Y H:i') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Last Updated:</strong></td>
                                                    <td>{{ $productCategory->updated_at->format('M d, Y H:i') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Products in this Category -->
                            <div class="card" style="border-radius: 20px;">
                                <div class="card-header">
                                    <h3 class="card-title">Products in this Category</h3>
                                </div>
                                <div class="card-body">
                                    @if($productCategory->products->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Price</th>
                                                        <th>Stock</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($productCategory->products as $product)
                                                        <tr>
                                                            <td>
                                                                <strong>{{ $product->name }}</strong><br>
                                                                <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                                            </td>
                                                            <td><strong class="text-success">${{ number_format($product->price, 2) }}</strong></td>
                                                            <td>
                                                                @if($product->quantity > 10)
                                                                    <span class="badge badge-success">{{ $product->quantity }}</span>
                                                                @elseif($product->quantity > 0)
                                                                    <span class="badge badge-warning">{{ $product->quantity }}</span>
                                                                @else
                                                                    <span class="badge badge-danger">0</span>
                                                                @endif
                                                            </td>
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
                                                            <td>{{ $product->created_at->format('M d, Y') }}</td>
                                                            <td>
                                                                <a href="{{ route('admin.products.show', $product->id) }}" 
                                                                   class="btn btn-info btn-sm" title="View">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('admin.products.edit', $product->id) }}" 
                                                                   class="btn btn-primary btn-sm" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-mobile-alt text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-2">No products in this category yet.</p>
                                            <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                                                <i class="fas fa-plus mr-2"></i>Add First Product
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Category Stats & Sub Categories -->
                        <div class="col-md-4">
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
                                                    <h3>{{ $productCategory->products->count() }}</h3>
                                                    <p>Total Products</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-mobile-alt"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>{{ $productCategory->children->count() }}</h3>
                                                    <p>Sub Categories</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-tags"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sub Categories -->
                            @if($productCategory->children->count() > 0)
                                <div class="card" style="border-radius: 20px;">
                                    <div class="card-header">
                                        <h3 class="card-title">Sub Categories</h3>
                                    </div>
                                    <div class="card-body">
                                        @foreach($productCategory->children as $child)
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span>{{ $child->name }}</span>
                                                <div>
                                                    <span class="badge badge-primary">{{ $child->products->count() }} products</span>
                                                    <a href="{{ route('admin.product-categories.show', $child->id) }}" 
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="card" style="border-radius: 20px;">
                                <div class="card-header">
                                    <h3 class="card-title">Quick Actions</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.products.create') }}?category={{ $productCategory->id }}" 
                                           class="btn btn-success">
                                            <i class="fas fa-plus mr-2"></i>Add Product to Category
                                        </a>
                                        <a href="{{ route('admin.product-categories.create') }}?parent={{ $productCategory->id }}" 
                                           class="btn btn-info">
                                            <i class="fas fa-tags mr-2"></i>Add Sub Category
                                        </a>
                                        <a href="{{ route('admin.product-categories.edit', $productCategory->id) }}" 
                                           class="btn btn-primary">
                                            <i class="fas fa-edit mr-2"></i>Edit Category
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
