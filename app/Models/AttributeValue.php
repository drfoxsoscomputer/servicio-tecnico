<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeValue extends Model
{
    protected $fillable = [
        'variant_attribute_id',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ===== RELACIONES =====

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(VariantAttribute::class, 'variant_attribute_id');
    }

    public function variantValues(): HasMany
    {
        return $this->hasMany(ProductVariantAttributeValue::class, 'attribute_value_id');
    }

    // ===== SCOPES =====

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
