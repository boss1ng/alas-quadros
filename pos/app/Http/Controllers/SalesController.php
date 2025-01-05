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

        // Default to 'today' if no filter is applied
        $filter = $request->input('filter', 'daily');
        $ordersQuery = Order::query();

        switch ($filter) {
            case 'weekly':
                // Get orders from the past week
                $ordersQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;

            case 'monthly':
                // Get orders from the current month
                $ordersQuery->whereMonth('created_at', now()->month);
                break;

            case 'yearly':
                // Get orders from the current year
                $ordersQuery->whereYear('created_at', now()->year);
                break;

            case 'daily':
            default:
                // Default filter: today
                $ordersQuery->whereDate('created_at', today());
                break;
        }

        $orders = $ordersQuery->latest()->paginate(10);

        // Calculate the total sales for the filtered orders
        $totalSales = $ordersQuery->sum('total_price');

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
