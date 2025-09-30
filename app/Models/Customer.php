<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_name',
        'phone_model',
        'product_id', // Reference to the actual product sold
        'product_category_id',
        'branch',
        'warranty_start_date',
        'warranty_end_date',
        'imei',
        'phone_information',
        'phone_photo',
        'sale_price', // Price at which it was sold to customer
        'sale_date', // Date when sold to customer
        'sale_status', // sold, returned, warranty_claim, etc.
        'owner_id',
        'qr_code_path', // Path to generated QR code
        'customer_id', // Unique customer ID
    ];

    protected $casts = [
        'warranty_start_date' => 'date',
        'warranty_end_date' => 'date',
        'sale_date' => 'date',
        'sale_price' => 'decimal:2',
    ];

    /**
     * Get the owner (user) that owns the customer record.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the product that was sold to this customer.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product category for this customer's phone.
     */
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * Get the vouchers for this customer.
     */
    public function vouchers()
    {
        return $this->hasMany(CustomerVoucher::class);
    }

    /**
     * Check if warranty is still valid.
     */
    public function isWarrantyValid(): bool
    {
        if (!$this->warranty_end_date) {
            return false;
        }
        return $this->warranty_end_date >= now();
    }

    /**
     * Get warranty days remaining.
     */
    public function getWarrantyDaysRemaining(): int
    {
        if (!$this->warranty_end_date || !$this->isWarrantyValid()) {
            return 0;
        }

        return now()->diffInDays($this->warranty_end_date);
    }

    /**
     * Check if sale was recent (within last 30 days).
     */
    public function isRecentSale(): bool
    {
        return $this->sale_date && $this->sale_date->diffInDays(now()) <= 30;
    }

    /**
     * Get formatted sale price.
     */
    public function getFormattedSalePriceAttribute(): string
    {
        return '$' . number_format($this->sale_price, 2);
    }

    /**
     * Get QR code URL for warranty
     */
    public function getQRCodeUrlAttribute(): string
    {
        if ($this->qr_code_path) {
            return asset('storage/' . $this->qr_code_path);
        }
        
        // Generate QR code if not exists
        $qrService = new \App\Services\QRCodeService();
        $qrCodePath = $qrService->generateWarrantyQRWithLogo($this->customer_id);
        $this->update(['qr_code_path' => $qrCodePath]);
        
        return asset('storage/' . $qrCodePath);
    }

    /**
     * Get warranty URL
     */
    public function getWarrantyUrlAttribute(): string
    {
        return config('app.frontend_url', 'http://localhost:5173') . '/customer/' . $this->customer_id;
    }
}
