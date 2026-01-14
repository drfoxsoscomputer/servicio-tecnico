<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{

    protected $fillable = [
        'name',
        'is_active',
    ];

    // ===== RELACIONES =====

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    // ===== SCOPES =====

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
