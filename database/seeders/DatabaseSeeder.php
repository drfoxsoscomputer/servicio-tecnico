<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->command->call('shield:generate', ['--all' => true]);

        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('asdf1234'),
        ]);

        $user->assignRole('super_admin');

        Role::Create(['name' => 'admin']);
        Role::Create(['name' => 'technician']);
        Role::Create(['name' => 'cashier']);

        $this->call([
            StatusSeeder::class,
        ]);
    }
}
