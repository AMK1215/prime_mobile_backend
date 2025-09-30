<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerVoucher;
use Illuminate\Support\Str;

class VoucherService
{
    /**
     * Generate a unique voucher code
     */
    public function generateVoucherCode(): string
    {
        do {
            $code = 'VCH-' . strtoupper(Str::random(8));
        } while (CustomerVoucher::where('voucher_code', $code)->exists());

        return $code;
    }

    /**
     * Create a purchase voucher for customer
     */
    public function createPurchaseVoucher(Customer $customer, array $options = []): CustomerVoucher
    {
        $defaultOptions = [
            'voucher_type' => 'purchase',
            'discount_percentage' => 10, // 10% discount for next purchase
            'valid_from' => now(),
            'valid_until' => now()->addMonths(6), // Valid for 6 months
            'terms_conditions' => 'Valid for one-time use. Cannot be combined with other offers. Subject to terms and conditions.',
        ];

        $options = array_merge($defaultOptions, $options);

        // Include comprehensive customer information in metadata
        $customerMetadata = [
            'customer_name' => $customer->customer_name,
            'customer_id' => $customer->customer_id,
            'phone_model' => $customer->phone_model,
            'imei' => $customer->imei,
            'branch' => $customer->branch,
            'sale_price' => $customer->sale_price,
            'sale_date' => $customer->sale_date->format('Y-m-d'),
            'product_name' => $customer->product->name ?? 'N/A',
            'product_category' => $customer->productCategory->name ?? 'N/A',
            'warranty_start_date' => $customer->warranty_start_date->format('Y-m-d'),
            'warranty_end_date' => $customer->warranty_end_date->format('Y-m-d'),
            'created_at' => now()->format('Y-m-d H:i:s'),
        ];

        // Merge with any existing metadata
        $finalMetadata = array_merge($customerMetadata, $options['metadata'] ?? []);

        $voucher = CustomerVoucher::create([
            'customer_id' => $customer->id,
            'voucher_code' => $this->generateVoucherCode(),
            'voucher_type' => $options['voucher_type'],
            'discount_amount' => $options['discount_amount'] ?? null,
            'discount_percentage' => $options['discount_percentage'] ?? null,
            'valid_from' => $options['valid_from'],
            'valid_until' => $options['valid_until'],
            'terms_conditions' => $options['terms_conditions'],
            'metadata' => $finalMetadata,
        ]);

        // Generate QR code for voucher
        $qrService = new QRCodeService();
        $qrCodePath = $qrService->generateVoucherQR($voucher->voucher_code);
        $voucher->update(['qr_code_path' => $qrCodePath]);

        return $voucher;
    }

    /**
     * Create a warranty extension voucher
     */
    public function createWarrantyExtensionVoucher(Customer $customer, int $extensionMonths = 3): CustomerVoucher
    {
        return $this->createPurchaseVoucher($customer, [
            'voucher_type' => 'warranty_extension',
            'discount_percentage' => null,
            'discount_amount' => null,
            'valid_from' => $customer->warranty_end_date,
            'valid_until' => $customer->warranty_end_date->addMonths($extensionMonths),
            'terms_conditions' => "Warranty extension voucher for {$extensionMonths} months. Must be used before warranty expires.",
            'metadata' => [
                'extension_months' => $extensionMonths,
                'original_warranty_end' => $customer->warranty_end_date->toDateString(),
            ],
        ]);
    }

    /**
     * Create a loyalty discount voucher
     */
    public function createLoyaltyVoucher(Customer $customer, float $discountPercentage = 15): CustomerVoucher
    {
        return $this->createPurchaseVoucher($customer, [
            'voucher_type' => 'loyalty',
            'discount_percentage' => $discountPercentage,
            'valid_from' => now(),
            'valid_until' => now()->addYear(), // Valid for 1 year
            'terms_conditions' => "Loyalty discount voucher. Thank you for being a valued customer!",
            'metadata' => [
                'loyalty_tier' => 'premium',
                'created_reason' => 'customer_loyalty',
            ],
        ]);
    }

    /**
     * Create multiple vouchers for a customer
     */
    public function createWelcomeVoucherPackage(Customer $customer): array
    {
        $vouchers = [];

        // Purchase discount voucher
        $vouchers[] = $this->createPurchaseVoucher($customer, [
            'discount_percentage' => 10,
            'valid_until' => now()->addMonths(3),
            'terms_conditions' => 'Welcome voucher - 10% off your next purchase. Valid for 3 months.',
        ]);

        // Warranty extension voucher
        if ($customer->warranty_end_date) {
            $vouchers[] = $this->createWarrantyExtensionVoucher($customer, 2);
        }

        return $vouchers;
    }

    /**
     * Validate and use a voucher
     */
    public function useVoucher(string $voucherCode, Customer $customer = null): array
    {
        $voucher = CustomerVoucher::where('voucher_code', $voucherCode)->first();

        if (!$voucher) {
            return [
                'success' => false,
                'message' => 'Voucher not found',
            ];
        }

        if (!$voucher->isValid()) {
            return [
                'success' => false,
                'message' => 'Voucher is not valid or has expired',
            ];
        }

        if ($customer && $voucher->customer_id !== $customer->id) {
            return [
                'success' => false,
                'message' => 'This voucher does not belong to you',
            ];
        }

        $voucher->markAsUsed();

        return [
            'success' => true,
            'message' => 'Voucher used successfully',
            'voucher' => $voucher,
            'discount' => $voucher->formatted_discount,
        ];
    }

    /**
     * Get customer's valid vouchers
     */
    public function getCustomerValidVouchers(Customer $customer): \Illuminate\Database\Eloquent\Collection
    {
        return $customer->vouchers()
            ->valid()
            ->orderBy('valid_until', 'asc')
            ->get();
    }

    /**
     * Get voucher statistics for customer
     */
    public function getCustomerVoucherStats(Customer $customer): array
    {
        $vouchers = $customer->vouchers();

        return [
            'total_vouchers' => $vouchers->count(),
            'valid_vouchers' => $vouchers->valid()->count(),
            'used_vouchers' => $vouchers->where('is_used', true)->count(),
            'expired_vouchers' => $vouchers->expired()->count(),
            'total_savings' => $vouchers->where('is_used', true)->sum('discount_amount'),
        ];
    }
}
