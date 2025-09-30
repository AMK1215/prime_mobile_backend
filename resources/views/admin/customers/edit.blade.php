@extends('layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customer Sales</a></li>
                        <li class="breadcrumb-item active">Edit Customer Sale</li>
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
                            <h3>Edit Customer Sale</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <!-- Customer Information -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Customer Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="customer_name">Customer Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                                           id="customer_name" name="customer_name" value="{{ old('customer_name', $customer->customer_name) }}" required>
                                                    @error('customer_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="phone_model">Phone Model <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('phone_model') is-invalid @enderror" 
                                                           id="phone_model" name="phone_model" value="{{ old('phone_model', $customer->phone_model) }}" required>
                                                    @error('phone_model')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="imei">IMEI Number <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('imei') is-invalid @enderror" 
                                                           id="imei" name="imei" value="{{ old('imei', $customer->imei) }}" required>
                                                    @error('imei')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="phone_information">Phone Information</label>
                                                    <textarea class="form-control @error('phone_information') is-invalid @enderror" 
                                                              id="phone_information" name="phone_information" rows="3">{{ old('phone_information', $customer->phone_information) }}</textarea>
                                                    @error('phone_information')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                @if($customer->phone_photo)
                                                <div class="form-group">
                                                    <label>Current Phone Photo</label>
                                                    <div>
                                                        <img src="{{ asset('storage/' . $customer->phone_photo) }}" 
                                                             alt="Current Phone Photo" class="img-thumbnail" style="max-width: 200px;">
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="form-group">
                                                    <label for="phone_photo">
                                                        {{ $customer->phone_photo ? 'Update Phone Photo' : 'Phone Photo' }}
                                                    </label>
                                                    <input type="file" class="form-control @error('phone_photo') is-invalid @enderror" 
                                                           id="phone_photo" name="phone_photo" accept="image/*">
                                                    @error('phone_photo')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product & Sale Information -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Product & Sale Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="product_id">Product <span class="text-danger">*</span></label>
                                                    <select class="form-control select2bs4 @error('product_id') is-invalid @enderror" 
                                                            id="product_id" name="product_id" required>
                                                        <option value="">Select Product</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" 
                                                                    data-price="{{ $product->price }}"
                                                                    data-category="{{ $product->productCategory->id }}"
                                                                    {{ old('product_id', $customer->product_id) == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }} - ${{ number_format($product->price, 2) }}
                                                                @if($product->quantity <= 0 && $product->id != $customer->product_id)
                                                                    (Out of Stock)
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('product_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="product_category_id">Product Category <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('product_category_id') is-invalid @enderror" 
                                                            id="product_category_id" name="product_category_id" required>
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" 
                                                                    {{ old('product_category_id', $customer->product_category_id) == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('product_category_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="sale_price">Sale Price <span class="text-danger">*</span></label>
                                                    <input type="number" step="0.01" min="0" 
                                                           class="form-control @error('sale_price') is-invalid @enderror" 
                                                           id="sale_price" name="sale_price" value="{{ old('sale_price', $customer->sale_price) }}" required>
                                                    @error('sale_price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="sale_date">Sale Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control @error('sale_date') is-invalid @enderror" 
                                                           id="sale_date" name="sale_date" value="{{ old('sale_date', $customer->sale_date->format('Y-m-d')) }}" required>
                                                    @error('sale_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="sale_status">Sale Status <span class="text-danger">*</span></label>
                                                    <select class="form-control @error('sale_status') is-invalid @enderror" 
                                                            id="sale_status" name="sale_status" required>
                                                        <option value="">Select Status</option>
                                                        <option value="sold" {{ old('sale_status', $customer->sale_status) == 'sold' ? 'selected' : '' }}>Sold</option>
                                                        <option value="returned" {{ old('sale_status', $customer->sale_status) == 'returned' ? 'selected' : '' }}>Returned</option>
                                                        <option value="warranty_claim" {{ old('sale_status', $customer->sale_status) == 'warranty_claim' ? 'selected' : '' }}>Warranty Claim</option>
                                                        <option value="refunded" {{ old('sale_status', $customer->sale_status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                                    </select>
                                                    @error('sale_status')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="branch">Branch <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('branch') is-invalid @enderror" 
                                                           id="branch" name="branch" value="{{ old('branch', $customer->branch) }}" required>
                                                    @error('branch')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Warranty Information -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Warranty Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="warranty_start_date">Warranty Start Date <span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control @error('warranty_start_date') is-invalid @enderror" 
                                                                   id="warranty_start_date" name="warranty_start_date" 
                                                                   value="{{ old('warranty_start_date', $customer->warranty_start_date->format('Y-m-d')) }}" required>
                                                            @error('warranty_start_date')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="warranty_end_date">Warranty End Date <span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control @error('warranty_end_date') is-invalid @enderror" 
                                                                   id="warranty_end_date" name="warranty_end_date" 
                                                                   value="{{ old('warranty_end_date', $customer->warranty_end_date->format('Y-m-d')) }}" required>
                                                            @error('warranty_end_date')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save mr-2"></i>Update Sale
                                        </button>
                                        <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-info ml-2">
                                            <i class="fas fa-eye mr-2"></i>View Details
                                        </a>
                                        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary ml-2">
                                            <i class="fas fa-arrow-left mr-2"></i>Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
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
        // Initialize Select2
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        // Auto-fill sale price when product is selected
        $('#product_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var price = selectedOption.data('price');
            var categoryId = selectedOption.data('category');
            
            if (price) {
                $('#sale_price').val(price);
            }
            
            if (categoryId) {
                $('#product_category_id').val(categoryId);
            }
        });

        // Auto-calculate warranty end date (1 year from start date)
        $('#warranty_start_date').on('change', function() {
            var startDate = new Date($(this).val());
            if (startDate) {
                var endDate = new Date(startDate);
                endDate.setFullYear(endDate.getFullYear() + 1);
                $('#warranty_end_date').val(endDate.toISOString().split('T')[0]);
            }
        });
    });
</script>
@endsection
