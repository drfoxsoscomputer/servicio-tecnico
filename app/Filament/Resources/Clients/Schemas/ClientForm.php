<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre del Cliente / Empresa')
                    ->required()
                    ->maxLength(150),
                TextInput::make('document_id')
                    ->label('Cédula / RIF')
                    ->placeholder('Ej: V-12345678 o J-12345678-9 o G-12345678-9')
                    ->maxLength(50)
                    ->default(null),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->placeholder('Ej: correo@ejemplo.com')
                    ->email()
                    ->maxLength(150)
                    ->default(null),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->placeholder('Ej: +58 412-1234567')
                    ->maxLength(50)
                    ->tel()
                    ->default(null),
                Textarea::make('address')
                    ->label('Dirección')
                    ->rows(3)
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
