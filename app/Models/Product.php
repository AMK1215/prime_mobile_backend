<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_category_id',
        'name',
        'description',
        'price',
        'quantity',
        'product_status_id',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the product category.
     */
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * Get the product status.
     */
    public function productStatus()
    {
        return $this->belongsTo(ProductStatus::class);
    }

    /**
     * Check if product is in stock.
     */
    public function isInStock(): bool
    {
        return $this->quantity > 0;
    }

    /**
     * Check if product is available for sale.
     */
    public function isAvailable(): bool
    {
        return $this->isInStock() && $this->productStatus->name === 'Available';
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Get all customers who bought this product.
     */
    public function customers()
    {
        return $this->hasMany(\App\Models\Customer::class);
    }

    /**
     * Scope to get only available products.
     */
    public function scopeAvailable($query)
    {
        return $query->whereHas('productStatus', function ($q) {
            $q->where('name', 'Available');
        })->where('quantity', '>', 0);
    }
}
