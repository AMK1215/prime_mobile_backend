@extends('layouts.master')

@section('title', 'Sales Report')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Reports</a></li>
                    <li class="breadcrumb-item active">Sales Report</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-3">
            <h3><i class="fas fa-dollar-sign mr-2"></i>Sales Report</h3>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
            </a>
        </div>

        <!-- Date Filter -->
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filter by Date Range</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.reports.sales') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search mr-1"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.reports.export-sales', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
                                       class="btn btn-success">
                                        <i class="fas fa-file-excel mr-1"></i> Export CSV
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-lg-4">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Revenue</span>
                        <span class="info-box-number">${{ number_format($totalRevenue, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Sales</span>
                        <span class="info-box-number">{{ $totalSales }}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-chart-line"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Average Sale</span>
                        <span class="info-box-number">${{ number_format($averageSale, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sales by Status -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sales by Status</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            @foreach($salesByStatus as $status => $data)
                            <tr>
                                <td><strong>{{ ucfirst($status) }}</strong></td>
                                <td>{{ $data['count'] }} sales</td>
                                <td class="text-success">${{ number_format($data['revenue'], 2) }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sales by Branch -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sales by Branch</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            @foreach($salesByBranch as $branch => $data)
                            <tr>
                                <td><strong>{{ $branch }}</strong></td>
                                <td>{{ $data['count'] }} sales</td>
                                <td class="text-success">${{ number_format($data['revenue'], 2) }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sales Details</h3>
                    </div>
                    <div class="card-body">
                        <table id="salesTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Branch</th>
                                    <th>Sold By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $sale)
                                <tr>
                                    <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                                    <td>{{ $sale->customer_name }}</td>
                                    <td>{{ $sale->product->name }}</td>
                                    <td class="text-success font-weight-bold">${{ number_format($sale->sale_price, 2) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $sale->sale_status == 'sold' ? 'success' : 'warning' }}">
                                            {{ ucfirst($sale->sale_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $sale->branch }}</td>
                                    <td>{{ $sale->owner->name }}</td>
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
    $('#salesTable').DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "order": [[0, "desc"]],
        "pageLength": 25
    });
});
</script>
@endsection
