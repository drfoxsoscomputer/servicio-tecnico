<?php

namespace App\Services;

use App\Models\BcvRate;
use Illuminate\Support\Facades\Cache;

class BcvRateService
{
    protected const CACHE_KEY = 'bcv_current_rate';
    protected const CACHE_TTL = 3600;

    public function getCurrentRate(): float
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            $rate = BcvRate::latest()->first();
            
            if (!$rate) {
                return 1.0;
            }

            return (float) $rate->rate;
        });
    }

    public function convertToBs(float $usd, ?float $rate = null): float
    {
        $exchangeRate = $rate ?? $this->getCurrentRate();
        return round($usd * $exchangeRate, 2);
    }

    public function convertToUsd(float $bs, ?float $rate = null): float
    {
        $exchangeRate = $rate ?? $this->getCurrentRate();
        
        if ($exchangeRate === 0) {
            return 0;
        }
        
        return round($bs / $exchangeRate, 2);
    }

    public function refreshCache(): float
    {
        Cache::forget(self::CACHE_KEY);
        return $this->getCurrentRate();
    }
}
