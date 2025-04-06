<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'shipping_address',
        'billing_address',
        'payment_method',
        'payment_status',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'status' => 'string',
        'payment_status' => 'string'
    ];

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with products
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price');
    }
} 