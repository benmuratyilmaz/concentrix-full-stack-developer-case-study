<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'is_active',
        'name',
        'description',
        'barcode',
        'warranty_period',
        'list_price',
        'sale_price',
        'quantity',
        'on_sale'
    ];
}
