<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $queryThreshold = (float) config('instrumentation.slow_query_ms', 0);
        if ($queryThreshold > 0) {
            DB::listen(function ($query) use ($queryThreshold): void {
                if ($query->time < $queryThreshold) {
                    return;
                }
                Log::channel('performance')->info('slow_query', [
                    'ms' => $query->time,
                    'connection' => $query->connectionName,
                    'sql' => Str::limit($query->sql, 500),
                ]);
            });
        }
    }
}
