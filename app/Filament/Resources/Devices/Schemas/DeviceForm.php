<?php

namespace App\Filament\Resources\Devices\Schemas;

use App\Filament\Resources\Brands\BrandResource;

use App\Filament\Resources\Clients\Schemas\ClientForm;
use App\Filament\Resources\Types\TypeResource;
use App\Models\Client;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;


class DeviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->tabs([
                        Tab::make('Información de cliente')
                            ->schema([
                                Select::make('client_id')
                                    ->label('Cliente')
                                    ->relationship('client', 'name')
                                    ->searchable(['name', 'document_id'])
                                    ->preload()
                                    ->required()
                                    ->createOptionForm(
                                        fn(Schema $schema) => ClientForm::configure($schema),
                                    )
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                        // $state es el client_id seleccionado
                                        if (! $state) {
                                            $set('client_document_id', null);
                                            return;
                                        }

                                        $client = Client::find($state);
                                        $set('client_document_id', $client?->document_id);
                                    }),
                                TextInput::make('client_document_id')
                                    ->label('Cédula / Rif')
                                    ->disabled()
                                    ->dehydrated(false),

                            ])
                            ->columns(2),
                        Tab::make('Detalles del equipo')
                            ->schema([
                                Select::make('type_id')
                                    ->label('Tipo')
                                    ->relationship('type', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm(
                                        fn(Schema $schema) => TypeResource::form($schema),
                                    ),
                                Select::make('brand_id')
                                    ->label('Marca')
                                    ->relationship('brand', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm(
                                        fn(Schema $schema) => BrandResource::form($schema),
                                    ),
                                TextInput::make('model')
                                    ->label('Modelo')
                                    ->placeholder('Ej: Inspiron 15 3000')
                                    ->maxLength(255),
                                TextInput::make('serial')
                                    ->label('Serial')
                                    ->placeholder('Ingrese el número de serie del equipo')
                                    ->maxLength(255),
                                TextInput::make('access_password')
                                    ->label('Contraseña de acceso')
                                    ->password()
                                    ->revealable()
                                    ->maxLength(255),
                                Textarea::make('notes')
                                    ->label('Notas')
                                    ->placeholder('Ingrese cualquier nota adicional sobre el equipo')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
