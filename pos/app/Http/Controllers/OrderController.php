<?php

namespace App\Http\Controllers;

use App\Models\Discount;
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
        $orders = Order::whereDate('created_at', today())->latest()->paginate(10);
        return view('order.order', compact('menus', 'orders'));
    }

    public function orderForm()
    {
        $menus = Menu::all();
        $discounts = Discount::all();
        return view('order.order-add', compact('menus', 'discounts'));
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
            'order_type' => 'required|string'
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
            'notes' => $request->input('order_type'),
        ]);

        // Redirect back with success message
        return redirect()->route('order')->with('success', 'Order placed successfully!');
    }

    public function updatePayment(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Update the payment status based on the checkbox value
        $order->isPaid = $request->input('isPaid');
        $order->save();

        // return back()->with('success', 'Updated payment successfully!');
        // return view('order-add', compact('menus'));
    }

    public function updateCookingStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Update the cooking status based on the checkbox value
        $order->isCooking = $request->input('isCooking');
        $order->save();
    }

    public function updateServingStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Update the serving status based on the checkbox value
        $order->isServed = $request->input('isServed');
        $order->save();
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
    public function edit($id)
    {
        $menus = Menu::all();
        $order = Order::findOrFail($id);
        $orderItems = json_decode($order->orders, true); // Decode the JSON string into an array
        $discounts = Discount::all();

        return view('order.order-edit', compact('menus', 'order', 'orderItems', 'discounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

        $order = Order::findOrFail($id);

        // Validate the incoming request
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'orders' => 'required|array',
            'orders.*.selected' => 'nullable|boolean',
            'orders.*.quantity' => 'required_with:orders.*.selected|numeric|min:1',
            'total_price' => 'required|numeric',
            'order_type' => 'required|string'
        ]);

        // Process orders: filter selected items and prepare for JSON encoding
        $processedOrders = [];
        foreach ($validatedData['orders'] as $menuId => $orderDetails) {
            if (isset($orderDetails['selected']) && $orderDetails['selected']) {
                $processedOrders[] = [
                    'menu_id' => $menuId,
                    'quantity' => $orderDetails['quantity'],
                ];
            }
        }

        // Encode the processed orders as JSON
        $processedOrdersJson = json_encode($processedOrders);

        // Prepare data for update
        $updatedData = [
            'customer_name' => $validatedData['customer_name'],
            'orders' => $processedOrdersJson,
            'total_price' => $validatedData['total_price'],
            'notes' => $validatedData['order_type'],
        ];

        // Update the order with the new data
        $order->update($updatedData);

        // Redirect back to the Order page with a success message
        return redirect()->route('order')->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $order = Order::findOrFail($id);

        $order->delete();

        // Redirect back to the previous page
        return back()->with('success', 'Order deleted successfully!');
    }
}
