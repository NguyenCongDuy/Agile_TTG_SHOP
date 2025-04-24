<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'noi_dung',
        'is_processed',
        'processed_by',
        'processed_at'
    ];

    protected $casts = [
        'is_processed' => 'boolean',
        'processed_at' => 'datetime'
    ];

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}

