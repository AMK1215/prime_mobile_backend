@extends('layouts.master')

@section('title', 'Customer Vouchers')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customer Sales</a></li>
                    <li class="breadcrumb-item active">Vouchers for {{ $customer->customer_name }}</li>
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
                    <h3>
                        <i class="fas fa-gift mr-2"></i>
                        Vouchers for {{ $customer->customer_name }}
                    </h3>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Customers
                    </a>
                </div>
                <div class="card" style="border-radius: 20px;">
                    <div class="card-header">
                        <h3>Customer Voucher Management</h3>
                    </div>
                
                <div class="card-body">
                    <!-- Customer Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Customer Information</h5>
                            <p><strong>Name:</strong> {{ $customer->customer_name }}</p>
                            <p><strong>Phone Model:</strong> {{ $customer->phone_model }}</p>
                            <p><strong>Customer ID:</strong> {{ $customer->customer_id }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Voucher Statistics</h5>
                            <div class="row">
                                <div class="col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-gift"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Vouchers</span>
                                            <span class="info-box-number">{{ $voucherStats['total_vouchers'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Valid Vouchers</span>
                                            <span class="info-box-number">{{ $voucherStats['valid_vouchers'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Used Vouchers</span>
                                            <span class="info-box-number">{{ $voucherStats['used_vouchers'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Expired Vouchers</span>
                                            <span class="info-box-number">{{ $voucherStats['expired_vouchers'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Generate New Voucher Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Generate New Voucher</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.customers.generate-voucher', $customer) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="voucher_type">Voucher Type</label>
                                            <select name="voucher_type" id="voucher_type" class="form-control" required>
                                                <option value="purchase">Purchase Discount</option>
                                                <option value="loyalty">Loyalty Discount</option>
                                                <option value="warranty_extension">Warranty Extension</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="discount_percentage">Discount Percentage (%)</label>
                                            <input type="number" name="discount_percentage" id="discount_percentage" 
                                                   class="form-control" min="1" max="100" placeholder="10">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="discount_amount">Discount Amount ($)</label>
                                            <input type="number" name="discount_amount" id="discount_amount" 
                                                   class="form-control" min="0" step="0.01" placeholder="50.00">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="valid_months">Valid For (Months)</label>
                                            <input type="number" name="valid_months" id="valid_months" 
                                                   class="form-control" min="1" max="24" value="6">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus mr-1"></i> Generate Voucher
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Vouchers Table -->
                    <div class="table-responsive">
                        <table id="vouchersTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Voucher Code</th>
                                    <th>Type</th>
                                    <th>Discount</th>
                                    <th>Valid From</th>
                                    <th>Valid Until</th>
                                    <th>Status</th>
                                    <th>Used At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->vouchers as $voucher)
                                <tr>
                                    <td>
                                        <code>{{ $voucher->voucher_code }}</code>
                                        @if($voucher->qr_code_path)
                                        <br><small class="text-muted">QR Code Available</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ ucfirst(str_replace('_', ' ', $voucher->voucher_type)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($voucher->discount_percentage)
                                            {{ $voucher->discount_percentage }}%
                                        @elseif($voucher->discount_amount)
                                            ${{ number_format($voucher->discount_amount, 2) }}
                                        @else
                                            N/A
                                        @endif
                                        @if($voucher->metadata && isset($voucher->metadata['product_name']))
                                            <br><small class="text-muted">For: {{ $voucher->metadata['product_name'] }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $voucher->valid_from->format('M d, Y') }}</td>
                                    <td>{{ $voucher->valid_until->format('M d, Y') }}</td>
                                    <td>
                                        @if($voucher->is_used)
                                            <span class="badge badge-warning">Used</span>
                                        @elseif($voucher->isExpired())
                                            <span class="badge badge-danger">Expired</span>
                                        @elseif($voucher->isValid())
                                            <span class="badge badge-success">Valid</span>
                                        @else
                                            <span class="badge badge-secondary">Not Yet Valid</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($voucher->used_at)
                                            {{ $voucher->used_at->format('M d, Y H:i') }}
                                        @else
                                            <span class="text-muted">Not used</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ $voucher->voucher_url }}" target="_blank" 
                                               class="btn btn-sm btn-info" title="View Voucher">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($voucher->qr_code_path)
                                            <a href="{{ $voucher->qr_code_url }}" target="_blank" 
                                               class="btn btn-sm btn-secondary" title="View QR Code">
                                                <i class="fas fa-qrcode"></i>
                                            </a>
                                            @endif
                                            @if($voucher->metadata)
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    data-toggle="modal" data-target="#voucherDetailsModal{{ $voucher->id }}" 
                                                    title="View Customer Details">
                                                <i class="fas fa-user"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No vouchers found for this customer.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Voucher Details Modals -->
@foreach($customer->vouchers as $voucher)
@if($voucher->metadata)
<div class="modal fade" id="voucherDetailsModal{{ $voucher->id }}" tabindex="-1" role="dialog" aria-labelledby="voucherDetailsModalLabel{{ $voucher->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voucherDetailsModalLabel{{ $voucher->id }}">
                    <i class="fas fa-gift mr-2"></i>
                    Voucher Details - {{ $voucher->voucher_code }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="font-weight-bold text-primary">Customer Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{ $voucher->metadata['customer_name'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Customer ID:</strong></td>
                                <td>{{ $voucher->metadata['customer_id'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Phone Model:</strong></td>
                                <td>{{ $voucher->metadata['phone_model'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>IMEI:</strong></td>
                                <td><code>{{ $voucher->metadata['imei'] ?? 'N/A' }}</code></td>
                            </tr>
                            <tr>
                                <td><strong>Branch:</strong></td>
                                <td>{{ $voucher->metadata['branch'] ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="font-weight-bold text-success">Purchase Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Product:</strong></td>
                                <td>{{ $voucher->metadata['product_name'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Category:</strong></td>
                                <td>{{ $voucher->metadata['product_category'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Sale Price:</strong></td>
                                <td><strong class="text-success">${{ number_format($voucher->metadata['sale_price'] ?? 0, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Sale Date:</strong></td>
                                <td>{{ $voucher->metadata['sale_date'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Voucher Created:</strong></td>
                                <td>{{ $voucher->metadata['created_at'] ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="font-weight-bold text-warning">Warranty Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Warranty Start:</strong></td>
                                <td>{{ $voucher->metadata['warranty_start_date'] ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Warranty End:</strong></td>
                                <td>{{ $voucher->metadata['warranty_end_date'] ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="printVoucherDetails('{{ $voucher->id }}')">
                    <i class="fas fa-print mr-1"></i> Print Voucher
                </button>
                <a href="{{ $voucher->voucher_url }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-external-link-alt mr-1"></i> View Full Voucher
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection

@section('script')
<script>
$(document).ready(function() {
    // Toggle between percentage and amount based on voucher type
    $('#voucher_type').change(function() {
        var type = $(this).val();
        if (type === 'warranty_extension') {
            $('#discount_percentage, #discount_amount').prop('disabled', true).val('');
        } else {
            $('#discount_percentage, #discount_amount').prop('disabled', false);
        }
    });
    
    // Initialize DataTable for vouchers table
    $('#vouchersTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "order": [[4, "desc"]], // Sort by Valid Until descending
        "pageLength": 25,
        "columnDefs": [
            { "orderable": false, "targets": 7 } // Disable sorting on Actions column
        ]
    });
});

// Print voucher details function
function printVoucherDetails(voucherId) {
    // Get the modal content
    var modalContent = document.querySelector('#voucherDetailsModal' + voucherId + ' .modal-content');
    
    // Create a new window for printing
    var printWindow = window.open('', '_blank', 'width=800,height=600');
    
    // Get voucher data from the modal
    var voucherCode = document.querySelector('#voucherDetailsModal' + voucherId + ' .modal-title').textContent.replace('Voucher Details - ', '');
    
    // Create print-friendly HTML
    var printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Voucher Details - ${voucherCode}</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    color: #333;
                }
                .header {
                    text-align: center;
                    border-bottom: 2px solid #007bff;
                    padding-bottom: 20px;
                    margin-bottom: 30px;
                }
                .header h1 {
                    color: #007bff;
                    margin: 0;
                }
                .header h2 {
                    color: #6c757d;
                    margin: 5px 0 0 0;
                    font-weight: normal;
                }
                .content {
                    display: flex;
                    gap: 30px;
                }
                .section {
                    flex: 1;
                    border: 1px solid #dee2e6;
                    border-radius: 8px;
                    padding: 20px;
                    margin-bottom: 20px;
                }
                .section h3 {
                    margin-top: 0;
                    margin-bottom: 15px;
                    padding-bottom: 10px;
                    border-bottom: 1px solid #dee2e6;
                }
                .customer-info h3 { color: #007bff; }
                .purchase-info h3 { color: #28a745; }
                .warranty-info h3 { color: #ffc107; }
                .info-table {
                    width: 100%;
                    border-collapse: collapse;
                }
                .info-table td {
                    padding: 8px 0;
                    border-bottom: 1px solid #f8f9fa;
                }
                .info-table td:first-child {
                    font-weight: bold;
                    width: 40%;
                }
                .highlight {
                    color: #28a745;
                    font-weight: bold;
                }
                .code {
                    font-family: monospace;
                    background-color: #f8f9fa;
                    padding: 2px 6px;
                    border-radius: 4px;
                }
                .footer {
                    text-align: center;
                    margin-top: 30px;
                    padding-top: 20px;
                    border-top: 1px solid #dee2e6;
                    color: #6c757d;
                    font-size: 12px;
                }
                @media print {
                    body { margin: 0; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>🎁 Voucher Details</h1>
                <h2>Voucher Code: ${voucherCode}</h2>
            </div>
            
            <div class="content">
                <div class="section customer-info">
                    <h3>👤 Customer Information</h3>
                    <table class="info-table">
                        <tr><td>Name:</td><td>${modalContent.querySelector('tr:nth-child(1) td:last-child').textContent}</td></tr>
                        <tr><td>Customer ID:</td><td class="code">${modalContent.querySelector('tr:nth-child(2) td:last-child').textContent}</td></tr>
                        <tr><td>Phone Model:</td><td>${modalContent.querySelector('tr:nth-child(3) td:last-child').textContent}</td></tr>
                        <tr><td>IMEI:</td><td class="code">${modalContent.querySelector('tr:nth-child(4) td:last-child').textContent}</td></tr>
                        <tr><td>Branch:</td><td>${modalContent.querySelector('tr:nth-child(5) td:last-child').textContent}</td></tr>
                    </table>
                </div>
                
                <div class="section purchase-info">
                    <h3>🛒 Purchase Information</h3>
                    <table class="info-table">
                        <tr><td>Product:</td><td>${modalContent.querySelector('.col-md-6:last-child tr:nth-child(1) td:last-child').textContent}</td></tr>
                        <tr><td>Category:</td><td>${modalContent.querySelector('.col-md-6:last-child tr:nth-child(2) td:last-child').textContent}</td></tr>
                        <tr><td>Sale Price:</td><td class="highlight">${modalContent.querySelector('.col-md-6:last-child tr:nth-child(3) td:last-child').textContent}</td></tr>
                        <tr><td>Sale Date:</td><td>${modalContent.querySelector('.col-md-6:last-child tr:nth-child(4) td:last-child').textContent}</td></tr>
                        <tr><td>Voucher Created:</td><td>${modalContent.querySelector('.col-md-6:last-child tr:nth-child(5) td:last-child').textContent}</td></tr>
                    </table>
                </div>
            </div>
            
            <div class="section warranty-info">
                <h3>🛡️ Warranty Information</h3>
                <table class="info-table">
                    <tr><td>Warranty Start:</td><td>${modalContent.querySelector('.row.mt-3 tr:nth-child(1) td:last-child').textContent}</td></tr>
                    <tr><td>Warranty End:</td><td>${modalContent.querySelector('.row.mt-3 tr:nth-child(2) td:last-child').textContent}</td></tr>
                </table>
            </div>
            
            <div class="footer">
                <p>Generated on ${new Date().toLocaleString()} | PhoneShop Management System</p>
            </div>
        </body>
        </html>
    `;
    
    // Write content to print window
    printWindow.document.write(printContent);
    printWindow.document.close();
    
    // Wait for content to load, then print
    printWindow.onload = function() {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
}
</script>
@endsection
