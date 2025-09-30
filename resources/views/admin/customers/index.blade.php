@extends('layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Customer Sales</li>
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
                        <h3>Customer Sales Management</h3>
                        <a href="{{ route('admin.customers.create') }}" class="btn btn-success">
                            <i class="fas fa-plus text-white mr-2"></i>Record New Sale
                        </a>
                    </div>
                    <div class="card" style="border-radius: 20px;">
                        <div class="card-header">
                            <h3>Customer Sales List</h3>
                        </div>
                        <div class="card-body">
                            <table id="customersTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Product</th>
                                        <th>Phone Model</th>
                                        <th>IMEI</th>
                                        <th>Sale Price</th>
                                        <th>Sale Date</th>
                                        <th>Sale Status</th>
                                        <th>Warranty Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td class="text-sm font-weight-normal">{{ $loop->iteration }}</td>
                                            <td>{{ $customer->customer_name }}</td>
                                            <td>
                                                <strong>{{ $customer->product->name }}</strong><br>
                                                <small class="text-muted">{{ $customer->product->productCategory->name }}</small>
                                            </td>
                                            <td>{{ $customer->phone_model }}</td>
                                            <td>
                                                <code>{{ $customer->imei }}</code>
                                            </td>
                                            <td>
                                                <strong class="text-success">${{ number_format($customer->sale_price, 2) }}</strong>
                                            </td>
                                            <td>{{ $customer->sale_date->format('M d, Y') }}</td>
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
                                                        Valid ({{ $customer->getWarrantyDaysRemaining() }} days left)
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger">Expired</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.customers.show', $customer->id) }}" 
                                                       class="btn btn-info btn-sm" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.customers.edit', $customer->id) }}" 
                                                       class="btn btn-primary btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.customers.vouchers', $customer->id) }}" 
                                                       class="btn btn-success btn-sm" title="View Vouchers">
                                                        <i class="fas fa-gift"></i>
                                                    </a>
                                                    <a href="{{ route('admin.customers.warranty-card', $customer->id) }}" 
                                                       class="btn btn-warning btn-sm" title="Warranty Card">
                                                        <i class="fas fa-shield-alt"></i>
                                                    </a>
                                                    <form class="d-inline" action="{{ route('admin.customers.destroy', $customer->id) }}" 
                                                          method="POST" onsubmit="return confirm('Are you sure you want to delete this customer sale record?')">
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
        $('#customersTable').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "order": [[6, "desc"]], // Sort by sale date descending
            "pageLength": 25,
            "columnDefs": [
                { "orderable": false, "targets": 9 } // Disable sorting on Actions column
            ]
        });
    });
</script>
@endsection
