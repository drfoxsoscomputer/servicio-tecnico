<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BcvRate extends Model
{
    protected $fillable = [
        'rate',
        'source',
        'recorded_by',
        'recorded_at',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'recorded_at' => 'datetime',
    ];

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public static function getCurrentRate(): float
    {
        return (float) static::latest()->first()?->rate ?? 1;
    }
}
