<?php

namespace App\Filament\Resources\Sales\Schemas;

use App\Filament\Resources\Clients\Schemas\ClientForm;
use App\Models\Client;
use App\Services\SaleCalculationService;
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
                                    ->createOptionForm(
                                        fn(Schema $schema) => ClientForm::configure($schema),
                                    )
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
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
                                    ->options([
                                        'draft' => 'Borrador',
                                        'pending' => 'Pendiente',
                                        'paid' => 'Pagada',
                                        'cancelled' => 'Anulada',
                                        'completed' => 'Completada',
                                    ])
                                    ->default('draft'),
                            ]),
                        Tab::make('Montos')
                            ->icon(Heroicon::CurrencyDollar)
                            ->schema([
                                TextInput::make('net_amount')
                                    ->label('Subtotal (Neto)')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(false),
                                Select::make('discount_type')
                                    ->label('Tipo de descuento')
                                    ->options([
                                        'none' => 'Ninguno',
                                        'amount' => 'Monto fijo',
                                        'percentage' => 'Porcentaje',
                                    ])
                                    ->default('none')
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        self::recalculateTotals($get, $set);
                                    }),
                                TextInput::make('discount_value')
                                    ->label('Valor del descuento')
                                    ->numeric()
                                    ->default(0)
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        self::recalculateTotals($get, $set);
                                    }),
                                TextInput::make('discount_amount')
                                    ->label('Monto del descuento')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(false),
                                TextInput::make('tax_percentage')
                                    ->label('% IVA')
                                    ->numeric()
                                    ->default(21)
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        self::recalculateTotals($get, $set);
                                    }),
                                TextInput::make('tax_amount')
                                    ->label('Monto del IVA')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(false),
                                TextInput::make('total_amount')
                                    ->label('Total')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(false),
                            ])
                            ->columns(3),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Hidden::make('type')
                    ->default('sale'),
            ]);
    }

    private static function recalculateTotals(Get $get, Set $set): void
    {
        $netAmount = (float) ($get('net_amount') ?? 0);
        $discountType = $get('discount_type') ?? 'none';
        $discountValue = (float) ($get('discount_value') ?? 0);
        $taxPercentage = (float) ($get('tax_percentage') ?? 21);

        $discountAmount = 0;
        if ($discountType === 'percentage') {
            $discountAmount = $netAmount * ($discountValue / 100);
        } elseif ($discountType === 'amount') {
            $discountAmount = $discountValue;
        }

        $taxableAmount = $netAmount - $discountAmount;
        $taxAmount = $taxableAmount * ($taxPercentage / 100);
        $totalAmount = $taxableAmount + $taxAmount;

        $set('discount_amount', round($discountAmount, 2));
        $set('tax_amount', round($taxAmount, 2));
        $set('total_amount', round($totalAmount, 2));
    }
}
