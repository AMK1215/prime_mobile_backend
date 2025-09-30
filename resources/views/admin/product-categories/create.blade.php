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
                        <li class="breadcrumb-item active">Add New Category</li>
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
                            <h3>Add New Product Category</h3>
                        </div>
                        <form action="{{ route('admin.product-categories.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <!-- Basic Information -->
                                        <div class="form-group">
                                            <label for="name">Category Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" required>
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
                                                    <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('parent_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Leave empty to create a root category</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
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

                                        <!-- Category Info -->
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <h3 class="card-title">Category Information</h3>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Total Categories:</strong> {{ $totalCategories }}</p>
                                                <p><strong>Root Categories:</strong> {{ $rootCategories }}</p>
                                                <p><strong>Sub Categories:</strong> {{ $subCategories }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('admin.product-categories.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i>Back to Categories
                                        </a>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save mr-2"></i>Create Category
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

    function fillSampleData() {
        $('#name').val('Gaming Smartphones');
    }

    function clearForm() {
        if (confirm('Are you sure you want to clear all form data?')) {
            $('form')[0].reset();
            $('.select2bs4').val('').trigger('change');
        }
    }
</script>
@endsection
