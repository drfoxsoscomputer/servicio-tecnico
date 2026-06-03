<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VariantAttribute extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ===== RELACIONES =====

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'variant_attribute_id');
    }

    // ===== SCOPES =====

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
