<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'category_id',
        'stock',
        'is_featured',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'status' => 'boolean'
    ];

    // Automatically generate slug from name
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    // Relationship with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship with orders
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');
    }

    /**
     * Get the variants for this product.
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get the default variant for this product.
     */
    public function defaultVariant()
    {
        return $this->hasOne(ProductVariant::class)->where('is_default', true);
    }

    /**
     * Get the attributes for this product.
     */
    public function attributes()
    {
        return $this->belongsToMany(ProductAttribute::class, 'product_attribute_product');
    }

    /**
     * Check if the product has variants.
     */
    public function getHasVariantsAttribute()
    {
        return $this->variants()->count() > 0;
    }

    /**
     * Get the current price (lowest variant price or product price).
     */
    public function getCurrentPriceAttribute()
    {
        if ($this->has_variants) {
            $lowestPrice = $this->variants()
                ->where('is_active', true)
                ->where(function($query) {
                    $query->whereNotNull('price')
                          ->orWhereNotNull('sale_price');
                })
                ->min('price');

            return $lowestPrice ?: $this->price;
        }

        return $this->price;
    }

    /**
     * Check if the product is in stock.
     */
    public function getIsInStockAttribute()
    {
        if ($this->has_variants) {
            return $this->variants()->where('is_active', true)->sum('stock') > 0;
        }

        return $this->stock > 0;
    }
}
