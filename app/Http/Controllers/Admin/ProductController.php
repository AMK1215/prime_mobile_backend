<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStatus;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::with(['productCategory', 'productStatus'])
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        $categories = ProductCategory::orderBy('name')->get();
        $statuses = ProductStatus::orderBy('name')->get();

        // Statistics
        $totalProducts = Product::count();
        $availableProducts = Product::whereHas('productStatus', function($query) {
            $query->where('name', 'Available');
        })->where('quantity', '>', 0)->count();
        $lowStockProducts = Product::where('quantity', '>', 0)->where('quantity', '<=', 5)->count();
        $outOfStockProducts = Product::where('quantity', 0)->count();

        return view('admin.products.index', compact(
            'products', 'categories', 'statuses', 
            'totalProducts', 'availableProducts', 'lowStockProducts', 'outOfStockProducts'
        ));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        $statuses = ProductStatus::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'statuses'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'ram' => 'nullable|string|max:50',
                'storage' => 'nullable|string|max:50',
                'screen_size' => 'nullable|string|max:50',
                'color' => 'nullable|string|max:50',
                'battery_capacity' => 'nullable|string|max:50',
                'battery_watt' => 'nullable|string|max:50',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'product_category_id' => 'required|exists:product_categories,id',
                'product_status_id' => 'required|exists:product_statuses,id',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
                'images' => 'nullable|array|max:10',
            ]);

            $data = $request->all();

            // Remove images from data array as we'll handle them separately
            unset($data['images']);

            $product = Product::create($data);

            // Handle multiple image uploads
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                $sortOrder = 0;
                
                foreach ($images as $index => $image) {
                    $imageName = time() . '_' . $index . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('products', $imageName, 'public');
                    
                    // Set first image as primary
                    $isPrimary = $index === 0;
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'alt_text' => $request->name . ' - Image ' . ($index + 1),
                        'sort_order' => $sortOrder++,
                        'is_primary' => $isPrimary,
                    ]);
                
                \Log::info('Product image uploaded successfully', [
                        'product_id' => $product->id,
                    'image_path' => $imagePath,
                        'image_name' => $imageName,
                        'is_primary' => $isPrimary
                ]);
                }
            }

            \Log::info('Product created successfully', [
                'product_id' => $product->id,
                'product_data' => $data
            ]);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully!');
                
        } catch (\Exception $e) {
            \Log::error('Product creation failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['productCategory', 'productStatus', 'customers']);
        
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::orderBy('name')->get();
        $statuses = ProductStatus::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'statuses'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'ram' => 'nullable|string|max:50',
                'storage' => 'nullable|string|max:50',
                'screen_size' => 'nullable|string|max:50',
                'color' => 'nullable|string|max:50',
                'battery_capacity' => 'nullable|string|max:50',
                'battery_watt' => 'nullable|string|max:50',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'product_category_id' => 'required|exists:product_categories,id',
                'product_status_id' => 'required|exists:product_statuses,id',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
                'images' => 'nullable|array|max:10',
                'remove_images' => 'nullable|array',
                'remove_images.*' => 'integer|exists:product_images,id',
            ]);

            $data = $request->all();

            // Remove images from data array as we'll handle them separately
            unset($data['images'], $data['remove_images']);

            // Handle removal of existing images
            if ($request->has('remove_images')) {
                foreach ($request->remove_images as $imageId) {
                    $productImage = ProductImage::find($imageId);
                    if ($productImage && $productImage->product_id === $product->id) {
                        // Delete file from storage
                        if (Storage::disk('public')->exists($productImage->image_path)) {
                            Storage::disk('public')->delete($productImage->image_path);
                        }
                        $productImage->delete();
                        
                        \Log::info('Product image removed', [
                            'product_id' => $product->id,
                            'image_id' => $imageId,
                            'image_path' => $productImage->image_path
                        ]);
                    }
                }
            }

            // Handle new image uploads
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                $existingImagesCount = $product->images()->count();
                $sortOrder = $existingImagesCount;
                
                foreach ($images as $index => $image) {
                    $imageName = time() . '_' . $index . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('products', $imageName, 'public');
                    
                    // Set as primary if this is the first image and no primary exists
                    $isPrimary = $existingImagesCount === 0 && $index === 0;
                    
                    ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                        'alt_text' => $request->name . ' - Image ' . ($existingImagesCount + $index + 1),
                        'sort_order' => $sortOrder++,
                        'is_primary' => $isPrimary,
                    ]);
                    
                    \Log::info('Product image uploaded successfully', [
                    'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'image_name' => $imageName,
                        'is_primary' => $isPrimary
                ]);
                }
            }

            $product->update($data);

            \Log::info('Product updated successfully', [
                'product_id' => $product->id,
                'updated_data' => $data
            ]);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully!');
                
        } catch (\Exception $e) {
            \Log::error('Product update failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        // Check if product has sales
        if ($product->customers()->count() > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Cannot delete product with existing sales records. Please contact administrator.');
        }

        // Delete all product images
        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        // Delete old single image if exists (for backward compatibility)
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Update product stock.
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $product->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->back()
            ->with('success', 'Product stock updated successfully!');
    }

    /**
     * Get all images for a product.
     */
    public function getImages(Product $product)
    {
        $images = $product->images()->ordered()->get()->map(function($image) {
            return [
                'id' => $image->id,
                'image_url' => $image->image_url,
                'is_primary' => $image->is_primary,
                'sort_order' => $image->sort_order,
                'alt_text' => $image->alt_text,
            ];
        });

        return response()->json(['images' => $images]);
    }

    /**
     * Set primary image for a product.
     */
    public function setPrimaryImage(Request $request, Product $product, ProductImage $image)
    {
        // Ensure the image belongs to this product
        if ($image->product_id !== $product->id) {
            return response()->json(['error' => 'Image does not belong to this product'], 403);
        }

        // Remove primary status from all other images
        $product->images()->update(['is_primary' => false]);

        // Set this image as primary
        $image->update(['is_primary' => true]);

        return response()->json(['success' => 'Primary image updated successfully']);
    }

    /**
     * Delete a specific product image.
     */
    public function deleteImage(Request $request, Product $product, ProductImage $image)
    {
        // Ensure the image belongs to this product
        if ($image->product_id !== $product->id) {
            return response()->json(['error' => 'Image does not belong to this product'], 403);
        }

        // Delete file from storage
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        // If this was the primary image, set another image as primary
        if ($image->is_primary) {
            $newPrimary = $product->images()->first();
            if ($newPrimary) {
                $newPrimary->update(['is_primary' => true]);
            }
        }

        return response()->json(['success' => 'Image deleted successfully']);
    }

    /**
     * Reorder product images.
     */
    public function reorderImages(Request $request, Product $product)
    {
        $request->validate([
            'image_order' => 'required|array',
            'image_order.*' => 'integer|exists:product_images,id',
        ]);

        foreach ($request->image_order as $index => $imageId) {
            ProductImage::where('id', $imageId)
                ->where('product_id', $product->id)
                ->update(['sort_order' => $index]);
        }

        return response()->json(['success' => 'Image order updated successfully']);
    }
}
