<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerVoucher;
use App\Services\VoucherService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    use HttpResponses;

    protected $voucherService;

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    /**
     * Get voucher by code (public endpoint)
     */
    public function getVoucherByCode($voucherCode)
    {
        try {
            $voucher = CustomerVoucher::with(['customer.product', 'customer.productCategory'])
                ->where('voucher_code', $voucherCode)
                ->first();

            if (!$voucher) {
                return $this->error(
                    null,
                    'Voucher not found',
                    404
                );
            }

            $voucherData = [
                'voucher' => [
                    'code' => $voucher->voucher_code,
                    'type' => $voucher->voucher_type,
                    'discount' => $voucher->formatted_discount,
                    'discount_amount' => $voucher->discount_amount,
                    'discount_percentage' => $voucher->discount_percentage,
                    'valid_from' => $voucher->valid_from->format('M d, Y'),
                    'valid_until' => $voucher->valid_until->format('M d, Y'),
                    'is_valid' => $voucher->isValid(),
                    'status' => $voucher->status,
                    'terms_conditions' => $voucher->terms_conditions,
                    'qr_code_url' => $voucher->qr_code_url,
                    'voucher_url' => $voucher->voucher_url,
                ],
                'customer' => [
                    'id' => $voucher->customer->customer_id,
                    'name' => $voucher->customer->customer_name,
                    'phone_model' => $voucher->customer->phone_model,
                    'branch' => $voucher->customer->branch,
                ],
                'product' => [
                    'name' => $voucher->customer->product->name,
                    'description' => $voucher->customer->product->description,
                    'category' => $voucher->customer->productCategory->name,
                    'image' => $voucher->customer->product->image ? asset('storage/' . $voucher->customer->product->image) : null,
                ],
                'sale' => [
                    'price' => $voucher->customer->sale_price,
                    'date' => $voucher->customer->sale_date->format('M d, Y'),
                    'status' => $voucher->customer->sale_status,
                ]
            ];

            return $this->success(
                $voucherData,
                'Voucher retrieved successfully'
            );

        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve voucher',
                500
            );
        }
    }

    /**
     * Get customer vouchers (authenticated)
     */
    public function getCustomerVouchers(Request $request, $customerId)
    {
        try {
            $customer = Customer::where('customer_id', $customerId)->first();

            if (!$customer) {
                return $this->error(
                    null,
                    'Customer not found',
                    404
                );
            }

            $vouchers = $customer->vouchers()
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($voucher) {
                    return [
                        'id' => $voucher->id,
                        'code' => $voucher->voucher_code,
                        'type' => $voucher->voucher_type,
                        'discount' => $voucher->formatted_discount,
                        'valid_from' => $voucher->valid_from->format('M d, Y'),
                        'valid_until' => $voucher->valid_until->format('M d, Y'),
                        'is_valid' => $voucher->isValid(),
                        'status' => $voucher->status,
                        'used_at' => $voucher->used_at ? $voucher->used_at->format('M d, Y H:i') : null,
                        'qr_code_url' => $voucher->qr_code_url,
                        'terms_conditions' => $voucher->terms_conditions,
                    ];
                });

            $stats = $this->voucherService->getCustomerVoucherStats($customer);

            return $this->success([
                'vouchers' => $vouchers,
                'stats' => $stats,
            ], 'Customer vouchers retrieved successfully');

        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve customer vouchers',
                500
            );
        }
    }

    /**
     * Use a voucher (authenticated)
     */
    public function useVoucher(Request $request)
    {
        try {
            $request->validate([
                'voucher_code' => 'required|string',
                'customer_id' => 'nullable|string',
            ]);

            $customer = null;
            if ($request->customer_id) {
                $customer = Customer::where('customer_id', $request->customer_id)->first();
            }

            $result = $this->voucherService->useVoucher($request->voucher_code, $customer);

            if (!$result['success']) {
                return $this->error(
                    null,
                    $result['message'],
                    400
                );
            }

            return $this->success([
                'voucher_code' => $request->voucher_code,
                'discount' => $result['discount'],
                'used_at' => now()->format('M d, Y H:i'),
            ], $result['message']);

        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to use voucher',
                500
            );
        }
    }

    /**
     * Validate voucher (public endpoint)
     */
    public function validateVoucher($voucherCode)
    {
        try {
            $voucher = CustomerVoucher::where('voucher_code', $voucherCode)->first();

            if (!$voucher) {
                return $this->error(
                    null,
                    'Voucher not found',
                    404
                );
            }

            $isValid = $voucher->isValid();

            return $this->success([
                'voucher_code' => $voucher->voucher_code,
                'is_valid' => $isValid,
                'status' => $voucher->status,
                'valid_until' => $voucher->valid_until->format('M d, Y'),
                'discount' => $voucher->formatted_discount,
                'message' => $isValid ? 'Voucher is valid' : 'Voucher is not valid or has expired',
            ], 'Voucher validation completed');

        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to validate voucher',
                500
            );
        }
    }

    /**
     * Get voucher statistics for customer
     */
    public function getVoucherStats($customerId)
    {
        try {
            $customer = Customer::where('customer_id', $customerId)->first();

            if (!$customer) {
                return $this->error(
                    null,
                    'Customer not found',
                    404
                );
            }

            $stats = $this->voucherService->getCustomerVoucherStats($customer);

            return $this->success(
                $stats,
                'Voucher statistics retrieved successfully'
            );

        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve voucher statistics',
                500
            );
        }
    }
}