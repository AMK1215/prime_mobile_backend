<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warranty Card - {{ $customer->customer_name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
        }
        .warranty-card {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 20px;
        }
        .qr-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .qr-code {
            width: 150px;
            height: 150px;
            margin: 0 auto 10px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 10px;
            background: white;
        }
        .qr-code img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .info-section {
            margin-bottom: 15px;
        }
        .info-section h3 {
            color: #495057;
            font-size: 14px;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-section p {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #212529;
        }
        .warranty-status {
            background: {{ $customer->isWarrantyValid() ? '#d4edda' : '#f8d7da' }};
            color: {{ $customer->isWarrantyValid() ? '#155724' : '#721c24' }};
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin: 15px 0;
        }
        .warranty-status h4 {
            margin: 0 0 5px 0;
            font-size: 16px;
        }
        .warranty-status p {
            margin: 0;
            font-size: 14px;
        }
        .footer {
            background: #f8f9fa;
            padding: 15px 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 0;
            font-size: 12px;
            color: #6c757d;
        }
        .contact-info {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .contact-info span {
            font-size: 11px;
            color: #6c757d;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .warranty-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <div class="warranty-card">
        <!-- Header -->
        <div class="header">
            <h1>Warranty Card</h1>
            <p>{{ config('app.name', 'PhoneShop') }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- QR Code Section -->
            <div class="qr-section">
                <div class="qr-code">
                    <img src="{{ $customer->qr_code_url }}" alt="Warranty QR Code">
                </div>
                <p style="font-size: 12px; color: #6c757d; margin: 0;">
                    Scan QR code to view warranty details
                </p>
            </div>

            <!-- Customer Information -->
            <div class="info-section">
                <h3>Customer Name</h3>
                <p>{{ $customer->customer_name }}</p>
            </div>

            <div class="info-section">
                <h3>Phone Model</h3>
                <p>{{ $customer->phone_model }}</p>
            </div>

            <div class="info-section">
                <h3>Customer ID</h3>
                <p style="font-family: monospace; font-size: 14px;">{{ $customer->customer_id }}</p>
            </div>

            <div class="info-section">
                <h3>IMEI Number</h3>
                <p style="font-family: monospace; font-size: 14px;">{{ $customer->imei }}</p>
            </div>

            <div class="info-section">
                <h3>Sale Date</h3>
                <p>{{ $customer->sale_date->format('M d, Y') }}</p>
            </div>

            <!-- Warranty Status -->
            <div class="warranty-status">
                <h4>
                    @if($customer->isWarrantyValid())
                        ✓ Warranty Valid
                    @else
                        ✗ Warranty Expired
                    @endif
                </h4>
                <p>
                    @if($customer->isWarrantyValid())
                        {{ $customer->getWarrantyDaysRemaining() }} days remaining
                    @else
                        Expired on {{ $customer->warranty_end_date->format('M d, Y') }}
                    @endif
                </p>
            </div>

            <!-- Warranty Period -->
            <div class="info-section">
                <h3>Warranty Period</h3>
                <p>{{ $customer->warranty_start_date->format('M d, Y') }} - {{ $customer->warranty_end_date->format('M d, Y') }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Terms & Conditions:</strong></p>
            <p>This warranty covers manufacturing defects only. Physical damage, water damage, or unauthorized modifications are not covered. Please keep this card safe.</p>
            
            <div class="contact-info">
                <span>📞 {{ config('app.support_phone', '+1-234-567-8900') }}</span>
                <span>✉️ {{ config('mail.from.address', 'support@phoneshop.com') }}</span>
            </div>
        </div>
    </div>

    <script>
        // Auto-print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
