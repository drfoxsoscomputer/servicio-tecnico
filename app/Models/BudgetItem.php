<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetItem extends Model
{
    protected $fillable = [
        'budget_id',
        'item_type',
        'item_id',
        'name',
        'quantity',
        'unit_price_bs',
        'unit_price_usd',
        'subtotal_bs',
        'subtotal_usd',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price_bs' => 'decimal:2',
        'unit_price_usd' => 'decimal:2',
        'subtotal_bs' => 'decimal:2',
        'subtotal_usd' => 'decimal:2',
    ];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (self $item) {
            $item->subtotal_bs = $item->quantity * $item->unit_price_bs;
            $item->subtotal_usd = $item->quantity * $item->unit_price_usd;
        });
    }
}
