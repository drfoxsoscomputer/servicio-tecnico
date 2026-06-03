<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Diagnóstico', 'description' => 'Revisión inicial del equipo'],
            ['name' => 'Mantenimiento Preventivo Software', 'description' => 'Limpieza, actualización, optimización'],
            ['name' => 'Mantenimiento Correctivo Software', 'description' => 'Reparación de errores, virus, recovery'],
            ['name' => 'Instalación de Software', 'description' => 'Instalar sistema operativo o aplicaciones'],
            ['name' => 'Reparación de Pantalla', 'description' => 'Cambio de pantalla LCD/OLED'],
            ['name' => 'Reparación de Batería', 'description' => 'Cambio de batería'],
            ['name' => 'Reparación de Cargador', 'description' => 'Cambio de conector de carga'],
            ['name' => 'Reparación de Teclado', 'description' => 'Cambio de teclas o teclado completo'],
            ['name' => 'Recuperación de Datos', 'description' => 'Recuperar información de equipos dañados'],
            ['name' => 'Desbloqueo de Equipo', 'description' => 'Retirar bloqueo por patrón, PIN o cuenta'],
            ['name' => 'Cambio de Micrófono', 'description' => 'Reemplazo de micrófono'],
            ['name' => 'Cambio de Altavoz', 'description' => 'Reemplazo de altavoz'],
            ['name' => 'Reparación de Cámara', 'description' => 'Cambio de cámara frontal o trasera'],
            ['name' => 'Soldadura BGA', 'description' => 'Reparación de soldado en placa'],
            ['name' => 'Cambio de Tapa', 'description' => 'Reemplazo de tapa o carcasa'],
        ];

        foreach ($services as $service) {
            DB::table('services')->insert([
                ...$service,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
