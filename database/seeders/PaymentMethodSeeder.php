<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            // Efectivo
            [
                'name' => 'Efectivo Bs',
                'type' => 'cash',
                'currency' => 'Bs',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Efectivo USD',
                'type' => 'cash',
                'currency' => 'USD',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Transferencia
            [
                'name' => 'Transferencia Bs',
                'type' => 'transfer',
                'currency' => 'Bs',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Transferencia USD',
                'type' => 'transfer',
                'currency' => 'USD',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Pago Móvil
            [
                'name' => 'Pago Móvil',
                'type' => 'mobile',
                'currency' => 'Bs',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Zelle
            [
                'name' => 'Zelle',
                'type' => 'crypto',
                'currency' => 'USD',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // USDT
            [
                'name' => 'USDT',
                'type' => 'crypto',
                'currency' => 'USDT',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // USDC
            [
                'name' => 'USDC',
                'type' => 'crypto',
                'currency' => 'USDC',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('payment_methods')->insert($methods);
    }
}
