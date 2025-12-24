<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre del Cliente / Empresa')
                    ->live(onBlur: true)
                    ->required()
                    ->minValue(3)
                    ->maxValue(150)
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (! $state) {
                            return;
                        }

                        $clean = trim($state);
                        $clean = preg_replace('/\s+/', ' ', $clean);
                        $clean = mb_convert_case($clean, MB_CASE_TITLE, 'UTF-8');

                        // Corregir algunas siglas comunes
                        $replacements = [
                            ' S.r.l.' => ' S.R.L.',
                            ' Srl' => ' S.R.L.',
                            ' S.r.l' => ' S.R.L.',
                            ' C.a.'   => ' C.A.',
                            ' C.a'    => ' C.A.',
                            ' Ca'    => ' C.A.',
                        ];

                        $clean = strtr($clean, $replacements);

                        $set('name', $clean);
                    }),
                TextInput::make('document_id')
                    ->label('Cédula / RIF')
                    ->placeholder('Ej: V-12345678 o J-12345678-9 o G-12345678-9')
                    ->minLength(9)
                    ->maxLength(50)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (! $state) {
                            return;
                        }

                        // Quitar espacios y pasar a mayúsculas
                        $clean = strtoupper(trim($state));
                        $clean = preg_replace('/\s+/', '', $clean);

                        // Si empieza por V/J/G y NO tiene guion después de la letra, lo insertamos
                        if (
                            preg_match('/^[VJG]/', $clean) && ! str_starts_with($clean, 'V-')
                            && ! str_starts_with($clean, 'J-') && ! str_starts_with($clean, 'G-')
                        ) {
                            // Inserta guion después del primer carácter (la letra)
                            $clean = substr($clean, 0, 1) . '-' . substr($clean, 1);
                        }

                        $set('document_id', $clean);
                    })
                    ->rule(function ($record) {
                        return Rule::unique('clients', 'document_id')
                            ->ignore($record?->id);
                    })
                    ->nullable(),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->placeholder('Ej: correo@ejemplo.com')
                    ->email()
                    ->maxLength(150)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (! $state) {
                            return;
                        }

                        // Quitar espacios y poner en minúsculas
                        $clean = trim($state);
                        $clean = preg_replace('/\s+/', '', $clean);
                        $clean = strtolower($clean);

                        $set('email', $clean);
                    })
                    ->rule(function ($record) {
                        return Rule::unique('clients', 'email')
                            ->ignore($record?->id);
                    })
                    ->default(null),

                TextInput::make('phone')
                    ->label('Teléfono')
                    ->placeholder('Ej: 04141234567 o +584141234567')
                    ->minLength(13)
                    ->maxLength(20)
                    ->tel()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (! $state) {
                            return;
                        }

                        // Quitar espacios, guiones, paréntesis
                        $clean = preg_replace('/[^\d+]/', '', $state);

                        // Si empieza por 0 (ej: 0412...), asumimos Venezuela sin código y lo pasamos a +58
                        if (str_starts_with($clean, '0')) {
                            // 0412xxxxxxx -> +58412xxxxxxx
                            $clean = '+58' . substr($clean, 1);
                        }

                        // Si empieza por 58 sin +, se lo agregamos
                        if (str_starts_with($clean, '58')) {
                            $clean = '+' . $clean;
                        }

                        $set('phone', $clean);
                    })
                    // Aceptar algo tipo +58XXXXXXXXXX (10–11 dígitos después del 58)
                    ->rule('regex:/^\+58\d{9,10}$/')
                    ->rule(function ($record) {
                        return Rule::unique('clients', 'phone')
                            ->ignore($record?->id);
                    })
                    ->nullable(),
                Textarea::make('address')
                    ->label('Dirección')
                    ->rows(3)
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
