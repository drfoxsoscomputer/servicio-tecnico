<?php

namespace App\Filament\Resources\Sales\Tables;

use App\Enums\SaleStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document_number')
                    ->label('Documento')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sale_type')
                    ->label('Tipo')
                    ->badge()
                    ->colors([
                        'success' => 'sale',
                        'warning' => 'quote',
                    ])
                    ->sortable(),
                TextColumn::make('client.name')
                    ->label('Cliente')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Cajero')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Origen')
                    ->badge()
                    ->colors([
                        'success' => 'pos',
                        'info' => 'workshop',
                    ])
                    ->sortable(),
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('VES')
                    ->sortable(),
                TextColumn::make('discount_amount')
                    ->label('Descuento')
                    ->money('VES')
                    ->sortable(),
                TextColumn::make('total_bs')
                    ->label('Total Bs')
                    ->money('VES')
                    ->sortable(),
                TextColumn::make('total_usd')
                    ->label('Total USD')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'partial',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('sale_type')
                    ->label('Tipo')
                    ->options([
                        'sale' => 'Nota de Entrega',
                        'quote' => 'Cotización',
                    ]),
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options(SaleStatus::class),
                SelectFilter::make('type')
                    ->label('Origen')
                    ->options([
                        'pos' => 'Punto de Venta',
                        'workshop' => 'Taller',
                    ]),
                TrashedFilter::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
