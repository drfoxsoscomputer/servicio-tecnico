<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(150),
                Textarea::make('description')
                    ->label('Descripción')
                    ->rows(3),
                Select::make('category_id')
                    ->label('Categoría')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Categoría')
                            ->placeholder('Ej. Accesorios, Componentes, Servicios, Consumibles')
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('Activo')
                            ->inline(false)
                            ->onIcon(Heroicon::Check)
                            ->offIcon(Heroicon::XMark)
                            ->default(true),
                    ]),
                TextInput::make('sku')
                    ->label('SKU')
                    ->maxLength(100),
                TextInput::make('barcode')
                    ->label('Código de barras')
                    ->maxLength(100),
                TextInput::make('price_bs')
                    ->label('Precio Bs')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required()
                    ->placeholder('1,234.50')
                    ->prefix('Bs '),
                TextInput::make('price_usd')
                    ->label('Precio USD')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->placeholder('1,234.50')
                    ->prefix('$'),
                Toggle::make('has_variants')
                    ->label('¿Tiene variantes? (colores, tallas)')
                    ->inline(false)
                    ->onIcon(Heroicon::Check)
                    ->offIcon(Heroicon::XMark)
                    ->default(false),
                Toggle::make('is_active')
                    ->label('Activo')
                    ->inline(false)
                    ->onIcon(Heroicon::Check)
                    ->offIcon(Heroicon::XMark)
                    ->default(true),
            ]);
    }
}
