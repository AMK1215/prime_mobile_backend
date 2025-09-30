<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    use HttpResponses;

    /**
     * Get warranty information by Customer ID
     */
    public function getWarrantyByCustomerId(Request $request, $customer_id)
    {
        try {
            $customer = Customer::with(['product', 'productCategory', 'owner'])
                ->where('customer_id', $customer_id)
                ->first();

            if (!$customer) {
                return $this->error(
                    null,
                    'Warranty information not found for this Customer ID',
                    404
                );
            }

            $warrantyData = [
                'customer' => [
                    'id' => $customer->customer_id,
                    'name' => $customer->customer_name,
                    'phone_model' => $customer->phone_model,
                    'imei' => $customer->imei,
                    'branch' => $customer->branch,
                    'phone_information' => $customer->phone_information,
                    'phone_photo' => $customer->phone_photo ? asset('storage/' . $customer->phone_photo) : null,
                ],
                'product' => [
                    'name' => $customer->product->name,
                    'description' => $customer->product->description,
                    'category' => $customer->productCategory->name,
                    'image' => $customer->product->image ? asset('storage/' . $customer->product->image) : null,
                ],
                'sale' => [
                    'price' => $customer->sale_price,
                    'date' => $customer->sale_date->format('M d, Y'),
                    'status' => $customer->sale_status,
                    'recorded_by' => $customer->owner->name,
                ],
                'warranty' => [
                    'start_date' => $customer->warranty_start_date ? $customer->warranty_start_date->format('M d, Y') : 'N/A',
                    'end_date' => $customer->warranty_end_date ? $customer->warranty_end_date->format('M d, Y') : 'N/A',
                    'is_valid' => $customer->isWarrantyValid(),
                    'days_remaining' => $customer->getWarrantyDaysRemaining(),
                    'status' => $customer->isWarrantyValid() ? 'Valid' : 'Expired',
                ],
                'contact' => [
                    'shop_name' => config('app.name', 'PhoneShop'),
                    'support_email' => config('mail.from.address', 'support@phoneshop.com'),
                    'support_phone' => config('app.support_phone', '+1-234-567-8900'),
                ]
            ];

            return $this->success(
                $warrantyData,
                'Warranty information retrieved successfully'
            );

        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve warranty information',
                500
            );
        }
    }

    /**
     * Get warranty status only (lightweight endpoint)
     */
    public function getWarrantyStatus($customer_id)
    {
        try {
            $customer = Customer::where('customer_id', $customer_id)->first();

            if (!$customer) {
                return $this->error(
                    null,
                    'Warranty not found',
                    404
                );
            }

            $statusData = [
                'customer_id' => $customer->customer_id,
                'customer_name' => $customer->customer_name,
                'product_name' => $customer->product->name,
                'warranty_valid' => $customer->isWarrantyValid(),
                'warranty_end_date' => $customer->warranty_end_date->format('M d, Y'),
                'days_remaining' => $customer->getWarrantyDaysRemaining(),
                'status' => $customer->isWarrantyValid() ? 'Valid' : 'Expired',
            ];

            return $this->success(
                $statusData,
                'Warranty status retrieved successfully'
            );

        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                'Failed to retrieve warranty status',
                500
            );
        }
    }
}
