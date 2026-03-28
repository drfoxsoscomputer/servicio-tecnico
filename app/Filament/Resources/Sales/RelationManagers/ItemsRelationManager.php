<?php

namespace App\Filament\Resources\Sales\RelationManagers;

use App\Models\Product;
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
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\RawJs;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('item_type')
                    ->label('Tipo')
                    ->options([
                        'product' => 'Producto',
                        'service' => 'Servicio',
                        'combo' => 'Combo',
                    ])
                    ->default('product')
                    ->required(),
                Select::make('product_id')
                    ->label('Producto')
                    ->relationship('product', 'name', modifyQueryUsing: fn($query) => $query->active())
                    ->searchable(['name', 'sku', 'barcode'])
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        if ($state) {
                            $product = Product::find($state);
                            if ($product) {
                                $set('unit_price', $product->price_usd);
                            }
                        }
                    }),
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
                    ->minValue(1)
                    ->default(1)
                    ->required(),
                TextInput::make('unit_price')
                    ->label('Precio Unitario (USD)')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required(),
                TextInput::make('serial_number')
                    ->label('Número de serie')
                    ->maxLength(100),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('item_type')->label('Tipo'),
                TextEntry::make('product.name')->label('Producto'),
                TextEntry::make('variant.name')->label('Variante'),
                TextEntry::make('presentation.name')->label('Presentación'),
                TextEntry::make('quantity')->label('Cantidad'),
                TextEntry::make('unit_price')->label('Precio Unitario')->money('USD'),
                TextEntry::make('subtotal')->label('Subtotal')->money('USD'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product.name')
            ->columns([
                TextColumn::make('product.name')
                    ->label('Producto')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('variant.name')
                    ->label('Variante')
                    ->sortable(),
                TextColumn::make('presentation.name')
                    ->label('Presentación')
                    ->sortable(),
                TextColumn::make('quantity')
                    ->label('Cantidad')
                    ->sortable(),
                TextColumn::make('unit_price')
                    ->label('Precio USD')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('USD')
                    ->sortable(),
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
