<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $fillable = [
        'name',
        'price',
        'stock',
        'description',
        'address',
        'city',
        'region',
        'postal_code',
        'date_info',
        'grade',
        'image'
    ];
}
