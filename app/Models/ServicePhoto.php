<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicePhoto extends Model
{
    protected $fillable = [
        'service_id',
        'name',
        'type',
        'path',
    ];

    // ===== RELACIONES =====

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // ===== ACCESSORS =====

    public function getTitleAttribute(): string
    {
        return "{$this->name} ({$this->type})";
    }
}
