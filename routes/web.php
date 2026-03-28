<?php

use App\Http\Controllers\PosClienteController;
use App\Models\Budget;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pos/cliente/{budget}', function (Budget $budget) {
    $budget->load(['items', 'client']);

    if (!in_array($budget->status, ['draft', 'printed'])) {
        abort(404, 'Presupuesto no disponible');
    }

    $subtotalBs = $budget->items->sum('subtotal_bs');
    $subtotalUsd = $budget->items->sum('subtotal_usd');
    $totalBs = $subtotalBs;
    $bcvRate = $budget->exchange_rate ?? 1;

    return view('pos.cliente', [
        'budget' => $budget,
        'subtotalBs' => $subtotalBs,
        'subtotalUsd' => $subtotalUsd,
        'totalBs' => $totalBs,
        'bcvRate' => $bcvRate,
    ]);
})->name('pos.cliente');
