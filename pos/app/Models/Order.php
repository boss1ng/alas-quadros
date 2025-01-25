<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'orders',
        'total_price',
        'discount',
        'isPaidCash',
        'isPaidGCash',
        'isCooking',
        'isServed',
        'notes'
    ];

    protected $casts = [
        'orders' => 'array', // Automatically cast JSON to array
    ];

    // Define the relationship with the Menu model
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
