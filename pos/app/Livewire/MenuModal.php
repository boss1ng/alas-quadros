<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class MenuModal extends Component
{
    use WithFileUploads;
    public $name;
    public $description;
    public $price;
    public $image;

    public $isOpen = false;

    public function openModal()
    {
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
    }

    public function saveMenu()
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
            // $imagePath = $this->image->store('images', 'public');
            $imagePath = $this->image->storeAs('menu-images', $this->image->getClientOriginalName(), 'public');
        }

        // Example: Save the menu data to the database
        // Menu::create([
        //     'name' => $this->name,
        //     'description' => $this->description,
        //     'price' => $this->price,
        //     'image' => $imagePath ?? null,
        // ]);

        // Reset the form after saving
        $this->resetFields();
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.menu-modal');
    }
}
