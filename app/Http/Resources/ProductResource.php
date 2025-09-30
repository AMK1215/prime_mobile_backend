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
