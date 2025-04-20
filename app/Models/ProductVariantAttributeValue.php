<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variant_id',
        'product_attribute_id',
        'product_attribute_value_id'
    ];

    /**
     * Get the product variant that owns this attribute value.
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * Get the product attribute that owns this attribute value.
     */
    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }

    /**
     * Get the product attribute value that owns this attribute value.
     */
    public function productAttributeValue()
    {
        return $this->belongsTo(ProductAttributeValue::class);
    }
}
