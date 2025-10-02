@extends('layouts.master')

@section('title', 'Reports Dashboard')

@section('style')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Reports Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-3">
            <h3><i class="fas fa-chart-line mr-2"></i>Reports & Analytics</h3>
            <div class="btn-group">
                <a href="{{ route('admin.reports.sales') }}" class="btn btn-info">
                    <i class="fas fa-dollar-sign mr-1"></i> Sales Report
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <!-- Total Sales -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>${{ number_format($stats['total_sales'], 2) }}</h3>
                        <p>Total Revenue</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>

            <!-- Total Customers -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $stats['total_customers'] }}</h3>
                        <p>Total Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <!-- Total Products -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $stats['total_products'] }}</h3>
                        <p>Total Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                </div>
            </div>

            <!-- Active Warranties -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $stats['active_warranties'] }}</h3>
                        <p>Active Warranties</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Period Statistics -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-calendar-day mr-2"></i>Today</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Sales:</strong> ${{ number_format($stats['today_sales'], 2) }}</p>
                        <p><strong>Customers:</strong> {{ $stats['today_customers'] }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-calendar-alt mr-2"></i>This Month</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Sales:</strong> ${{ number_format($stats['month_sales'], 2) }}</p>
                        <p><strong>Customers:</strong> {{ $stats['month_customers'] }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-calendar mr-2"></i>This Year</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Sales:</strong> ${{ number_format($stats['year_sales'], 2) }}</p>
                        <p><strong>Customers:</strong> {{ $stats['year_customers'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Monthly Sales Chart -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i>Monthly Sales (Last 12 Months)</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlySalesChart" height="80"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-trophy mr-2"></i>Top Selling Products</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($topProducts as $product)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span>{{ $product->name }}</span>
                                    <span class="badge badge-primary">{{ $product->customers_count }} sold</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Sales -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-clock mr-2"></i>Recent Sales</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Branch</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSales as $sale)
                                <tr>
                                    <td>{{ $sale->customer_name }}</td>
                                    <td>{{ $sale->product->name }}</td>
                                    <td class="text-success font-weight-bold">${{ number_format($sale->sale_price, 2) }}</td>
                                    <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $sale->sale_status == 'sold' ? 'success' : 'warning' }}">
                                            {{ ucfirst($sale->sale_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $sale->branch }}</td>
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
    // Monthly Sales Chart
    var ctx = document.getElementById('monthlySalesChart').getContext('2d');
    var monthlySalesData = @json($monthlySales);
    
    var labels = monthlySalesData.map(item => item.month);
    var revenues = monthlySalesData.map(item => item.revenue);
    var counts = monthlySalesData.map(item => item.count);

    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue ($)',
                data: revenues,
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1,
                yAxisID: 'y'
            }, {
                label: 'Sales Count',
                data: counts,
                backgroundColor: 'rgba(0, 123, 255, 0.7)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1,
                type: 'line',
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    position: 'left',
                    title: { display: true, text: 'Revenue ($)' }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    title: { display: true, text: 'Sales Count' },
                    grid: { drawOnChartArea: false }
                }
            }
        }
    });
});
</script>
@endsection
