<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Generales
            ['key' => 'store_name', 'value' => 'Servicio Técnico', 'type' => 'string', 'group' => 'general', 'description' => 'Nombre de la tienda'],
            ['key' => 'store_address', 'value' => '', 'type' => 'string', 'group' => 'general', 'description' => 'Dirección de la tienda'],
            ['key' => 'store_phone', 'value' => '', 'type' => 'string', 'group' => 'general', 'description' => 'Teléfono de contacto'],
            ['key' => 'store_email', 'value' => '', 'type' => 'string', 'group' => 'general', 'description' => 'Email de contacto'],
            
            // Facturación
            ['key' => 'invoice_prefix', 'value' => 'FAC', 'type' => 'string', 'group' => 'invoice', 'description' => 'Prefijo para facturas'],
            ['key' => 'ticket_prefix', 'value' => 'TKT', 'type' => 'string', 'group' => 'invoice', 'description' => 'Prefijo para tickets'],
            
            // Sistema
            ['key' => 'current_bcv_rate', 'value' => '0', 'type' => 'number', 'group' => 'system', 'description' => 'Tasa BCV actual'],
            ['key' => 'low_stock_alert', 'value' => '5', 'type' => 'number', 'group' => 'system', 'description' => 'Alerta de stock bajo por defecto'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert([
                ...$setting,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
