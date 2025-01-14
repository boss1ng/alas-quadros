<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //

    // Define fillable fields to allow mass assignment
    protected $fillable = [
        'fsCode',
        'itemName',
        'quantity',
        'unitOfMeasurement',
        'pricePerItem',
        'total'
    ];
}
