<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $fillable = [
        'name',
        'color',
        'is_active',
    ];

    // ===== RELACIONES =====

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    // public function sales(): HasMany
    // {
    //     return $this->hasMany(Sale::class);
    // }

    // ===== SCOPES =====

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
