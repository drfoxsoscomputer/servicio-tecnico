<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Combo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price_bs',
        'price_usd',
        'is_active',
        'valid_from',
        'valid_until',
    ];

    protected $casts = [
        'price_bs' => 'decimal:2',
        'price_usd' => 'decimal:2',
        'is_active' => 'boolean',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ComboItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('valid_from')
              ->orWhere('valid_from', '<=', now());
        })->where(function ($q) {
            $q->whereNull('valid_until')
              ->orWhere('valid_until', '>=', now());
        });
    }
}
