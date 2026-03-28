<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presupuesto - {{ $budget->budget_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #111827; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        .animate-pulse-slow { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    </style>
</head>
<body class="min-h-screen text-white">
    <div class="max-w-4xl mx-auto p-6">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-yellow-400 tracking-wider">PRESUPUESTO</h1>
            <p class="text-2xl mt-2 font-mono">{{ $budget->budget_number }}</p>
            @if($budget->customer_name)
                <p class="text-xl text-gray-300 mt-1">{{ $budget->customer_name }}</p>
            @endif
            @if($budget->customer_phone)
                <p class="text-lg text-gray-400">{{ $budget->customer_phone }}</p>
            @endif
        </div>

        <div class="bg-gray-800 rounded-lg overflow-hidden mb-6">
            <table class="w-full">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Item</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold">Cant</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold">P.Unit (Bs)</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold">Total (Bs)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($budget->items as $item)
                        <tr class="hover:bg-gray-750">
                            <td class="px-4 py-3">
                                <p class="font-medium text-white">{{ $item->name }}</p>
                                <p class="text-xs text-gray-400 uppercase">{{ $item->item_type }}</p>
                            </td>
                            <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-right">
                                <span class="text-lg">{{ number_format($item->unit_price_bs, 2, ',', '.') }}</span>
                                <span class="text-xs text-gray-400 block">${{ number_format($item->unit_price_usd, 2, ',', '.') }} USD</span>
                            </td>
                            <td class="px-4 py-3 text-right font-semibold text-lg">
                                {{ number_format($item->subtotal_bs, 2, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-gray-400 text-lg">
                                Sin items agregados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-gray-800 rounded-lg p-6">
            <div class="space-y-3">
                <div class="flex justify-between text-xl">
                    <span class="text-gray-300">Subtotal:</span>
                    <span class="font-medium">{{ number_format($subtotalBs, 2, ',', '.') }} Bs</span>
                </div>
                <div class="flex justify-between text-sm text-gray-400">
                    <span>Subtotal USD:</span>
                    <span>${{ number_format($subtotalUsd, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-400">
                    <span>Tasa BCV:</span>
                    <span>{{ number_format($bcvRate, 2, ',', '.') }} Bs/USD</span>
                </div>
                <div class="flex justify-between text-3xl font-bold text-yellow-400 pt-4 border-t border-gray-700">
                    <span>TOTAL:</span>
                    <span>{{ number_format($totalBs, 2, ',', '.') }} Bs</span>
                </div>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-center gap-3 text-gray-500">
            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse-slow"></div>
            <span class="text-sm">Actualizado: <span id="lastUpdate">{{ now()->format('H:i:s') }}</span></span>
        </div>
    </div>

    <script>
        setInterval(() => {
            window.location.reload();
        }, 5000);
    </script>
</body>
</html>
