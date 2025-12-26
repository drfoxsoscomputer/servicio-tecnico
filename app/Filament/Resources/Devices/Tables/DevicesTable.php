<?php

namespace App\Filament\Resources\Devices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class DevicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nombre del dispositivo')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('brand')
                    ->label('Marca')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('model')
                    ->label('Modelo')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('serial')
                    ->label('Serial del dispositivo')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->label('Eliminado el')
                    ->dateTime('d/m/Y h:i a')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime('d/m/Y h:i a')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime('d/m/Y h:i a')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
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
