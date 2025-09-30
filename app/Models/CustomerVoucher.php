<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerVoucher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'voucher_code',
        'voucher_type',
        'discount_amount',
        'discount_percentage',
        'valid_from',
        'valid_until',
        'is_used',
        'used_at',
        'terms_conditions',
        'qr_code_path',
        'metadata',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'used_at' => 'datetime',
        'is_used' => 'boolean',
        'discount_amount' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'metadata' => 'array',
    ];

    /**
     * Get the customer that owns the voucher.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Check if voucher is valid (not expired and not used).
     */
    public function isValid(): bool
    {
        return !$this->is_used && 
               $this->valid_from <= now() && 
               $this->valid_until >= now();
    }

    /**
     * Check if voucher is expired.
     */
    public function isExpired(): bool
    {
        return $this->valid_until < now();
    }

    /**
     * Mark voucher as used.
     */
    public function markAsUsed(): void
    {
        $this->update([
            'is_used' => true,
            'used_at' => now(),
        ]);
    }

    /**
     * Get formatted discount value.
     */
    public function getFormattedDiscountAttribute(): string
    {
        if ($this->discount_percentage) {
            return $this->discount_percentage . '%';
        }
        
        if ($this->discount_amount) {
            return '$' . number_format($this->discount_amount, 2);
        }
        
        return 'N/A';
    }

    /**
     * Get voucher status.
     */
    public function getStatusAttribute(): string
    {
        if ($this->is_used) {
            return 'Used';
        }
        
        if ($this->isExpired()) {
            return 'Expired';
        }
        
        if ($this->valid_from > now()) {
            return 'Not Yet Valid';
        }
        
        return 'Valid';
    }

    /**
     * Get QR code URL for voucher
     */
    public function getQRCodeUrlAttribute(): string
    {
        if ($this->qr_code_path) {
            return asset('storage/' . $this->qr_code_path);
        }
        
        return '';
    }

    /**
     * Get voucher URL for customer access
     */
    public function getVoucherUrlAttribute(): string
    {
        return config('app.frontend_url', 'http://localhost:5173') . '/voucher/' . $this->voucher_code;
    }

    /**
     * Scope to get only valid vouchers.
     */
    public function scopeValid($query)
    {
        return $query->where('is_used', false)
                    ->where('valid_from', '<=', now())
                    ->where('valid_until', '>=', now());
    }

    /**
     * Scope to get only unused vouchers.
     */
    public function scopeUnused($query)
    {
        return $query->where('is_used', false);
    }

    /**
     * Scope to get only expired vouchers.
     */
    public function scopeExpired($query)
    {
        return $query->where('valid_until', '<', now());
    }
}