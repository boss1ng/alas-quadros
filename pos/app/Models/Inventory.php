<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
    use HasFactory;

    // Define fillable fields to allow mass assignment
    protected $fillable = [
        'itemName',
        'quantity',
        'unitOfMeasurement',
        'quantityPerPackage',
    ];
}
