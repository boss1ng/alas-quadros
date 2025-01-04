<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
        return view('order', compact('menus'));
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
        // Validate the incoming request
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'orders' => 'required|array',
            'total_price' => 'required|numeric',  // Ensure total_price is numeric
            'orders.*.quantity' => 'required|numeric|min:1',
        ]);

        // Extract order details
        $orders = [];
        foreach ($request->input('orders') as $menuId => $orderDetails) {
            if (isset($orderDetails['selected']) && $orderDetails['selected'] == 1) {
                $orders[] = [
                    'menu_id' => $menuId,
                    'quantity' => $orderDetails['quantity'],
                ];
            }
        }

        // Create the order
        $order = Order::create([
            'customer_name' => $request->input('customer_name'),
            'orders' => json_encode($orders), // Ensure the orders are stored as JSON
            'total_price' => $request->input('total_price'), // Store total price as numeric
        ]);

        // Redirect back with success message
        return redirect()->route('order')->with('success', 'Order placed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
