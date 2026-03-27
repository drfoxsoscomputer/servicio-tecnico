<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'tecnico', 'guard_name' => 'web']);
        Role::create(['name' => 'recepcionista', 'guard_name' => 'web']);
        Role::create(['name' => 'cajero', 'guard_name' => 'web']);

        // Crear usuario admin
        $user = User::create([
            'name' => 'Super Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('asdf1234'),
        ]);

        $user->assignRole('super_admin');

        // Seeders de datos base
        // $this->call([
        //     WorkshopStatusSeeder::class,
        //     PaymentMethodSeeder::class,
        //     ServiceSeeder::class,
        //     SettingsSeeder::class,
        // ]);

        // Generar permisos de Shield
        $this->command->call('shield:generate', ['--all' => true, '--ignore-existing-policies' => true]);
    }
}
