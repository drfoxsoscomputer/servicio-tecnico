<?php

namespace Database\Seeders;

use App\Models\StockLocation;
use Illuminate\Database\Seeder;

class StockLocationSeeder extends Seeder
{
    public function run(): void
    {
        StockLocation::firstOrCreate(
            ['name' => 'Almacén'],
            [
                'description' => 'Ubicación principal de stock',
                'is_active' => true,
            ]
        );
    }
}
