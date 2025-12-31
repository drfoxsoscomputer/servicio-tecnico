<?php

namespace App\Filament\Resources\Devices\Schemas;

use App\Filament\Resources\Clients\Schemas\ClientForm;
use Filament\Actions\Action;
use Filament\Actions\Concerns\HasTooltip;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DeviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->label('Cliente')
                    ->relationship('client', 'name')
                    ->searchable('name', 'document_id', 'phone')
                    ->preload()
                    ->required()
                    ->createOptionForm(function (Schema $schema) {
                        return ClientForm::configure($schema);
                    })
                // ->createOptionAction(function (Action $action){
                //     $action->tooltip('Crear nuevo cliente');
                // })
                ,
                TextInput::make('name')
                    ->label('Nombre del equipo')
                    ->maxLength(150)
                    ->default(null),
                TextInput::make('type')
                    ->label('Tipo')
                    ->placeholder('Ej: PC, Laptop, Impresora, Smartphone, Tablet, etc.')
                    ->maxLength(50)
                    ->required(),
                TextInput::make('brand')
                    ->label('Marca')
                    ->maxLength(100)
                    ->default(null),
                TextInput::make('model')
                    ->label('Modelo')
                    ->maxLength(100)
                    ->default(null),
                TextInput::make('serial')
                    ->label('Serial del equipo')
                    ->maxLength(100)
                    ->default(null),
                TextInput::make('access_password')
                    ->label('Contraseña de acceso')
                    ->password()
                    ->revealable()
                    ->maxLength(150)
                    ->default(null),
                Textarea::make('notes')
                    ->label('Notas del equipo')
                    ->rows(3)
                    ->default(null)
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }
}
