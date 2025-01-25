<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Create dummy data for testing
        $dummyInventory = collect([
            [
                'itemName' => 'Mayonnaise',
                'quantity' => 5,
                'unitOfMeasurement' => 'boxes',
                'quantityPerPackage' => 6,
                'pricePerItem' => 750.00,
                'total' => 7500.00,
            ],
            [
                'itemName' => 'Buns',
                'quantity' => 20,
                'unitOfMeasurement' => 'pieces',
                'quantityPerPackage' => null,
                'pricePerItem' => 120.00,
                'total' => 1800.00,
            ],
            [
                'itemName' => 'Sibuyas',
                'quantity' => 5,
                'unitOfMeasurement' => 'kilo',
                'quantityPerPackage' => null,
                'pricePerItem' => 120.00,
                'total' => 1800.00,
            ],
        ])->map(fn($inventory) => (object) $inventory);

        $inventories = Inventory::all();
        return view('inventory.inventory-management', compact('inventories'));
    }

    public function inventoryForm()
    {
        return view('inventory.inventory-form');
    }

    public function in(Request $request)
    {
        // Validation logic for name, description, price, and image
        $request->validate([
            'itemName' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'unitOfMeasurement' => 'required|string',
            'quantityPerPackage' => 'nullable|numeric',
        ]);

        // Find the existing inventory record by itemName
        $inventory = Inventory::where('itemName', $request->itemName)->first();

        if ($inventory) {
            // If the record exists, update its quantity and quantityPerPackage
            $inventory->update([
                'quantity' => $inventory->quantity + $request->quantity,
            ]);
        } else {
            // If the record does not exist, create a new one
            Inventory::create([
                'itemName' => $request->itemName,
                'quantity' => $request->quantity,
                'unitOfMeasurement' => $request->unitOfMeasurement,
                'quantityPerPackage' => $request->quantityPerPackage,
            ]);
        }

        return redirect()->route('inventory-management')->with('success', 'Item In successfully!');
    }

    public function out()
    {


        return redirect()->route('inventory-management')->with('success', 'Item Out successfully!');
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
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
