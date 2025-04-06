<?php

namespace App\Models;

use Carbon\Traits\Modifiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory , Modifiers;
    protected $fillable = [
        'name_products','price','quantity'
    ];
    protected $table = 'products';
}
