<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $menus = Menu::all();

        // Default to 'daily' if no filter is applied
        $filter = $request->input('filter', 'daily');
        $ordersQuery = Order::query();

        // Apply filter logic to $ordersQuery based on the selected filter
        switch ($filter) {
            case 'weekly':
                // Get orders from the past week
                $ordersQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;

                /*
                TESTED: GOOD
                // Get orders from Jan 12, 2025, 00:00:00 to Jan 18, 2025, 23:59:59
                $ordersQuery->whereBetween('created_at', ['2025-01-12 00:00:00', '2025-01-18 23:59:59']);
                break;
                */

            case 'monthly':
                // Get orders from the current month
                $ordersQuery->whereMonth('created_at', now()->month);
                break;

                /*
                // Get orders from February (hardcoded month)
                $ordersQuery->whereMonth('created_at', 2); // 2 represents February
                break;
                */

            case 'yearly':
                // Get orders from the current year
                $ordersQuery->whereYear('created_at', now()->year);
                break;

                /*
                // Get orders from the year 2024 (hardcoded year)
                $ordersQuery->whereYear('created_at', 2024);
                break;
                */

            case 'daily':
            default:
                // Default filter: today
                $ordersQuery->whereDate('created_at', today());
                break;
        }

        // Calculate the total sales for the filtered orders before pagination
        $totalSales = $ordersQuery->sum('total_price'); // Sum for the filtered orders

        // Get paginated orders, ordered by the most recent first
        $orders = $ordersQuery->latest()->paginate(10);

        return view('sales.sales', compact('menus', 'orders', 'totalSales'));
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
