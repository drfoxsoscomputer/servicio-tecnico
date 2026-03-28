<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseRequestItem extends Model
{
    protected $fillable = [
        'request_id',
        'product_id',
        'product_name',
        'quantity_needed',
        'times_requested',
        'supplier_price',
        'last_request_at',
    ];

    protected $casts = [
        'quantity_needed' => 'integer',
        'times_requested' => 'integer',
        'supplier_price' => 'decimal:2',
        'last_request_at' => 'datetime',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequest::class, 'request_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
