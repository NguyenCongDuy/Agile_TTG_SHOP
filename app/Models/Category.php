<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_featured',
        'status'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'status' => 'boolean'
    ];

    // Automatically generate slug from name
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    // Relationship with products
    public function products()
    {
        return $this->hasMany(Products::class);
    }
} 