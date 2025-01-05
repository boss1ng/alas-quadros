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
    public function index()
    {
        // Today's Orders
        $todaysOrders = Order::whereDate('created_at', Carbon::today())->count();

        // Today's Sales (sum of total_price for today's orders)
        $todaysSales = Order::whereDate('created_at', Carbon::today())->sum('total_price');

        // Registered Users count
        $registeredUsers = User::count();

        // Sales Report for the last 7 days (or any time period you want)
        $salesData = Order::where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total_price) as total_sales'))
            ->pluck('total_sales', 'date');

        // By Product Sales - Example by menu items (adjust this to suit your needs)
        $productSales = Order::with('menu')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->get()
            ->groupBy('menu_id')
            ->map(fn($orders) => $orders->sum('total_price'))
            ->sortDesc();

        return view('dashboard', compact('todaysOrders', 'todaysSales', 'registeredUsers', 'salesData', 'productSales'));
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
