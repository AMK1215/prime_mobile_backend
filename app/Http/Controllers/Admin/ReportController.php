<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\CustomerVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display the main reports dashboard
     */
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();

        // Overall Statistics
        $stats = [
            'total_sales' => Customer::sum('sale_price'),
            'total_customers' => Customer::count(),
            'total_products' => Product::count(),
            'active_warranties' => Customer::whereDate('warranty_end_date', '>=', $today)->count(),
            
            'today_sales' => Customer::whereDate('sale_date', $today)->sum('sale_price'),
            'today_customers' => Customer::whereDate('sale_date', $today)->count(),
            
            'month_sales' => Customer::whereDate('sale_date', '>=', $thisMonth)->sum('sale_price'),
            'month_customers' => Customer::whereDate('sale_date', '>=', $thisMonth)->count(),
            
            'year_sales' => Customer::whereDate('sale_date', '>=', $thisYear)->sum('sale_price'),
            'year_customers' => Customer::whereDate('sale_date', '>=', $thisYear)->count(),
        ];

        // Top selling products
        $topProducts = Product::withCount('customers')
            ->orderBy('customers_count', 'desc')
            ->limit(10)
            ->get();

        // Recent sales
        $recentSales = Customer::with(['product', 'productCategory', 'owner'])
            ->orderBy('sale_date', 'desc')
            ->limit(10)
            ->get();

        // Monthly sales chart data (last 12 months)
        $monthlySales = Customer::where('sale_date', '>=', Carbon::now()->subMonths(12))
            ->get()
            ->groupBy(function($customer) {
                return $customer->sale_date->format('Y-m');
            })
            ->map(function($group) {
                return [
                    'month' => $group->first()->sale_date->format('Y-m'),
                    'count' => $group->count(),
                    'revenue' => $group->sum('sale_price')
                ];
            })
            ->sortBy('month')
            ->values();

        return view('admin.reports.index', compact(
            'stats',
            'topProducts',
            'recentSales',
            'monthlySales'
        ));
    }

    /**
     * Sales report with date filtering
     */
    public function sales(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $sales = Customer::with(['product', 'productCategory', 'owner'])
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->orderBy('sale_date', 'desc')
            ->get();

        $totalRevenue = $sales->sum('sale_price');
        $totalSales = $sales->count();
        $averageSale = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        $salesByStatus = $sales->groupBy('sale_status')->map(function ($group) {
            return ['count' => $group->count(), 'revenue' => $group->sum('sale_price')];
        });

        $salesByBranch = $sales->groupBy('branch')->map(function ($group) {
            return ['count' => $group->count(), 'revenue' => $group->sum('sale_price')];
        });

        return view('admin.reports.sales', compact(
            'sales', 'totalRevenue', 'totalSales', 'averageSale',
            'salesByStatus', 'salesByBranch', 'startDate', 'endDate'
        ));
    }

    /**
     * Export sales to CSV
     */
    public function exportSales(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $sales = Customer::with(['product', 'productCategory', 'owner'])
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->orderBy('sale_date', 'desc')
            ->get();

        $filename = 'sales_report_' . date('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"$filename\""];

        $callback = function() use ($sales) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Customer ID', 'Name', 'Phone Model', 'Product', 'Category', 'Price', 'Date', 'Status', 'Branch', 'IMEI', 'Sold By']);
            foreach ($sales as $sale) {
                fputcsv($file, [
                    $sale->customer_id, $sale->customer_name, $sale->phone_model, $sale->product->name,
                    $sale->productCategory->name, $sale->sale_price, $sale->sale_date->format('Y-m-d'),
                    $sale->sale_status, $sale->branch, $sale->imei, $sale->owner->name
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
