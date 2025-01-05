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

        // Get the filter period (default is weekly)
        $filterPeriod = $request->input('filter', 'weekly');  // weekly is the default

        // Determine the start and end date based on the selected period
        $startDate = Carbon::now();
        $endDate = Carbon::now();

        if ($filterPeriod == 'weekly') {
            // This week (starting from the last Sunday to today)
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
        } elseif ($filterPeriod == 'monthly') {
            // This month (starting from the first of the month to today)
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($filterPeriod == 'yearly') {
            // This year (starting from January 1st to today)
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        }

        // Sales Report for the selected period (Weekly, Monthly, or Yearly)
        $salesData = Order::whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total_price) as total_sales'))
            ->pluck('total_sales', 'date');

        // By Product Sales (no change in logic)
        $productSales = Order::with('menu')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy('menu_id')
            ->map(fn($orders) => $orders->sum('total_price'))
            ->sortDesc();

        return view('dashboard', compact('todaysOrders', 'todaysSales', 'registeredUsers', 'salesData', 'productSales', 'filterPeriod'));
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
