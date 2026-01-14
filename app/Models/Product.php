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
        'sku',
        'barcode',
        'cost_price',
        'sale_price',
        'is_active',
    ];

    // ===== RELACIONES =====

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function parts(): HasMany
    {
        return $this->hasMany(Part::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

        // ===== SCOPES =====

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeNotDeleted(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }
}
