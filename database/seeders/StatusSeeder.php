<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'received',          'color' => 'gray'],
            ['name' => 'diagnosing',       'color' => 'yellow'],
            ['name' => 'waiting_customer', 'color' => 'orange'],
            ['name' => 'approved',         'color' => 'blue'],
            ['name' => 'in_progress',      'color' => 'purple'],
            ['name' => 'ready_for_pickup', 'color' => 'teal'],
            ['name' => 'delivered',        'color' => 'green'],
            ['name' => 'canceled',         'color' => 'red'],
        ];

        foreach ($statuses as $status) {
            Status::firstOrCreate(['name' => $status['name']], $status);
        }
    }
}
