<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $discounts = Discount::all();
        return view('discount.discount', compact('discounts'));
    }

    public function newDiscount()
    {
        return view('discount.discount-add');
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
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'discount' => 'required|numeric',
        ]);

        // Create the discount
        $discount = Discount::create([
            'name' => $request->input('name'),
            'discount' => $request->input('discount'),
        ]);

        // Redirect back with success message
        return redirect()->route('discount')->with('success', 'Discount created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        //
    }
}
