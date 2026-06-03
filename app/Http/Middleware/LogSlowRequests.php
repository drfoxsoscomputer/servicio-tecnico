<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogSlowRequests
{
    public function handle(Request $request, Closure $next): Response
    {
        $threshold = (float) config('instrumentation.slow_request_ms', 0);
        if ($threshold <= 0) {
            return $next($request);
        }

        $start = microtime(true);

        try {
            return $next($request);
        } finally {
            $durationMs = (microtime(true) - $start) * 1000;
            if ($durationMs >= $threshold) {
                $route = $request->route();
                Log::channel('performance')->info('slow_request', [
                    'ms' => round($durationMs, 2),
                    'method' => $request->method(),
                    'path' => $request->path(),
                    'route' => $route?->getName(),
                    'action' => $route?->getActionName(),
                ]);
            }
        }
    }
}
