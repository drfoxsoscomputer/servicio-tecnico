<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'barcode',
        'price_bs',
        'price_usd',
        'has_inventory',
        'is_active',
    ];

    protected $casts = [
        'price_bs' => 'decimal:2',
        'price_usd' => 'decimal:2',
        'has_inventory' => 'boolean',
        'is_active' => 'boolean',
    ];

    // ===== RELACIONES =====

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function presentations(): HasMany
    {
        return $this->hasMany(ProductPresentation::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }

    // ===== SCOPES =====

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeWithStock(Builder $query): Builder
    {
        return $query->where('has_inventory', true);
    }
}
