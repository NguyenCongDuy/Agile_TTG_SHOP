<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'shipping_address',
        'billing_address',
        'payment_method',
        'notes',
        'status',
        'total_amount'
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

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
} 