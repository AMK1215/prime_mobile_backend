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
                        <li class="breadcrumb-item active">Edit Category</li>
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
                            <h3>Edit Category: {{ $productCategory->name }}</h3>
                        </div>
                        <form action="{{ route('admin.product-categories.update', $productCategory->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <!-- Basic Information -->
                                        <div class="form-group">
                                            <label for="name">Category Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $productCategory->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="parent_id">Parent Category</label>
                                            <select class="form-control select2bs4 @error('parent_id') is-invalid @enderror" 
                                                    id="parent_id" name="parent_id">
                                                <option value="">Select Parent Category (Optional)</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" 
                                                            {{ old('parent_id', $productCategory->parent_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('parent_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Leave empty to make this a root category</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <!-- Category Info -->
                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h3 class="card-title">Category Information</h3>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Created:</strong> {{ $productCategory->created_at->format('M d, Y H:i') }}</p>
                                                <p><strong>Last Updated:</strong> {{ $productCategory->updated_at->format('M d, Y H:i') }}</p>
                                                <p><strong>Total Products:</strong> {{ $productCategory->products->count() }}</p>
                                                <p><strong>Sub Categories:</strong> {{ $productCategory->children->count() }}</p>
                                            </div>
                                        </div>

                                        <!-- Warning -->
                                        @if($productCategory->products->count() > 0)
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-exclamation-triangle mr-2"></i>Warning
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <p class="mb-0">This category has {{ $productCategory->products->count() }} products. 
                                                    Changing the parent category may affect product organization.</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('admin.product-categories.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i>Back to Categories
                                        </a>
                                        <a href="{{ route('admin.product-categories.show', $productCategory->id) }}" class="btn btn-info">
                                            <i class="fas fa-eye mr-2"></i>View Category
                                        </a>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save mr-2"></i>Update Category
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
    });
</script>
@endsection
