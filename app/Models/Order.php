<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Order Statuses
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_DELIVERING = 'delivering';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Payment Statuses
    const PAYMENT_UNPAID = 'unpaid';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_FAILED = 'failed'; // Optional: Consider adding failed status
    const PAYMENT_REFUNDED = 'refunded'; // Optional: Consider adding refunded status

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'shipping_address',
        'billing_address',
        'payment_method',
        'notes',
        'status',
        'payment_status',
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

    /**
     * Get the rating for this order.
     */
    public function rating()
    {
        return $this->hasOne(OrderRating::class);
    }
}
