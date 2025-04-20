<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_attribute_id',
        'value',
        'display_value',
        'color_code',
        'position',
        'is_active'
    ];

    protected $casts = [
        'position' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
     * Get the attribute that owns this value.
     */
    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }

    /**
     * Get the product variants that have this attribute value.
     */
    public function productVariants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_attribute_values');
    }
}
