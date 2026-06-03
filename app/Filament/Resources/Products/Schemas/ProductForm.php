<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use App\Models\BcvRate;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make()
                    ->columnSpan(2)
                    ->schema([
                        Section::make('Información Principal')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre del Producto')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Textarea::make('description')
                                    ->label('Descripción')
                                    ->rows(4)
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Métricas y Precios (Base)')
                            ->description('Precio base del producto. Puede ser modificado a nivel de la variante.')
                            ->icon('heroicon-o-currency-dollar')
                            ->columns(2)
                            ->schema([
                                TextInput::make('price_bs')
                                    ->label('Precio Bs.')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Bs.')
                                    ->default(0)
                                    ->placeholder('0,00')
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if (!$state) return;
                                        $clean = str_contains($state, ',') ? str_replace(',', '.', str_replace('.', '', $state)) : str_replace(',', '.', $state);
                                        $value = (float) $clean;
                                        $set('price_usd', round(\App\Models\BcvRate::convertBsToUsd($value), 2));
                                    }),

                                TextInput::make('price_usd')
                                    ->label('Precio $USD')
                                    ->required()
                                    ->numeric()
                                    ->prefix('$')
                                    ->default(0)
                                    ->placeholder('0,00')
                                    ->hint('Tasa BCV: ' . number_format(\App\Models\BcvRate::getCurrentRate(), 2, ',', '.') . ' Bs.')
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if (!$state) return;
                                        $clean = str_contains($state, ',') ? str_replace(',', '.', str_replace('.', '', $state)) : str_replace(',', '.', $state);
                                        $value = (float) $clean;
                                        $set('price_bs', round(\App\Models\BcvRate::convertUsdToBs($value), 2));
                                    }),
                            ]),
                    ]),

                Group::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Clasificación')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                Select::make('category_id')
                                    ->label('Categoría')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                TextInput::make('barcode')
                                    ->label('Código de Barras Global')
                                    ->helperText('Opcional. Ignóralo si usas Códigos distintos por cada Variante.')
                                    ->maxLength(255),
                            ]),

                        Section::make('Estado')
                            ->icon('heroicon-o-check-circle')
                            ->schema([
                                Toggle::make('has_inventory')
                                    ->label('Lleva Control de Inventario')
                                    ->helperText('Apágalo si es un servicio intangible.')
                                    ->default(true)
                                    ->required(),

                                Toggle::make('is_active')
                                    ->label('Producto Activo')
                                    ->default(true)
                                    ->required(),
                            ]),
                    ]),
            ]);
    }
}
