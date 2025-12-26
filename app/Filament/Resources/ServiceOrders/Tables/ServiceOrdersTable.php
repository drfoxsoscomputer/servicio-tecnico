<?php

namespace App\Filament\Resources\ServiceOrders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ServiceOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable(),
                TextColumn::make('device.name')
                    ->label('Equipo')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('device.client.name')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('technician.name')
                    ->label('Técnico')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->colors([
                        'gray' => 'received',
                        'warning' => 'diagnosing',
                        'danger' => 'repairing',
                        'info' => 'repaired',
                        'success' => 'delivered',
                    ])
                    ->sortable()
                    ->searchable(),
                TextColumn::make('estimated_cost')
                    ->label('Costo estimado')
                    ->money()
                    ->sortable(),
                TextColumn::make('total_cost')
                    ->label('Costo total')
                    ->money()
                    ->sortable(),
                TextColumn::make('received_at')
                    ->label('Recibido')
                    ->dateTime('d/m/Y h:i a')
                    ->sortable(),
                TextColumn::make('delivered_at')
                    ->label('Entregado')
                    ->dateTime('d/m/Y h:i a')
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->label('Eliminado')
                    ->dateTime('d/m/Y h:i a')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y h:i a')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d/m/Y h:i a')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('received_by_user_id')
                // ->numeric()
                // ->sortable(),
                // TextColumn::make('closed_by_user_id')
                // ->numeric()
                // ->sortable(),
            ])
            ->defaultSort('received_at', 'desc')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
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
