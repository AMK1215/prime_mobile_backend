@extends('layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Product Categories</li>
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
                        <h3>Product Categories Management</h3>
                        <div class="btn-group">
                            <a href="{{ route('admin.product-categories.create') }}" class="btn btn-success">
                                <i class="fas fa-plus text-white mr-2"></i>Add New Category
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-info">
                                <i class="fas fa-mobile-alt text-white mr-2"></i>Back to Products
                            </a>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $totalCategories }}</h3>
                                    <p>Total Categories</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-tags"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $categoriesWithProducts }}</h3>
                                    <p>Categories with Products</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $emptyCategories }}</h3>
                                    <p>Empty Categories</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ $totalProducts }}</h3>
                                    <p>Total Products</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="border-radius: 20px;">
                        <div class="card-header">
                            <h3>Categories List</h3>
                        </div>
                        <div class="card-body">
                            <table id="categoriesTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category Name</th>
                                        <th>Parent Category</th>
                                        <th>Products Count</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td class="text-sm font-weight-normal">{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $category->name }}</strong>
                                            </td>
                                            <td>
                                                @if($category->parent)
                                                    <span class="badge badge-info">{{ $category->parent->name }}</span>
                                                @else
                                                    <span class="text-muted">Root Category</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-primary">{{ $category->products->count() }}</span>
                                            </td>
                                            <td>{{ $category->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.product-categories.show', $category->id) }}" 
                                                       class="btn btn-info btn-sm" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.product-categories.edit', $category->id) }}" 
                                                       class="btn btn-primary btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form class="d-inline" action="{{ route('admin.product-categories.destroy', $category->id) }}" 
                                                          method="POST" onsubmit="return confirm('Are you sure you want to delete this category? This will also delete all products in this category.')">
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
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#categoriesTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "order": [[4, "desc"]], // Sort by created date descending
            "pageLength": 25,
            "columnDefs": [
                { "orderable": false, "targets": 5 } // Disable sorting on Actions column
            ]
        });
    });
</script>
@endsection
