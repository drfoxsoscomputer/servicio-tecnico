<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
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
                    ->required(),
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
                    ->maxLength(255),
                TextInput::make('cost_price')
                    ->label('Precio de costo')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->placeholder('1,234.50')
                    ->prefix('$')
                    ->dehydrateStateUsing(fn($state) => $state === null || $state === '' ? 0 : $state),
                TextInput::make('sale_price')
                    ->label('Precio de venta')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->required()
                    ->numeric()
                    ->placeholder('1,234.50')
                    ->prefix('$'),
                Toggle::make('is_active')
                    ->label('Activo')
                    ->inline(false)
                    ->onIcon(Heroicon::Check)
                    ->offIcon(Heroicon::XMark)
                    ->default(false),
                Repeater::make('images')
                    ->label('Imágenes')
                    ->helperText('La primera imagen será la principal.')
                    ->relationship('images')
                    ->orderColumn('position')
                    ->defaultItems(0)
                    ->reorderable()
                    ->collapsible()
                    ->schema([
                        FileUpload::make('path')
                            ->label('Imágen')
                            ->image()
                            ->directory('products'),

                    ])
                    ->columnSpanFull()
                    ->addActionLabel('+'),
            ]);
            dd($data);
    }
}
