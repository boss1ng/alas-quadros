<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Today's Orders
        $todaysOrders = Order::whereDate('created_at', Carbon::today())->count();

        // Today's Sales (sum of total_price for today's orders)
        $todaysSales = Order::whereDate('created_at', Carbon::today())->sum('total_price');

        // Registered Users count
        $registeredUsers = User::count();

        // Get the filter periods (for Sales Report and By Product separately)
        $filterSalesReport = $request->input('filter_sales_report', 'weekly');
        $filterProductSales = $request->input('filter_product_sales', 'weekly');

        // Determine the start and end dates for the filters
        $startDateSalesReport = Carbon::now();
        $endDateSalesReport = Carbon::now();

        if ($filterSalesReport == 'weekly') {
            $startDateSalesReport = Carbon::now()->startOfWeek();
            $endDateSalesReport = Carbon::now()->endOfWeek();
        } elseif ($filterSalesReport == 'monthly') {
            $startDateSalesReport = Carbon::now()->startOfMonth();
            $endDateSalesReport = Carbon::now()->endOfMonth();
        } elseif ($filterSalesReport == 'yearly') {
            $startDateSalesReport = Carbon::now()->startOfYear();
            $endDateSalesReport = Carbon::now()->endOfYear();
        }

        // Sales Report for the selected period (Sales Report Filter)
        $salesData = Order::whereBetween('created_at', [$startDateSalesReport, $endDateSalesReport])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total_price) as total_sales'))
            ->get()
            ->pluck('total_sales', 'date');

        // Determine the start and end dates for the By Product Sales filter
        $startDateProductSales = Carbon::now();
        $endDateProductSales = Carbon::now();

        if ($filterProductSales == 'weekly') {
            $startDateProductSales = Carbon::now()->startOfWeek();
            $endDateProductSales = Carbon::now()->endOfWeek();
        } elseif ($filterProductSales == 'monthly') {
            $startDateProductSales = Carbon::now()->startOfMonth();
            $endDateProductSales = Carbon::now()->endOfMonth();
        } elseif ($filterProductSales == 'yearly') {
            $startDateProductSales = Carbon::now()->startOfYear();
            $endDateProductSales = Carbon::now()->endOfYear();
        }

        // By Product Sales for the selected period (Product Sales Filter)
        $productSales = Order::whereBetween('created_at', [$startDateProductSales, $endDateProductSales])
            ->get()
            ->flatMap(function ($order) {
                $decodedOrders = json_decode($order->orders, true);
                if (!is_array($decodedOrders)) {
                    return [];
                }
                return collect($decodedOrders);
            })
            ->groupBy('menu_id')
            ->map(function ($items, $menuId) {
                return [
                    'menu_id' => $menuId,
                    'quantity' => $items->sum('quantity'),
                ];
            });

        // Fetch names for `menu_id` from the Menu model
        $menuNames = Menu::whereIn('id', $productSales->pluck('menu_id'))->pluck('name', 'id');

        $productSalesNames = $productSales->pluck('menu_id')->map(fn($id) => $menuNames[$id] ?? 'Unknown');
        $productSalesQuantities = $productSales->pluck('quantity');

        // \Log::info('Product Sales: ', $productSalesNames->toArray());
        // \Log::info('Menu Names: ', $productSalesQuantities->toArray());

        // return view('dashboard', compact('todaysOrders', 'todaysSales', 'registeredUsers', 'salesData', 'productSales', 'filterSalesReport', 'filterProductSales', 'menuNames'));
        return view('dashboard', compact(
            'todaysOrders',
            'todaysSales',
            'registeredUsers',
            'salesData',
            'filterSalesReport',
            'filterProductSales',
            'productSalesNames',
            'productSalesQuantities'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
