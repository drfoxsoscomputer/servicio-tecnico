<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Instrumentación temporal de rendimiento
    |--------------------------------------------------------------------------
    |
    | Valores en milisegundos. 0 desactiva cada medición.
    | Revisa storage/logs/performance.log
    |
    */

    'slow_request_ms' => (float) env('INSTRUMENT_SLOW_REQUEST_MS', 0),

    'slow_query_ms' => (float) env('INSTRUMENT_SLOW_QUERY_MS', 0),

];
