<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'sale_price',
        'stock',
        'image',
        'is_default',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock' => 'integer',
        'is_default' => 'boolean',
        'is_active' => 'boolean'
    ];

    /**
     * Get the product that owns this variant.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the attribute values for this variant.
     */
    public function attributeValues()
    {
        return $this->belongsToMany(ProductAttributeValue::class, 'product_variant_attribute_values')
                    ->withPivot('product_attribute_id');
    }

    /**
     * Get the attributes for this variant.
     */
    public function attributes()
    {
        return $this->belongsToMany(ProductAttribute::class, 'product_variant_attribute_values');
    }

    /**
     * Get the current price (sale price if available, otherwise regular price).
     */
    public function getCurrentPriceAttribute()
    {
        if ($this->sale_price && $this->sale_price > 0) {
            return $this->sale_price;
        }

        return $this->price ?: $this->product->price;
    }

    /**
     * Check if the variant is in stock.
     */
    public function getIsInStockAttribute()
    {
        return $this->stock > 0;
    }
}
