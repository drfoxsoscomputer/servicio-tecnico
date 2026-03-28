<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    protected $fillable = [
        'budget_number',
        'client_id',
        'customer_name',
        'customer_phone',
        'subtotal_bs',
        'subtotal_usd',
        'exchange_rate',
        'total_bs',
        'status',
        'notes',
        'printed_at',
        'created_by',
    ];

    protected $casts = [
        'subtotal_bs' => 'decimal:2',
        'subtotal_usd' => 'decimal:2',
        'exchange_rate' => 'decimal:2',
        'total_bs' => 'decimal:2',
        'printed_at' => 'datetime',
    ];

    protected $hidden = [
        'created_by',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(BudgetItem::class);
    }

    public function markAsPrinted(): void
    {
        $this->update([
            'status' => 'printed',
            'printed_at' => now(),
        ]);
    }

    public function isPrinted(): bool
    {
        return $this->status === 'printed';
    }
}
