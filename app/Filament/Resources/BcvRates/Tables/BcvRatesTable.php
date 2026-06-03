<?php

namespace App\Filament\Resources\BcvRates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class BcvRatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('rate')
                    ->label('Tasa')
                    ->numeric(decimalPlaces: 4, decimalSeparator: ',', thousandsSeparator: '.')
                    ->prefix('Bs. ')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\Action::make('sync_prices')
                    ->label('Sincronizar Precios')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('¿Sincronizar precios de todo el inventario?')
                    ->modalDescription('Esta acción actualizará el precio en Bs. de TODOS los productos y variantes usando esta tasa. ¿Deseas continuar?')
                    ->action(function ($record) {
                        $productCount = \App\Models\Product::count();
                        $variantCount = \App\Models\ProductVariant::count();
                        
                        // Actualizar Productos
                        \App\Models\Product::query()->chunk(100, function ($products) use ($record) {
                            foreach ($products as $product) {
                                $product->update([
                                    'price_bs' => round($product->price_usd * $record->rate, 2)
                                ]);
                            }
                        });

                        // Actualizar Variantes
                        \App\Models\ProductVariant::query()->chunk(100, function ($variants) use ($record) {
                            foreach ($variants as $variant) {
                                $variant->update([
                                    'price_bs' => round($variant->price_usd * $record->rate, 2)
                                ]);
                            }
                        });

                        \Filament\Notifications\Notification::make()
                            ->title('Sincronización Exitosa')
                            ->body("Se han actualizado {$productCount} productos y {$variantCount} variantes.")
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
