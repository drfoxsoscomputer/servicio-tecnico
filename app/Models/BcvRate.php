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
        'rate' => 'decimal:4',
        'recorded_at' => 'datetime',
    ];

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    protected static function booted(): void
    {
        static::creating(function ($bcvRate) {
            $bcvRate->recorded_at ??= now();
            $bcvRate->recorded_by ??= auth()->id();
        });

        static::saved(function () {
            cache()->forget('bcv_current_rate');
        });

        static::deleted(function () {
            cache()->forget('bcv_current_rate');
        });
    }

    public static function getCurrentRate(): float
    {
        return cache()->remember('bcv_current_rate', now()->addMinutes(15), function () {
            return (float) static::latest('recorded_at')->first()?->rate ?? 1.0;
        });
    }

    public static function convertUsdToBs(float $amount): float
    {
        return round($amount * static::getCurrentRate(), 2);
    }

    public static function convertBsToUsd(float $amount): float
    {
        $rate = static::getCurrentRate();
        return $rate > 0 ? round($amount / $rate, 2) : 0;
    }
}
