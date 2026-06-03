<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductInfolist
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
                                TextEntry::make('name')
                                    ->label('Nombre del Producto')
                                    ->size('lg')
                                    ->weight('bold')
                                    ->columnSpanFull(),

                                TextEntry::make('description')
                                    ->label('Descripción')
                                    ->placeholder('Sin descripción.')
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Métricas y Precios (Base)')
                            ->icon('heroicon-o-currency-dollar')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('price_bs')
                                    ->label('Precio Bs.')
                                    ->numeric(decimalPlaces: 2, decimalSeparator: ',', thousandsSeparator: '.')
                                    ->prefix('Bs. '),

                                TextEntry::make('price_usd')
                                    ->label('Precio $USD')
                                    ->numeric(decimalPlaces: 2, decimalSeparator: ',', thousandsSeparator: '.')
                                    ->prefix('$ '),
                            ]),
                    ]),

                Group::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('Clasificación')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                TextEntry::make('category.name')
                                    ->label('Categoría')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('barcode')
                                    ->label('Código de Barras Global')
                                    ->placeholder('N/A'),
                            ]),

                        Section::make('Estado')
                            ->icon('heroicon-o-check-circle')
                            ->schema([
                                IconEntry::make('has_inventory')
                                    ->label('Controla Inventario')
                                    ->boolean(),

                                IconEntry::make('is_active')
                                    ->label('Activo')
                                    ->boolean(),
                            ]),

                        Section::make('Sistema')
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Creado')
                                    ->dateTime()
                                    ->since()
                                    ->placeholder('-'),
                            ])->collapsed(),
                    ]),
            ]);
    }
}
