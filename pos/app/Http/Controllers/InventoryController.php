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

        // $inventories = Inventory::all();
        // $inventories = Inventory::all()->groupBy('category')->sortKeys();

        $inventories = Inventory::all()->map(function ($inventory) {
            // If category is NULL, set a placeholder value for sorting purposes
            $inventory->category = $inventory->category ?? 'zzz';
            return $inventory;
        })->groupBy('category')->sortKeys();


        return view('inventory.inventory-management', compact('inventories'));
    }

    public function inventoryForm()
    {
        return view('inventory.inventory-form');
    }

    public function inOut(Request $request)
    {
        // Validation logic for name, description, price, and image
        $request->validate([
            'itemName' => 'required|string|max:255',
            'category' => 'nullable|string|max:50',
            'quantity' => 'required|numeric',
            'unitOfMeasurement' => 'nullable|string',
            'quantityPerPackage' => 'nullable|numeric',
        ]);

        // Check if the action is "in" or "out"
        $actionType = $request->input('actionType');

        $inventory = Inventory::where('itemName', $request->itemName)->first();

        if ($actionType === 'in') {
            if ($inventory) {
                $inventory->update([
                    'quantity' => $inventory->quantity + $request->quantity,
                    // 'quantityPerPackage' => $inventory->quantityPerPackage + ($request->quantityPerPackage ?? 0),
                ]);
            } else {
                // Check if category has a value
                $categoryRequest = $request->category ? $request->category : null;

                // Check if quantityPerPackage has a value
                $quantityPerPackageRequest = $request->quantityPerPackage ? $request->quantityPerPackage : null;

                Inventory::create([
                    'itemName' => $request->itemName,
                    'category' => $categoryRequest,
                    'quantity' => $request->quantity,
                    'unitOfMeasurement' => $request->unitOfMeasurement,
                    'quantityPerPackage' => $quantityPerPackageRequest,
                ]);
            }

            return redirect()->route('inventory-management')->with('success', 'Item IN successfully!');
        } elseif ($actionType === 'out') {
            if ($inventory) {
                $newQuantity = $inventory->quantity - $request->quantity;

                if ($newQuantity < 0) {
                    return redirect()->route('inventory-management')->with('error', 'Insufficient stock');
                }

                $inventory->update([
                    'quantity' => $newQuantity,
                    // 'quantityPerPackage' => max(0, $inventory->quantityPerPackage - ($request->quantityPerPackage ?? 0)),
                ]);
            } else {
                return redirect()->route('inventory-management')->with('error', 'Item not existing');
            }

            return redirect()->route('inventory-management')->with('success', 'Item OUT successfully!');
        }
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
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);

        $inventory->delete();

        // Redirect back to the previous page
        return back()->with('success', 'Item deleted successfully!');
    }
}
