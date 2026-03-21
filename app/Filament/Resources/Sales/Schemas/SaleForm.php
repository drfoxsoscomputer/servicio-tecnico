<?php

namespace App\Filament\Resources\Sales\Schemas;

use App\Enums\DiscountType;
use App\Enums\SaleStatus;
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
                TextInput::make('invoice_number')
                    ->label('Número de factura')
                    ->placeholder('FAC-2026-0001')
                    ->maxLength(20),
                Tabs::make('Datos de la Venta')
                    ->tabs([
                        Tab::make('Cliente')
                            ->icon(Heroicon::User)
                            ->schema([
                                Select::make('client_id')
                                    ->label('Cliente')
                                    ->relationship('client', 'name')
                                    ->searchable(['name', 'document_id'])
                                    ->preload()
                                    ->createOptionForm(
                                        fn(Schema $schema) => ClientForm::configure($schema),
                                    ),
                                Select::make('user_id')
                                    ->label('Cajero')
                                    ->relationship('user', 'name')
                                    ->default(fn() => Auth::id())
                                    ->disabled()
                                    ->dehydrated(),
                                Select::make('type')
                                    ->label('Tipo')
                                    ->options([
                                        'pos' => 'Punto de Venta',
                                        'workshop' => 'Taller',
                                    ])
                                    ->default('pos'),
                                Select::make('status')
                                    ->label('Estado')
                                    ->options(SaleStatus::class)
                                    ->default(SaleStatus::PENDING),
                            ]),
                        Tab::make('Montos')
                            ->icon(Heroicon::CurrencyDollar)
                            ->schema([
                                TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(false),
                                TextInput::make('exchange_rate')
                                    ->label('Tasa BCV')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->numeric()
                                    ->default(1)
                                    ->live(),
                                Select::make('discount_type')
                                    ->label('Tipo de descuento')
                                    ->options(DiscountType::class)
                                    ->default(DiscountType::PERCENTAGE)
                                    ->live(),
                                TextInput::make('discount_value')
                                    ->label('Valor del descuento')
                                    ->numeric()
                                    ->default(0)
                                    ->live(),
                                TextInput::make('discount_amount')
                                    ->label('Monto descontado')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(false),
                                TextInput::make('total_bs')
                                    ->label('Total Bs')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(false),
                                TextInput::make('total_usd')
                                    ->label('Total USD')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(false),
                            ])
                            ->columns(2),
                        Tab::make('Notas')
                            ->icon(Heroicon::DocumentText)
                            ->schema([
                                Filament\Forms\Components\Textarea::make('notes')
                                    ->label('Notas')
                                    ->rows(3),
                            ]),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
