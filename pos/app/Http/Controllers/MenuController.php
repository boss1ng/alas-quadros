<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('menu-management', compact('menus'));
    }

    public function createMenu(Request $request)
    {
        // Validation logic for name, description, price, and image
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:1024', // Max 1MB image
        ]);

        // Store logic for menu item, including image upload
        if ($request->image) {
            $imagePath = $request->image->storeAs('menu-images', $request->image->getClientOriginalName(), 'public');
        }

        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath ?? null,
        ]);

        // Redirect back to the previous page
        return back()->with('success', 'Menu item created successfully!');
    }

    public function deleteMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        // Redirect back to the previous page
        return back()->with('success', 'Menu item deleted successfully!');
    }

    public function editMenu($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu-edit', compact('menu'));
    }

    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        // Validation logic for name, description, price, and image
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:1024', // Max 1MB image
        ]);

        // Store logic for menu item, including image upload
        if ($request->image) {
            $imagePath = $request->image->storeAs('menu-images', $request->image->getClientOriginalName(), 'public');
        }

        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath ?? null,
        ]);

        // Redirect back to the previous page
        return redirect()->route('menu-management')->with('success', 'Menu item updated successfully!');
    }
}
