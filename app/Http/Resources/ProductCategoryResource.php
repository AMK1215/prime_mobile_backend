<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'parent' => $this->whenLoaded('parent', function () {
                return new ProductCategoryResource($this->parent);
            }),
            'children' => $this->whenLoaded('children', function () {
                return ProductCategoryResource::collection($this->children);
            }),
            'full_path' => $this->getFullPath(),
            'has_children' => $this->hasChildren(),
            'products_count' => $this->whenLoaded('products', function () {
                return $this->products->count();
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
