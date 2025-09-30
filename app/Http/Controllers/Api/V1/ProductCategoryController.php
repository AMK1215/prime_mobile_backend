<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of product categories.
     */
    public function index()
    {
        try {
            $categories = ProductCategory::with(['parent', 'children'])
                ->whereNull('parent_id') // Get only top-level categories
                ->get();

            return $this->success(
                ProductCategoryResource::collection($categories),
                'Product categories retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve product categories',
                500
            );
        }
    }

    /**
     * Display the specified product category with its children.
     */
    public function show($id)
    {
        try {
            $category = ProductCategory::with(['parent', 'children', 'products'])
                ->find($id);

            if (!$category) {
                return $this->error(
                    null,
                    'Product category not found',
                    404
                );
            }

            return $this->success(
                new ProductCategoryResource($category),
                'Product category retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve product category',
                500
            );
        }
    }

    /**
     * Get all categories (including nested) for dropdown/select purposes.
     */
    public function all()
    {
        try {
            $categories = ProductCategory::with(['parent'])
                ->orderBy('name')
                ->get();

            return $this->success(
                ProductCategoryResource::collection($categories),
                'All product categories retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve product categories',
                500
            );
        }
    }
}