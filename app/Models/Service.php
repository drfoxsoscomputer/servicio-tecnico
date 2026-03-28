<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ===== RELACIONES =====

    public function prices(): HasMany
    {
        return $this->hasMany(ServicePrice::class);
    }

    public function ticketServices(): HasMany
    {
        return $this->hasMany(TicketService::class);
    }

    // ===== SCOPES =====

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
