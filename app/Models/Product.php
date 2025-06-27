<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 
        'size', 
        'description', 
        'price', 
        'stock', 
        'image'
    ];

    
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
}
