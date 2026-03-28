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
            
            // Facturación / Documentos
            ['key' => 'ticket_prefix', 'value' => 'TKT', 'type' => 'string', 'group' => 'invoice', 'description' => 'Prefijo para tickets legacy'],
            
            // Cotizaciones
            ['key' => 'quote_prefix', 'value' => 'COT', 'type' => 'string', 'group' => 'invoice', 'description' => 'Prefijo para cotizaciones'],
            ['key' => 'quote_validity_days', 'value' => '7', 'type' => 'number', 'group' => 'invoice', 'description' => 'Días de validez de cotización'],
            
            // Notas de Entrega
            ['key' => 'delivery_note_prefix', 'value' => 'NTE', 'type' => 'string', 'group' => 'invoice', 'description' => 'Prefijo para notas de entrega'],
            
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
