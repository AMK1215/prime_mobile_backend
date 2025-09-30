<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of product categories.
     */
    public function index()
    {
        $categories = ProductCategory::with(['parent', 'products'])
            ->orderBy('name')
            ->get();

        // Statistics
        $totalCategories = ProductCategory::count();
        $categoriesWithProducts = ProductCategory::has('products')->count();
        $emptyCategories = ProductCategory::doesntHave('products')->count();
        $totalProducts = \App\Models\Product::count();

        return view('admin.product-categories.index', compact(
            'categories', 'totalCategories', 'categoriesWithProducts', 
            'emptyCategories', 'totalProducts'
        ));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        
        // Statistics
        $totalCategories = ProductCategory::count();
        $rootCategories = ProductCategory::whereNull('parent_id')->count();
        $subCategories = ProductCategory::whereNotNull('parent_id')->count();

        return view('admin.product-categories.create', compact(
            'categories', 'totalCategories', 'rootCategories', 'subCategories'
        ));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name',
            'parent_id' => 'nullable|exists:product_categories,id',
        ]);

        ProductCategory::create($request->all());

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified category.
     */
    public function show(ProductCategory $productCategory)
    {
        $productCategory->load(['parent', 'products.productStatus']);
        
        return view('admin.product-categories.show', compact('productCategory'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(ProductCategory $productCategory)
    {
        $categories = ProductCategory::where('id', '!=', $productCategory->id)
            ->orderBy('name')
            ->get();

        return view('admin.product-categories.edit', compact('productCategory', 'categories'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name,' . $productCategory->id,
            'parent_id' => 'nullable|exists:product_categories,id|not_in:' . $productCategory->id,
        ]);

        $productCategory->update($request->all());

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(ProductCategory $productCategory)
    {
        // Check if category has products
        if ($productCategory->products()->count() > 0) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Cannot delete category with existing products. Please move or delete products first.');
        }

        // Check if category has subcategories
        if ($productCategory->children()->count() > 0) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Cannot delete category with subcategories. Please delete subcategories first.');
        }

        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
