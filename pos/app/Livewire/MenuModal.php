<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Menu;

class MenuModal extends Component
{
    use WithFileUploads;

    // To hold the list of menus
    public $menus;

    public $name, $description, $price, $image, $menuId;
    public $isOpen = false;

    // protected $listeners = ['menuSaved' => '$refresh', 'menuDeleted' => '$refresh'];

    // Load menu for editing
    public function openModal($menuId = null)
    {
        if ($menuId) {
            $menu = Menu::findOrFail($menuId);
            $this->menuId = $menu->id;
            $this->name = $menu->name;
            $this->description = $menu->description;
            $this->price = $menu->price;
            $this->image = null; // Keep image null for edit
        } else {
            $this->resetFields();
        }

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->image = null;
        $this->menuId = null;
    }

    public function createMenu()
    {
        // Validation logic for name, description, price, and image
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:1024', // Max 1MB image
        ]);

        // Store logic for menu item, including image upload
        if ($this->image) {
            $imagePath = $this->image->storeAs('menu-images', $this->image->getClientOriginalName(), 'public');
        }

        Menu::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $imagePath ?? null,
        ]);

        $this->resetFields();
        $this->closeModal();
    }

    /* public function createMenu()
    {
        // Validate inputs
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:1024', // Max 1MB image
        ]);

        // Store or Update logic
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image ? $this->image->storeAs('menu-images', $this->image->getClientOriginalName(), 'public') : null,
        ];

        if ($this->menuId) {
            // Update existing menu item
            $menu = Menu::findOrFail($this->menuId);
            $menu->update($data);
        } else {
            // Create new menu item
            Menu::create($data);
        }

        $this->resetFields();
        $this->closeModal();
        $this->emit('menuSaved'); // To refresh the menu list
    } */

    public function deleteMenu($id)
    {
        // Delete menu item by ID
        $menu = Menu::findOrFail($id);
        $menu->delete();
        // $this->emit('menuDeleted'); // To refresh the menu list
    }

    public function render()
    {
        // Retrieve the list of menus to pass to the view
        $this->menus = Menu::all();

        return view('livewire.menu-modal');
    }
}
