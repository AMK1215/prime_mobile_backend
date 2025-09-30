<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductStatusResource;
use App\Models\ProductStatus;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ProductStatusController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of product statuses.
     */
    public function index()
    {
        try {
            $statuses = ProductStatus::orderBy('name')->get();

            return $this->success(
                ProductStatusResource::collection($statuses),
                'Product statuses retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve product statuses',
                500
            );
        }
    }

    /**
     * Display the specified product status.
     */
    public function show($id)
    {
        try {
            $status = ProductStatus::with('products')->find($id);

            if (!$status) {
                return $this->error(
                    null,
                    'Product status not found',
                    404
                );
            }

            return $this->success(
                new ProductStatusResource($status),
                'Product status retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve product status',
                500
            );
        }
    }

    /**
     * Get available statuses (for products that are available for sale).
     */
    public function available()
    {
        try {
            $availableStatuses = ProductStatus::whereIn('name', [
                'Available', 
                'In Stock', 
                'New Arrival', 
                'Best Seller', 
                'On Sale'
            ])->orderBy('name')->get();

            return $this->success(
                ProductStatusResource::collection($availableStatuses),
                'Available product statuses retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve available product statuses',
                500
            );
        }
    }
}