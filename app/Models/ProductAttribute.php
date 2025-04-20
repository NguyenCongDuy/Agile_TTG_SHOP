<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'type',
        'is_required',
        'is_filterable',
        'is_active',
        'position'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_filterable' => 'boolean',
        'is_active' => 'boolean',
        'position' => 'integer'
    ];

    /**
     * Get the values for this attribute.
     */
    public function values()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    /**
     * Get the products that use this attribute.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute_product');
    }
}
