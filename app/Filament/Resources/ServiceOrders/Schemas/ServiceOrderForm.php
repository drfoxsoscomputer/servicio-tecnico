<?php

namespace App\Filament\Resources\ServiceOrders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ServiceOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('device_id')
                    ->label('Equipo')
                    ->relationship('device', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('technician_id')
                    ->label('Técnico')
                    ->relationship('technician', 'name')
                    ->searchable()
                    ->preload()
                    ->default(null),
                TextInput::make('received_by_user_id')
                    ->label('Recibido por:')
                    ->numeric()
                    ->default(null),
                TextInput::make('closed_by_user_id')
                    ->label('Cerrado por:')
                    ->numeric()
                    ->default(null),
                Radio::make('status')
                    ->label('Estado')
                    ->options([
                        'received' => 'Recibido',
                        'diagnosing' => 'Diagnosticando',
                        'repairing' => 'Reparando',
                        'repaired' => 'Reparado',
                        'delivered' => 'Entregado',
                    ])
                    ->default('received')
                    ->inline()
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('problem_reported')
                    ->label('Problema reportado')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('diagnosis')
                    ->label('Diagnóstico del técnico')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('work_done')
                    ->label('Trabajo realizado')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('estimated_cost')
                    ->label('Costo estimado')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                TextInput::make('total_cost')
                    ->label('Costo total')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                DateTimePicker::make('received_at')
                    ->label('Fecha de recepción')
                    ->displayFormat('d/m/Y h:i a')
                    ->seconds(false)
                    ->closeOnDateSelection()
                    ->required(),
                    DateTimePicker::make('delivered_at')
                    ->label('Fecha de entrega')
                    ->displayFormat('d/m/Y h:i a')
                    ->seconds(false)
                    ->default(null),
            ]);
    }
}
