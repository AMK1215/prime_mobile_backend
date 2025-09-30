# QR Code Warranty System

## 📱 Overview

The QR Code Warranty System allows customers to scan a QR code on their warranty card to instantly view their warranty information, product details, and contact information through a mobile-friendly web interface.

## 🎯 Features

### ✅ **Backend Features**
- **Automatic QR Code Generation**: QR codes are generated automatically when creating customer sales
- **Warranty API Endpoints**: Public API endpoints for warranty lookup by IMEI
- **QR Code Management**: Regenerate QR codes, delete old ones, and manage storage
- **Print-Ready Warranty Cards**: Professional warranty card templates for printing
- **Database Integration**: QR code paths stored in customer records

### ✅ **Frontend Features**
- **Mobile-Responsive Warranty Page**: Beautiful, mobile-first warranty display
- **Real-time Warranty Status**: Shows valid/expired status with days remaining
- **Product Information Display**: Complete product details and images
- **Customer Information**: Customer details, phone model, and IMEI
- **Contact Information**: Shop contact details and support information
- **Error Handling**: Graceful error handling for invalid IMEIs

## 🏗️ System Architecture

### **Backend Components**

#### 1. **QRCodeService** (`app/Services/QRCodeService.php`)
```php
// Generate QR code with logo
$qrService = new QRCodeService();
$qrCodePath = $qrService->generateWarrantyQRWithLogo($customer_id);

// Get QR code data URI for inline display
$dataUri = $qrService->getQRCodeDataUri($customer_id);

// Delete QR code file
$qrService->deleteQRCode($customer_id);
```

#### 2. **WarrantyController** (`app/Http/Controllers/Api/V1/WarrantyController.php`)
```php
// Get complete warranty information
GET /api/warranty/imei/{imei}

// Get lightweight warranty status
GET /api/warranty/status/{imei}
```

#### 3. **Customer Model Updates**
```php
// New attributes
'qr_code_path' => 'nullable|string'

// New accessors
$customer->qr_code_url        // QR code image URL
$customer->warranty_url       // Warranty page URL
```

### **Frontend Components**

#### 1. **WarrantyPage** (`delight_phone_shop/src/pages/WarrantyPage.jsx`)
- Mobile-responsive warranty display
- Real-time warranty status
- Product and customer information
- Contact details and support

#### 2. **API Integration**
```javascript
// Fetch warranty data
const response = await api.get(`/warranty/imei/${imei}`);
const warrantyData = response.data.data;
```

## 🔧 Installation & Setup

### **1. Install QR Code Package**
```bash
composer require endroid/qr-code
```

### **2. Run Database Migration**
```bash
php artisan migrate
```

### **3. Configure Frontend URL**
Add to `.env`:
```env
FRONTEND_URL=http://localhost:5173
```

### **4. Create Storage Directory**
```bash
php artisan storage:link
mkdir -p storage/app/public/qr-codes
```

## 📋 Usage Guide

### **1. Creating Customer Sales with QR Codes**

When creating a new customer sale:

1. **Fill Customer Information**: Name, phone model, IMEI, etc.
2. **Select Product**: Choose from available products
3. **Set Warranty Period**: Start and end dates
4. **Save Sale**: QR code is automatically generated
5. **Print Warranty Card**: Use the "Print Card" button

### **2. QR Code Generation Process**

```php
// Automatic generation during customer creation
$customer = Customer::create($validated);

// Generate QR code
$qrService = new QRCodeService();
$qrCodePath = $qrService->generateWarrantyQRWithLogo($validated['imei']);
$validated['qr_code_path'] = $qrCodePath;

$customer = Customer::create($validated);
```

### **3. Warranty Card Printing**

1. **Navigate to Customer Details**: Go to customer show page
2. **Click "Print Card"**: Opens print-ready warranty card
3. **Print or Save as PDF**: Professional warranty card format
4. **Give to Customer**: Customer can scan QR code anytime

