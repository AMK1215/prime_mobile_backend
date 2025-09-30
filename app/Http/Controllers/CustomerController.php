<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\QRCodeService;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        $customers = Customer::with(['product', 'productCategory', 'owner'])
            ->where('owner_id', Auth::id())
            ->orderBy('sale_date', 'desc')
            ->get();

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        $categories = ProductCategory::all();
        $products = Product::with('productCategory')->get();
        $clientId = $this->generateRandomString();
        return view('admin.customers.create', compact('categories', 'products', 'clientId'));
    }

    private function generateRandomString()
    {
        $randomNumber = mt_rand(10000000, 99999999);

        return 'Client-'.$randomNumber;
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone_model' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'product_category_id' => 'required|exists:product_categories,id',
            'branch' => 'required|string|max:255',
            'warranty_start_date' => 'required|date',
            'warranty_end_date' => 'required|date|after:warranty_start_date',
            'imei' => 'required|string|unique:customers,imei',
            'phone_information' => 'nullable|string',
            'phone_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sale_price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
            'sale_status' => 'required|string|in:sold,returned,warranty_claim,refunded',
            'customer_id' => 'nullable|string|unique:customers,customer_id',
        ]);

        $validated['owner_id'] = Auth::id();

        // Generate customer_id if not provided
        if (empty($validated['customer_id'])) {
            $validated['customer_id'] = 'CLIENT-' . str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        }

        if ($request->hasFile('phone_photo')) {
            $validated['phone_photo'] = $request->file('phone_photo')->store('phone_photos', 'public');
        }

        // Generate QR code for warranty
        $qrService = new QRCodeService();
        $qrCodePath = $qrService->generateWarrantyQRWithLogo($validated['customer_id']);
        $validated['qr_code_path'] = $qrCodePath;

        $customer = Customer::create($validated);

        // Update product quantity (decrease by 1)
        $product = Product::find($validated['product_id']);
        if ($product && $product->quantity > 0) {
            $product->decrement('quantity');
        }

        // Generate customer vouchers after successful sale
        try {
            $voucherService = new VoucherService();
            $vouchers = $voucherService->createWelcomeVoucherPackage($customer);

            $voucherCount = count($vouchers);
            $voucherMessage = $voucherCount > 0 
                ? " Customer vouchers generated ({$voucherCount} vouchers)." 
                : "";

            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer sale recorded successfully. QR code generated for warranty card.' . $voucherMessage);
        } catch (\Exception $e) {
            // Log the error but don't fail the customer creation
            \Log::error('Failed to create vouchers for customer: ' . $e->getMessage());
            
            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer sale recorded successfully. QR code generated for warranty card. (Voucher generation failed - please create manually)');
        }
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer)
    {
        $this->authorize('view', $customer);
        
        $customer->load(['product', 'productCategory', 'owner']);
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer)
    {
        $this->authorize('update', $customer);
        
        $categories = ProductCategory::all();
        $products = Product::with('productCategory')->get();
        return view('admin.customers.edit', compact('customer', 'categories', 'products'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone_model' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'product_category_id' => 'required|exists:product_categories,id',
            'branch' => 'required|string|max:255',
            'warranty_start_date' => 'required|date',
            'warranty_end_date' => 'required|date|after:warranty_start_date',
            'imei' => 'required|string|unique:customers,imei,' . $customer->id,
            'phone_information' => 'nullable|string',
            'phone_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sale_price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
            'sale_status' => 'required|string|in:sold,returned,warranty_claim,refunded',
            'customer_id' => 'required|string|unique:customers,customer_id,' . $customer->id,
        ]);

        if ($request->hasFile('phone_photo')) {
            $validated['phone_photo'] = $request->file('phone_photo')->store('phone_photos', 'public');
        }

        // Handle product quantity changes if product changed
        if ($customer->product_id != $validated['product_id']) {
            // Increase old product quantity
            $oldProduct = Product::find($customer->product_id);
            if ($oldProduct) {
                $oldProduct->increment('quantity');
            }
            
            // Decrease new product quantity
            $newProduct = Product::find($validated['product_id']);
            if ($newProduct && $newProduct->quantity > 0) {
                $newProduct->decrement('quantity');
            }
        }

        $customer->update($validated);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer sale updated successfully.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);
        
        // Restore product quantity when customer is deleted
        $product = Product::find($customer->product_id);
        if ($product) {
            $product->increment('quantity');
        }
        
        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer sale deleted successfully.');
    }

    /**
     * Regenerate QR code for customer warranty
     */
    public function regenerateQRCode(Customer $customer)
    {
        $this->authorize('update', $customer);
        
        $qrService = new QRCodeService();
        
        // Delete old QR code if exists
        if ($customer->qr_code_path) {
            $qrService->deleteQRCode($customer->customer_id);
        }
        
        // Generate new QR code
        $qrCodePath = $qrService->generateWarrantyQRWithLogo($customer->customer_id);
        $customer->update(['qr_code_path' => $qrCodePath]);

        return redirect()->back()
            ->with('success', 'QR code regenerated successfully.');
    }

    /**
     * Display warranty card for printing
     */
    public function warrantyCard(Customer $customer)
    {
        $this->authorize('view', $customer);
        
        return view('admin.customers.warranty-card', compact('customer'));
    }

    /**
     * Display customer vouchers
     */
    public function vouchers(Customer $customer)
    {
        $this->authorize('view', $customer);
        
        $customer->load('vouchers');
        $voucherService = new VoucherService();
        $voucherStats = $voucherService->getCustomerVoucherStats($customer);
        
        return view('admin.customers.vouchers', compact('customer', 'voucherStats'));
    }

    /**
     * Generate additional voucher for customer
     */
    public function generateVoucher(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);
        
        $request->validate([
            'voucher_type' => 'required|in:purchase,loyalty,warranty_extension',
            'discount_percentage' => 'nullable|numeric|min:1|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'valid_months' => 'nullable|integer|min:1|max:24',
        ]);

        $voucherService = new VoucherService();
        
        $options = [
            'valid_until' => now()->addMonths($request->valid_months ?? 6),
        ];

        if ($request->discount_percentage) {
            $options['discount_percentage'] = $request->discount_percentage;
        }

        if ($request->discount_amount) {
            $options['discount_amount'] = $request->discount_amount;
        }

        switch ($request->voucher_type) {
            case 'loyalty':
                $voucher = $voucherService->createLoyaltyVoucher($customer, $request->discount_percentage ?? 15);
                break;
            case 'warranty_extension':
                $voucher = $voucherService->createWarrantyExtensionVoucher($customer, $request->valid_months ?? 3);
                break;
            default:
                $voucher = $voucherService->createPurchaseVoucher($customer, $options);
        }

        return redirect()->back()
            ->with('success', 'Voucher generated successfully: ' . $voucher->voucher_code);
    }
}
