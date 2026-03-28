<?php

namespace App\Filament\Resources\Budget\RelationManagers;

use App\Models\BudgetItem;
use App\Models\Product;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BudgetItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Items del Presupuesto';

    protected static ?string $label = 'Items';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('item_type')
                    ->label('Tipo')
                    ->formatStateUsing(fn (string $state): string => $state === 'product' ? 'Producto' : 'Servicio'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Cantidad')
                    ->numeric(),
                Tables\Columns\TextColumn::make('unit_price_bs')
                    ->label('Precio BS')
                    ->money('BS'),
                Tables\Columns\TextColumn::make('unit_price_usd')
                    ->label('Precio USD')
                    ->money('USD'),
                Tables\Columns\TextColumn::make('subtotal_bs')
                    ->label('Subtotal BS')
                    ->money('BS'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Agregar Item')
                    ->modalHeading('Agregar Item')
                    ->form($this->getItemFormSchema())
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['budget_id'] = $this->ownerRecord->id;
                        
                        if ($data['item_type'] === 'product') {
                            $product = Product::find($data['item_id']);
                            $data['name'] = $product?->name ?? 'Producto';
                            $data['unit_price_bs'] = $product?->price_bs ?? 0;
                            $data['unit_price_usd'] = $product?->price_usd ?? 0;
                        } else {
                            $service = Service::find($data['item_id']);
                            $data['name'] = $service?->name ?? 'Servicio';
                            $data['unit_price_bs'] = 0;
                            $data['unit_price_usd'] = 0;
                        }
                        
                        $data['subtotal_bs'] = $data['quantity'] * ($data['unit_price_bs'] ?? 0);
                        $data['subtotal_usd'] = $data['quantity'] * ($data['unit_price_usd'] ?? 0);
                        
                        return $data;
                    })
                    ->after(function () {
                        $this->recalculateTotals();
                    }),
            ])
            ->editActions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Editar Item')
                    ->form($this->getItemFormSchema())
                    ->mutateFormDataUsing(function (array $data): array {
                        if ($data['item_type'] === 'product') {
                            $product = Product::find($data['item_id']);
                            $data['name'] = $product?->name ?? $data['name'] ?? 'Producto';
                            $data['unit_price_bs'] = $product?->price_bs ?? ($data['unit_price_bs'] ?? 0);
                            $data['unit_price_usd'] = $product?->price_usd ?? ($data['unit_price_usd'] ?? 0);
                        } else {
                            $service = Service::find($data['item_id']);
                            $data['name'] = $service?->name ?? $data['name'] ?? 'Servicio';
                        }
                        
                        $data['subtotal_bs'] = $data['quantity'] * ($data['unit_price_bs'] ?? 0);
                        $data['subtotal_usd'] = $data['quantity'] * ($data['unit_price_usd'] ?? 0);
                        
                        return $data;
                    })
                    ->after(function () {
                        $this->recalculateTotals();
                    }),
            ])
            ->deleteActions([
                Tables\Actions\DeleteAction::make()
                    ->after(function () {
                        $this->recalculateTotals();
                    }),
            ]);
    }

    protected function getItemFormSchema(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    Select::make('item_type')
                        ->label('Tipo')
                        ->options([
                            'product' => 'Producto',
                            'service' => 'Servicio',
                        ])
                        ->reactive()
                        ->required(),
                    Select::make('item_id')
                        ->label('Item')
                        ->options(function (callable $get) {
                            if ($get('item_type') === 'product') {
                                return Product::active()
                                    ->pluck('name', 'id');
                            }
                            return Service::active()
                                ->pluck('name', 'id');
                        })
                        ->reactive()
                        ->required()
                        ->searchable(),
                ]),
            Grid::make(3)
                ->schema([
                    TextInput::make('quantity')
                        ->label('Cantidad')
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->required(),
                    TextInput::make('unit_price_bs')
                        ->label('Precio BS')
                        ->numeric()
                        ->prefix('BS')
                        ->hidden(fn (callable $get) => $get('item_type') === 'product'),
                    TextInput::make('unit_price_usd')
                        ->label('Precio USD')
                        ->numeric()
                        ->prefix('USD')
                        ->hidden(fn (callable $get) => $get('item_type') === 'product'),
                ]),
            TextInput::make('name')
                ->label('Nombre Personalizado')
                ->hidden(fn (callable $get) => $get('item_type') === 'product'),
        ];
    }

    protected function recalculateTotals(): void
    {
        $budget = $this->ownerRecord;
        $budget->refresh();
        
        $budgetService = app(\App\Services\BudgetService::class);
        $budgetService->recalculateTotals($budget);
    }
}
