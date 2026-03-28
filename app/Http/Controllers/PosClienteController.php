<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class PosClienteController extends Controller
{
    public function show(Budget $budget)
    {
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
    }
}
