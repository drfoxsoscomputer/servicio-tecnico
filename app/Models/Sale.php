<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'client_id',
        'user_id',
        'total_amount',
        'discount',
        'tax',
        'status',
        'payment_method_id',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
