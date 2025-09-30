<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStatus;
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
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'product_category_id' => 'required|exists:product_categories,id',
                'product_status_id' => 'required|exists:product_statuses,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            ]);

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                $data['image'] = $imagePath;
                
                \Log::info('Product image uploaded successfully', [
                    'image_path' => $imagePath,
                    'image_name' => $imageName
                ]);
            }

            $product = Product::create($data);

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
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'product_category_id' => 'required|exists:product_categories,id',
                'product_status_id' => 'required|exists:product_statuses,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            ]);

            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                $data['image'] = $imagePath;
                
                \Log::info('Image uploaded successfully', [
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'image_name' => $imageName
                ]);
            } else {
                // Keep existing image if no new image uploaded
                unset($data['image']);
                \Log::info('No new image uploaded, keeping existing image', [
                    'product_id' => $product->id,
                    'existing_image' => $product->image
                ]);
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

        // Delete image if exists
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
}
