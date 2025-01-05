<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::paginate('5');
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

        // Delete the associated files
        $this->deleteImage($menu);

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

        // Initialize an array to store updated fields
        $updatedData = [];

        // Only update name if it has changed
        if ($request->name && $request->name !== $menu->name) {
            $updatedData['name'] = $request->name;
        }

        // Only update description if it has changed
        if ($request->description !== $menu->description) {
            $updatedData['description'] = $request->description;
        }

        // Only update price if it has changed
        if ($request->price !== $menu->price) {
            $updatedData['price'] = $request->price;
        }

        // Handle image upload if it has been changed
        if ($request->hasFile('image') && $request->image->getClientOriginalName() !== $menu->image) {
            // Delete the associated files
            $this->deleteImage($menu);

            $imagePath = $request->image->storeAs('menu-images', $request->image->getClientOriginalName(), 'public');
            $updatedData['image'] = $imagePath;
        }

        // Update only the changed fields
        if (!empty($updatedData)) {
            $menu->update($updatedData);
        }

        // Redirect back to the previous page
        return redirect()->route('menu-management')->with('success', 'Menu item updated successfully!');
    }

    public function deleteImage($menu)
    {
        // Check if the image path is not null and if the file exists
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            // Delete the file
            Storage::disk('public')->delete($menu->image);
        }
    }
}
