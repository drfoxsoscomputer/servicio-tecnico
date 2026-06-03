<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicePriceSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener servicios creados
        $services = DB::table('services')->get();

        // Precios base (en USD) para taller
        $prices = [
            'Diagnóstico' => 0,
            'Mantenimiento Preventivo Software' => 10,
            'Mantenimiento Correctivo Software' => 20,
            'Instalación de Software' => 15,
            'Reparación de Pantalla' => 50,
            'Reparación de Batería' => 25,
            'Reparación de Cargador' => 20,
            'Reparación de Teclado' => 30,
            'Recuperación de Datos' => 40,
            'Desbloqueo de Equipo' => 15,
            'Cambio de Micrófono' => 20,
            'Cambio de Altavoz' => 15,
            'Reparación de Cámara' => 25,
            'Soldadura BGA' => 60,
            'Cambio de Tapa' => 20,
        ];

        foreach ($services as $service) {
            $price = $prices[$service->name] ?? 10; // default $10

            DB::table('service_prices')->insert([
                'service_id' => $service->id,
                'location_type' => 'workshop',
                'price' => $price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
