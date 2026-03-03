<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del producto')
                    ->icon(Heroicon::InformationCircle)
                    ->iconColor('primary')
                    ->inlineLabel()
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nombre'),
                        TextEntry::make('category.name')
                            ->label('Category'),
                        TextEntry::make('sku')
                            ->label('SKU')
                            ->placeholder('-'),
                        TextEntry::make('barcode')
                            ->placeholder('-'),
                        TextEntry::make('cost_price')
                        ->label('Precio de costo')
                            ->badge()
                            ->color('info')
                            ->money(),
                        TextEntry::make('sale_price')
                        ->label('Precio de venta')
                            ->badge()
                            ->color('success')
                            ->money(),
                        IconEntry::make('is_active')
                            ->label('Activo')
                            ->boolean(),
                        TextEntry::make('deleted_at')
                            ->dateTime()
                            ->visible(fn(Product $record): bool => $record->trashed()),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ]),
                Section::make('Imágenes')
                    // ->inlineLabel()
                    ->icon(Heroicon::Photo)
                    ->iconColor('primary')
                    ->schema([
                        ImageEntry::make('images.path')
                            ->alignCenter()
                            // ->label('Imágen(es)')
                            ->hiddenLabel()
                            ->square()
                            ->columnSpanFull(),

                    ])
            ]);
    }
}
