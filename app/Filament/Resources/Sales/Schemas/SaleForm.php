<?php

namespace App\Filament\Resources\Sales\Schemas;

use App\Filament\Resources\Clients\Schemas\ClientForm;
use App\Models\Client;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Auth;

class SaleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Datos de la Venta')
                    ->tabs([
                        Tab::make('Datos del Cliente')
                            ->icon(Heroicon::User)
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
                                Select::make('user_id')
                                    ->label('Cajero')
                                    ->relationship('user', 'name')
                                    ->default(fn() => Auth::id())
                                    ->disabled()
                                    ->dehydrated(),
                                Select::make('status')
                                    ->label('Estado de la venta')
                                    ->options(
                                        [
                                            'draft' => 'Borrador',
                                            'pending' => 'Pendiente',
                                            'paid' => 'Pagada',
                                            'cancelled' => 'Anulada',
                                        ]
                                    )
                                    ->default('draft',)
                                    ->required(),
                            ]),
                        Tab::make('Montos')
                            ->icon(Heroicon::CurrencyDollar)
                            ->schema([
                                TextInput::make('net_amount')
                                    ->label('Neto')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->numeric()
                                    ->default(0.0)
                                    ->required(),
                                Select::make('discount_type')
                                    ->label('Tipo de descuento')
                                    ->options([
                                        'none' => 'Ninguno',
                                        'amount' => 'Monto fijo',
                                        'percentage' => 'Porcentaje',
                                    ])
                                    ->required()
                                    ->default('none'),
                                TextInput::make('discount_value')
                                    ->label('Valor del descuento')
                                    ->required()
                                    ->numeric()
                                    ->default(0.0),
                                TextInput::make('discount_amount')
                                    ->label('Monto del descuento')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->required()
                                    ->numeric()
                                    ->default(0.0),
                                TextInput::make('tax_percentage')
                                    ->label('% Impuesto')
                                    ->required()
                                    ->numeric()
                                    ->default(0),

                                TextInput::make('tax_amount')
                                    ->label('Monto del impuesto')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->required()
                                    ->numeric()
                                    ->default(0.0),
                                TextInput::make('total_amount')
                                    ->label('Total')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->required()
                                    ->numeric()
                                    ->default(0.0),
                            ])
                            ->columns(3),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                // Select::make('service_id')
                //     ->relationship('service', 'title'),
                Hidden::make('type')
                    // ->required()
                    ->default('sale'),







            ]);
    }
}
