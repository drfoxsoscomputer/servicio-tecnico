<?php

namespace App\Filament\Resources\BcvRates\Schemas;

use Filament\Schemas\Schema;

class BcvRateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('rate')
                    ->label('Tasa del Día')
                    ->required()
                    ->numeric()
                    ->step(0.0001)
                    ->placeholder('Ej: 484,7404')
                    ->prefix('Bs.')
                    ->helperText('Use COMA (,) para los decimales.')
                    ->extraInputAttributes(['inputmode' => 'decimal']),
            ]);
    }
}
