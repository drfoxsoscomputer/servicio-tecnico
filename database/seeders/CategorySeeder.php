<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::firstOrCreate(
            ['name' => 'Sin categoría'],
            [
                'color' => '#6B7280',
                'is_active' => true,
            ]
        );
    }
}