### **4. Customer QR Code Scanning**

1. **Customer Scans QR Code**: Using any smartphone camera
2. **Opens Warranty Page**: Direct link to warranty information
3. **Views Details**: Product info, warranty status, contact details
4. **Mobile-Friendly**: Optimized for all devices

## 🔗 API Endpoints

### **Public Warranty API**

#### **Get Complete Warranty Information**
```http
GET /api/warranty/imei/{imei}
```

**Response:**
```json
{
  "success": true,
  "message": "Warranty information retrieved successfully",
  "data": {
    "customer": {
      "name": "John Doe",
      "phone_model": "iPhone 14 Pro",
      "imei": "123456789012345",
      "branch": "Main Branch",
      "phone_information": "256GB Space Black",
      "phone_photo": "http://localhost/storage/phone_photos/..."
    },
    "product": {
      "name": "iPhone 14 Pro",
      "description": "Latest iPhone with Pro features",
      "category": "Smartphones",
      "image": "http://localhost/storage/products/..."
    },
    "sale": {
      "price": 999.00,
      "date": "Jan 15, 2024",
      "status": "sold",
      "recorded_by": "Admin User"
    },
    "warranty": {
      "start_date": "Jan 15, 2024",
      "end_date": "Jan 15, 2025",
      "is_valid": true,
      "days_remaining": 45,
      "status": "Valid"
    },
    "contact": {
      "shop_name": "PhoneShop",
      "support_email": "support@phoneshop.com",
      "support_phone": "+1-234-567-8900"
    }
  }
}
```

#### **Get Warranty Status Only**
```http
GET /api/warranty/status/{imei}
```

**Response:**
```json
{
  "success": true,
  "message": "Warranty status retrieved successfully",
  "data": {
    "imei": "123456789012345",
    "customer_name": "John Doe",
    "product_name": "iPhone 14 Pro",
    "warranty_valid": true,
    "warranty_end_date": "Jan 15, 2025",
    "days_remaining": 45,
    "status": "Valid"
  }
}
```

## 🎨 UI Components

### **1. Admin Dashboard Integration**

#### **Customer Show Page**
- **QR Code Display**: Shows generated QR code
- **Regenerate Button**: Regenerate QR code if needed
- **Print Card Button**: Open print-ready warranty card
- **Warranty URL**: Direct link to warranty page

#### **Warranty Card Template**
- **Professional Design**: Clean, print-ready layout
- **QR Code Integration**: Large, scannable QR code
- **Customer Information**: All relevant details
- **Warranty Status**: Visual status indicators
- **Contact Information**: Support details

### **2. Customer-Facing Warranty Page**

#### **Mobile-First Design**
- **Responsive Layout**: Works on all devices
- **Touch-Friendly**: Optimized for mobile interaction
- **Fast Loading**: Quick access to warranty info
- **Professional Look**: Branded, trustworthy appearance

#### **Information Sections**
- **Warranty Status**: Clear valid/expired indicators
- **Product Details**: Complete product information
- **Customer Info**: Customer and phone details
- **Sale Information**: Purchase details and pricing
- **Contact Support**: Easy access to help

## 🔒 Security Features

### **1. Public API Security**
- **No Authentication Required**: Public warranty lookup
- **IMEI-Based Access**: Only valid IMEIs can access data
- **Error Handling**: Graceful handling of invalid requests
- **Rate Limiting**: Prevents abuse (can be added)

### **2. Admin Security**
- **Authorization Policies**: Only authorized users can manage QR codes
- **Owner Isolation**: Users can only access their own customers
- **File Security**: QR codes stored securely in storage

## 📱 Mobile Experience

### **QR Code Scanning**
1. **Universal Compatibility**: Works with any smartphone camera
2. **No App Required**: Direct browser access
3. **Instant Loading**: Fast warranty page display
4. **Offline-Friendly**: Cached data for better performance

