<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStatus;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        try {
            $query = Product::with(['productCategory', 'productStatus']);

            // Filter by category if provided
            if ($request->has('category_id') && $request->category_id) {
                $query->where('product_category_id', $request->category_id);
            }

            // Filter by status if provided
            if ($request->has('status_id') && $request->status_id) {
                $query->where('product_status_id', $request->status_id);
            }

            // Filter by search term if provided
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%");
                });
            }

            // Only show available products by default (unless searching)
            if ((!$request->has('show_all') || !$request->show_all) && !$request->has('search')) {
                $query->available();
            }

            // Pagination
            $perPage = $request->get('per_page', 12);
            $products = $query->orderBy('created_at', 'desc')->paginate($perPage);

            $responseData = [
                'products' => ProductResource::collection($products->items()),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem(),
                ]
            ];

            return $this->success(
                $responseData,
                'Products retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve products',
                500
            );
        }
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        try {
            $product = Product::with(['productCategory', 'productStatus'])
                ->find($id);

            if (!$product) {
                return $this->error(
                    null,
                    'Product not found',
                    404
                );
            }

            return $this->success(
                new ProductResource($product),
                'Product retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve product',
                500
            );
        }
    }

    /**
     * Get featured products (Best Seller, New Arrival, On Sale).
     */
    public function featured()
    {
        try {
            $featuredProducts = Product::with(['productCategory', 'productStatus'])
                ->whereHas('productStatus', function($query) {
                    $query->whereIn('name', ['Best Seller', 'New Arrival', 'On Sale']);
                })
                ->where('quantity', '>', 0)
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();

            return $this->success(
                ProductResource::collection($featuredProducts),
                'Featured products retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve featured products',
                500
            );
        }
    }

    /**
     * Get latest products.
     */
    public function latest()
    {
        try {
            $latestProducts = Product::with(['productCategory', 'productStatus'])
                ->available()
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();

            return $this->success(
                ProductResource::collection($latestProducts),
                'Latest products retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve latest products',
                500
            );
        }
    }

    /**
     * Get best seller products.
     */
    public function bestSellers()
    {
        try {
            $bestSellers = Product::with(['productCategory', 'productStatus'])
                ->whereHas('productStatus', function($query) {
                    $query->where('name', 'Best Seller');
                })
                ->where('quantity', '>', 0)
                ->orderBy('created_at', 'desc')
                ->limit(12)
                ->get();

            return $this->success(
                ProductResource::collection($bestSellers),
                'Best sellers retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve best sellers',
                500
            );
        }
    }

    /**
     * Get new arrival products.
     */
    public function newArrivals()
    {
        try {
            $newArrivals = Product::with(['productCategory', 'productStatus'])
                ->whereHas('productStatus', function($query) {
                    $query->where('name', 'New Arrival');
                })
                ->where('quantity', '>', 0)
                ->orderBy('created_at', 'desc')
                ->limit(12)
                ->get();

            return $this->success(
                ProductResource::collection($newArrivals),
                'New arrivals retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve new arrivals',
                500
            );
        }
    }

    /**
     * Get products by category.
     */
    public function byCategory($categoryId)
    {
        try {
            $category = ProductCategory::find($categoryId);
            
            if (!$category) {
                return $this->error(
                    null,
                    'Category not found',
                    404
                );
            }

            $products = Product::with(['productCategory', 'productStatus'])
                ->where('product_category_id', $categoryId)
                ->available()
                ->orderBy('created_at', 'desc')
                ->get();

            $responseData = [
                'category' => new ProductCategoryResource($category),
                'products' => ProductResource::collection($products)
            ];

            return $this->success(
                $responseData,
                'Products by category retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve products by category',
                500
            );
        }
    }

    /**
     * Search products.
     */
    public function search(Request $request)
    {
        try {
            $query = Product::with(['productCategory', 'productStatus']);

            if ($request->has('q') && $request->q) {
                $search = $request->q;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%");
                });
            }

            if ($request->has('category_id') && $request->category_id) {
                $query->where('product_category_id', $request->category_id);
            }

            if ($request->has('min_price') && $request->min_price) {
                $query->where('price', '>=', $request->min_price);
            }

            if ($request->has('max_price') && $request->max_price) {
                $query->where('price', '<=', $request->max_price);
            }

            $query->available();

            $perPage = $request->get('per_page', 12);
            $products = $query->orderBy('created_at', 'desc')->paginate($perPage);

            $responseData = [
                'products' => ProductResource::collection($products->items()),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem(),
                ]
            ];

            return $this->success(
                $responseData,
                'Search results retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to search products',
                500
            );
        }
    }
}