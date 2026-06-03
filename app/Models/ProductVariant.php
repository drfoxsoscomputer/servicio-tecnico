<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'sku',
        'price_bs',
        'price_usd',
        'barcode',
        'is_active',
    ];

    protected $casts = [
        'price_bs' => 'decimal:2',
        'price_usd' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // ===== RELACIONES =====

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues(): HasMany
    {
        return $this->hasMany(ProductVariantAttributeValue::class, 'product_variant_id');
    }

    public function variantValues()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'product_variant_attribute_values',
            'product_variant_id',
            'attribute_value_id'
        );
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

    public function scopeBySku(Builder $query, string $sku): Builder
    {
        return $query->where('sku', $sku);
    }

    // ===== ACCESSORS =====

    public function getDisplayNameAttribute(): string
    {
        $values = $this->variantValues->pluck('name')->toArray();

        return implode(' / ', $values);
    }
}
