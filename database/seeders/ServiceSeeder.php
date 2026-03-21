<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Diagnóstico', 'description' => 'Revisión inicial del equipo', 'base_price' => 0],
            ['name' => 'Mantenimiento Preventivo Software', 'description' => 'Limpieza, actualización, optimización', 'base_price' => 10],
            ['name' => 'Mantenimiento Correctivo Software', 'description' => 'Reparación de errores, virus, recovery', 'base_price' => 20],
            ['name' => 'Instalación de Software', 'description' => 'Instalar sistema operativo o aplicaciones', 'base_price' => 15],
            ['name' => 'Reparación de Pantalla', 'description' => 'Cambio de pantalla LCD/OLED', 'base_price' => 50],
            ['name' => 'Reparación de Batería', 'description' => 'Cambio de batería', 'base_price' => 25],
            ['name' => 'Reparación de Cargador', 'description' => 'Cambio de conector de carga', 'base_price' => 20],
            ['name' => 'Reparación de Teclado', 'description' => 'Cambio de teclas o teclado completo', 'base_price' => 30],
            ['name' => 'Recuperación de Datos', 'description' => 'Recuperar información de equipos dañados', 'base_price' => 40],
            ['name' => 'Desbloqueo de Equipo', 'description' => 'Retirar bloqueo por patrón, PIN o cuenta', 'base_price' => 15],
            ['name' => 'Cambio de Micrófono', 'description' => 'Reemplazo de micrófono', 'base_price' => 20],
            ['name' => 'Cambio de Altavoz', 'description' => 'Reemplazo de altavoz', 'base_price' => 15],
            ['name' => 'Reparación de Cámara', 'description' => 'Cambio de cámara frontal o trasera', 'base_price' => 25],
            ['name' => 'Soldadura BGA', 'description' => 'Reparación de soldado en placa', 'base_price' => 60],
            ['name' => 'Cambio de Tapa', 'description' => 'Reemplazo de tapa o carcasa', 'base_price' => 20],
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
