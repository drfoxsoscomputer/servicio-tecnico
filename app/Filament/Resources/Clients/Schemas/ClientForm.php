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
                ->label('Nombre')
                ->placeholder('Ej: Juan Pérez')
                    ->required()
                    ->maxLength(255),
                TextInput::make('document_id')
                    ->label('Cédula / Rif')
                    ->placeholder('Ej: V-12345678, J-12345678-9, G-12345678-0')
                    ->maxLength(50),
                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->placeholder('Ej: juan.perez@example.com')
                    ->email()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->placeholder('Ej: +58 412-1234567')
                    ->tel()
                    ->maxLength(20),
                TextInput::make('address')
                    ->label('Dirección')
                    ->placeholder('Ej: Calle 123, Ciudad, País')
                    ->maxLength(255),
                Textarea::make('notes')
                    ->label('Notas')
                    ->placeholder('Información adicional sobre el cliente')
                    ->columnSpanFull(),
            ]);
    }
}
