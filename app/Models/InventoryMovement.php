<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'type', 'quantity', 'description'];
}

public function product()
{
    return $this->belongsTo(\App\Models\Product::class);
}