### **Responsive Design**
- **Mobile-First**: Optimized for mobile devices
- **Touch-Friendly**: Large buttons and touch targets
- **Fast Loading**: Optimized images and code
- **Cross-Browser**: Works on all modern browsers

## 🚀 Advanced Features

### **1. QR Code Customization**
```php
// Generate with custom size and logo
$qrCode = QrCode::create($url)
    ->setSize(300)
    ->setMargin(10)
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh());
```

### **2. Warranty Card Templates**
- **Customizable Design**: Easy to modify templates
- **Print Optimization**: Optimized for printing
- **Brand Integration**: Company logo and branding
- **Multiple Formats**: PDF, HTML, and print versions

### **3. Analytics Integration**
- **QR Code Scans**: Track warranty page visits
- **Customer Engagement**: Monitor warranty usage
- **Popular Products**: Identify most-warranted items
- **Geographic Data**: Track warranty usage by location

## 🔧 Configuration

### **Environment Variables**
```env
# Frontend URL for QR codes
FRONTEND_URL=http://localhost:5173

# App configuration
APP_NAME="PhoneShop"
APP_URL=http://localhost

# Support contact information
SUPPORT_PHONE="+1-234-567-8900"
SUPPORT_EMAIL="support@phoneshop.com"
```

### **QR Code Settings**
```php
// In QRCodeService.php
$qrCode = QrCode::create($url)
    ->setSize(300)                    // QR code size
    ->setMargin(10)                   // Border margin
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh()); // Error correction
```

## 📊 Benefits

### **For Business**
- **Professional Image**: Modern, tech-savvy warranty system
- **Reduced Support Calls**: Customers can self-serve warranty info
- **Better Customer Experience**: Instant access to warranty details
- **Cost Savings**: Reduced paper and manual processes
- **Data Analytics**: Track warranty usage and customer behavior

### **For Customers**
- **Convenience**: Scan QR code anytime, anywhere
- **Instant Access**: No need to keep physical warranty cards
- **Mobile-Friendly**: Works on any smartphone
- **Complete Information**: All warranty details in one place
- **Contact Support**: Easy access to help when needed

## 🎯 Use Cases

### **1. Phone Shop Sales**
- **Point of Sale**: Generate QR code during sale
- **Warranty Card**: Print professional warranty card
- **Customer Handoff**: Give QR code to customer
- **Support**: Customer can scan for warranty info

### **2. Warranty Claims**
- **Quick Verification**: Staff can scan QR code to verify warranty
- **Status Check**: Instant warranty validity check
- **Customer Service**: Faster support with all info available
- **Record Keeping**: Digital warranty records

### **3. Marketing & Analytics**
- **Customer Engagement**: Track warranty page visits
- **Product Popularity**: See which products are most warranted
- **Geographic Data**: Understand warranty usage patterns
- **Customer Behavior**: Analyze warranty claim patterns

## 🔮 Future Enhancements

### **1. Advanced Features**
- **Push Notifications**: Notify customers of warranty expiration
- **Warranty Extensions**: Allow warranty renewal through QR code
- **Service History**: Track repair and service history
- **Digital Receipts**: Store purchase receipts digitally

### **2. Integration Options**
- **CRM Integration**: Connect with customer management systems
- **Inventory Management**: Link with stock management
- **Accounting Systems**: Integrate with financial software
- **Marketing Tools**: Connect with email marketing platforms

### **3. Mobile App**
- **Native App**: Dedicated mobile application
- **Offline Access**: Cache warranty information
- **Push Notifications**: Real-time warranty updates
- **Barcode Scanning**: Enhanced scanning capabilities

## 📞 Support

For technical support or questions about the QR Code Warranty System:

- **Email**: support@phoneshop.com
- **Phone**: +1-234-567-8900
- **Documentation**: This README file
- **API Documentation**: Available at `/api/warranty/imei/{imei}`

---

**The QR Code Warranty System provides a modern, efficient, and customer-friendly way to manage warranty information, enhancing both business operations and customer experience.**
