<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'formatted_price' => $this->getFormattedPriceAttribute(),
            'quantity' => $this->quantity,
            'is_in_stock' => $this->isInStock(),
            'is_available' => $this->isAvailable(),
            'image' => $this->image,
            'image_url' => $this->image ? url('storage/' . $this->image) : null,
            'images' => $this->whenLoaded('images', function () {
                return $this->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'image_path' => $image->image_path,
                        'image_url' => $image->image_url,
                        'alt_text' => $image->alt_text,
                        'sort_order' => $image->sort_order,
                        'is_primary' => $image->is_primary,
                    ];
                });
            }),
            'primary_image' => $this->whenLoaded('images', function () {
                $primaryImage = $this->images->where('is_primary', true)->first();
                if ($primaryImage) {
                    return [
                        'id' => $primaryImage->id,
                        'image_path' => $primaryImage->image_path,
                        'image_url' => $primaryImage->image_url,
                        'alt_text' => $primaryImage->alt_text,
                    ];
                }
                return $this->images->first() ? [
                    'id' => $this->images->first()->id,
                    'image_path' => $this->images->first()->image_path,
                    'image_url' => $this->images->first()->image_url,
                    'alt_text' => $this->images->first()->alt_text,
                ] : null;
            }),
            'product_category_id' => $this->product_category_id,
            'product_status_id' => $this->product_status_id,
            'category' => $this->whenLoaded('productCategory', function () {
                return new ProductCategoryResource($this->productCategory);
            }),
            'status' => $this->whenLoaded('productStatus', function () {
                return new ProductStatusResource($this->productStatus);
            }),
            'customers_count' => $this->whenLoaded('customers', function () {
                return $this->customers->count();
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
