<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkshopStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Recibido',
                'slug' => 'recibido',
                'color' => '#6B7280',
                'description' => 'Equipo recibido, esperando asignación de técnico',
                'is_final' => false,
                'notify_role' => 'tecnico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Diagnosticando',
                'slug' => 'diagnosticando',
                'color' => '#F59E0B',
                'description' => 'Técnico revisando el equipo',
                'is_final' => false,
                'notify_role' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Esperando Aprobación',
                'slug' => 'esperando_aprobacion',
                'color' => '#3B82F6',
                'description' => 'Diagnóstico listo, esperando respuesta del cliente',
                'is_final' => false,
                'notify_role' => 'recepcionista',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Aprobado',
                'slug' => 'aprobado',
                'color' => '#10B981',
                'description' => 'Cliente aprobó la reparación',
                'is_final' => false,
                'notify_role' => 'tecnico',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Desaprobado',
                'slug' => 'desaprobado',
                'color' => '#EF4444',
                'description' => 'Cliente rechazó la reparación',
                'is_final' => true,
                'notify_role' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'En Reparación',
                'slug' => 'en_reparacion',
                'color' => '#8B5CF6',
                'description' => 'Técnico reparando el equipo',
                'is_final' => false,
                'notify_role' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Reparado',
                'slug' => 'reparado',
                'color' => '#14B8A6',
                'description' => 'Equipo reparado, listo para entrega',
                'is_final' => false,
                'notify_role' => 'recepcionista',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Esperando Retiro',
                'slug' => 'esperando_retiro',
                'color' => '#06B6D4',
                'description' => 'Equipo listo, cliente debe pasar a pagar y retirar',
                'is_final' => false,
                'notify_role' => 'recepcionista',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Entregado',
                'slug' => 'entregado',
                'color' => '#22C55E',
                'description' => 'Equipo entregado y pagado',
                'is_final' => true,
                'notify_role' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cancelado',
                'slug' => 'cancelado',
                'color' => '#DC2626',
                'description' => 'Servicio cancelado',
                'is_final' => true,
                'notify_role' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('workshop_statuses')->insert($statuses);
    }
}
