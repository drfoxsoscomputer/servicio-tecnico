<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkshopStatus extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'color',
        'description',
        'is_final',
        'notify_role',
    ];

    protected $casts = [
        'is_final' => 'boolean',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(ServiceTicket::class);
    }

    public function scopeFinal($query)
    {
        return $query->where('is_final', true);
    }
}
