<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductStockRelationManager extends RelationManager
{
    protected static string $relationship = 'stocks';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('variant_id')
                    ->label('Variante')
                    ->relationship('variant', 'name')
                    ->preload()
                    ->searchable(),
                Select::make('presentation_id')
                    ->label('Presentación')
                    ->relationship('presentation', 'name')
                    ->preload()
                    ->searchable(),
                TextInput::make('quantity')
                    ->label('Cantidad')
                    ->numeric()
                    ->required(),
                TextInput::make('min_stock_alert')
                    ->label('Alerta de stock mínimo')
                    ->numeric()
                    ->placeholder('Ej: 5'),
                TextInput::make('location')
                    ->label('Ubicación')
                    ->placeholder('Ej: Taller, Bodega')
                    ->maxLength(50),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('variant.name')->label('Variante'),
                TextEntry::make('presentation.name')->label('Presentación'),
                TextEntry::make('quantity')->label('Cantidad'),
                TextEntry::make('min_stock_alert')->label('Stock mínimo'),
                TextEntry::make('location')->label('Ubicación'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('variant.name')
            ->columns([
                TextColumn::make('variant.name')
                    ->label('Variante')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('presentation.name')
                    ->label('Presentación')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->label('Cantidad')
                    ->sortable(),
                TextColumn::make('min_stock_alert')
                    ->label('Stock Mín.')
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Ubicación')
                    ->searchable(),
                IconColumn::make('quantity')
                    ->label('Alerta')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->quantity <= $record->min_stock_alert && $record->min_stock_alert > 0),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
