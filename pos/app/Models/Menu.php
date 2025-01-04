<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    // Define the table name (if not using Laravel's default plural table naming convention)
    protected $table = 'menus';

    // Define fillable fields to allow mass assignment
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];

    // You can optionally define the cast for price if it's stored as a string
    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Optional: Define an accessor for the image to get the full URL if using storage
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/menu-images/' . $this->image) : null;
    }
}
