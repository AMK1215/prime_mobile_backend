@extends('layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customer Sales</a></li>
                        <li class="breadcrumb-item active">Customer Details</li>
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
                            <div class="d-flex justify-content-between align-items-center">
                                <h3>Customer Sale Details</h3>
                                <div>
                                    <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit mr-2"></i>Edit
                                    </a>
                                    <form class="d-inline" action="{{ route('admin.customers.regenerate-qr', $customer->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-info" title="Regenerate QR Code">
                                            <i class="fas fa-qrcode mr-2"></i>Regenerate QR
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.customers.warranty-card', $customer->id) }}" target="_blank" class="btn btn-success" title="Print Warranty Card">
                                        <i class="fas fa-print mr-2"></i>Print Card
                                    </a>
                                    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left mr-2"></i>Back to List
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Customer Information -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fas fa-user mr-2"></i>Customer Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Customer Name:</strong></td>
                                                    <td>{{ $customer->customer_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Phone Model:</strong></td>
                                                    <td>{{ $customer->phone_model }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>IMEI Number:</strong></td>
                                                    <td><code>{{ $customer->imei }}</code></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Branch:</strong></td>
                                                    <td>{{ $customer->branch }}</td>
                                                </tr>
                                                @if($customer->phone_information)
                                                <tr>
                                                    <td><strong>Phone Information:</strong></td>
                                                    <td>{{ $customer->phone_information }}</td>
                                                </tr>
                                                @endif
                                                @if($customer->phone_photo)
                                                <tr>
                                                    <td><strong>Phone Photo:</strong></td>
                                                    <td>
                                                        <img src="{{ asset('storage/' . $customer->phone_photo) }}" 
                                                             alt="Phone Photo" class="img-thumbnail" style="max-width: 200px;">
                                                    </td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product & Sale Information -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fas fa-shopping-cart mr-2"></i>Product & Sale Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Product:</strong></td>
                                                    <td>
                                                        <strong>{{ $customer->product->name }}</strong><br>
                                                        <small class="text-muted">{{ $customer->product->productCategory->name }}</small>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Sale Price:</strong></td>
                                                    <td><strong class="text-success">${{ number_format($customer->sale_price, 2) }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Sale Date:</strong></td>
                                                    <td>{{ $customer->sale_date->format('F d, Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Sale Status:</strong></td>
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
                                                </tr>
                                                <tr>
                                                    <td><strong>Recorded By:</strong></td>
                                                    <td>{{ $customer->owner->name }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Warranty Information -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fas fa-shield-alt mr-2"></i>Warranty Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="info-box">
                                                        <span class="info-box-icon bg-info">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Warranty Start</span>
                                                            <span class="info-box-number">{{ $customer->warranty_start_date->format('M d, Y') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="info-box">
                                                        <span class="info-box-icon bg-warning">
                                                            <i class="fas fa-calendar-times"></i>
                                                        </span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Warranty End</span>
                                                            <span class="info-box-number">{{ $customer->warranty_end_date->format('M d, Y') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="info-box">
                                                        @if($customer->isWarrantyValid())
                                                            <span class="info-box-icon bg-success">
                                                                <i class="fas fa-check-circle"></i>
                                                            </span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-text">Warranty Status</span>
                                                                <span class="info-box-number">{{ $customer->getWarrantyDaysRemaining() }} days left</span>
                                                            </div>
                                                        @else
                                                            <span class="info-box-icon bg-danger">
                                                                <i class="fas fa-times-circle"></i>
                                                            </span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-text">Warranty Status</span>
                                                                <span class="info-box-number">Expired</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- QR Code Section -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fas fa-qrcode mr-2"></i>Warranty QR Code</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="text-center">
                                                        <h6>QR Code for Warranty Card</h6>
                                                        <img src="{{ $customer->qr_code_url }}" alt="Warranty QR Code" class="img-fluid" style="max-width: 200px;">
                                                        <p class="text-muted mt-2">
                                                            <small>Scan this QR code to view warranty information</small>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-box">
                                                        <span class="info-box-icon bg-primary">
                                                            <i class="fas fa-link"></i>
                                                        </span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Warranty URL</span>
                                                            <span class="info-box-number">
                                                                <a href="{{ $customer->warranty_url }}" target="_blank" class="text-decoration-none">
                                                                    {{ $customer->warranty_url }}
                                                                </a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3">
                                                        <h6>Instructions for Customer:</h6>
                                                        <ol class="text-sm">
                                                            <li>Print this QR code on the warranty card</li>
                                                            <li>Customer can scan with any smartphone camera</li>
                                                            <li>QR code will open warranty information page</li>
                                                            <li>Shows product details, warranty status, and contact info</li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><i class="fas fa-history mr-2"></i>Sale Timeline</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="timeline">
                                                <div class="time-label">
                                                    <span class="bg-green">{{ $customer->sale_date->format('M d, Y') }}</span>
                                                </div>
                                                <div>
                                                    <i class="fas fa-shopping-cart bg-blue"></i>
                                                    <div class="timeline-item">
                                                        <span class="time"><i class="fas fa-clock"></i> {{ $customer->created_at->format('h:i A') }}</span>
                                                        <h3 class="timeline-header">
                                                            <strong>Sale Recorded</strong>
                                                        </h3>
                                                        <div class="timeline-body">
                                                            Customer {{ $customer->customer_name }} purchased {{ $customer->product->name }} 
                                                            for ${{ number_format($customer->sale_price, 2) }}. 
                                                            Warranty valid until {{ $customer->warranty_end_date->format('F d, Y') }}.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <i class="fas fa-clock bg-gray"></i>
                                                </div>
                                            </div>
                                        </div>
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
