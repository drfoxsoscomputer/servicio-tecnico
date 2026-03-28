<?php

namespace App\Filament\Resources\Budget;

use App\Filament\Resources\Budget\Pages\CreateBudget;
use App\Filament\Resources\Budget\Pages\EditBudget;
use App\Filament\Resources\Budget\Pages\ListBudgets;
use App\Filament\Resources\Budget\Pages\ViewBudget;
use App\Filament\Resources\Budget\RelationManagers\BudgetItemsRelationManager;
use App\Models\Budget;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class BudgetResource extends Resource
{
    protected static ?string $model = Budget::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static ?string $recordTitleAttribute = 'budget_number';

    protected static ?string $modelLabel = 'presupuesto';

    protected static string|UnitEnum|null $navigationGroup = 'POS';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Section::make('Información del Cliente')
                    ->schema([
                        \Filament\Forms\Components\Select::make('client_id')
                            ->label('Cliente')
                            ->relationship('client', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        \Filament\Forms\Components\TextInput::make('customer_name')
                            ->label('Nombre del Cliente')
                            ->required()
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('customer_phone')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(20),
                    ]),
                \Filament\Forms\Components\Section::make('Notas')
                    ->schema([
                        \Filament\Forms\Components\Textarea::make('notes')
                            ->label('Notas')
                            ->rows(3),
                    ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Infolists\Components\Section::make('Información del Presupuesto')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('budget_number')
                            ->label('Número'),
                        \Filament\Infolists\Components\TextEntry::make('client.name')
                            ->label('Cliente'),
                        \Filament\Infolists\Components\TextEntry::make('customer_name')
                            ->label('Nombre'),
                        \Filament\Infolists\Components\TextEntry::make('customer_phone')
                            ->label('Teléfono'),
                    ])
                    ->columns(2),
                \Filament\Infolists\Components\Section::make('Totales')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('subtotal_bs')
                            ->label('Subtotal BS')
                            ->money('BS'),
                        \Filament\Infolists\Components\TextEntry::make('subtotal_usd')
                            ->label('Subtotal USD')
                            ->money('USD'),
                        \Filament\Infolists\Components\TextEntry::make('exchange_rate')
                            ->label('Tasa de Cambio')
                            ->money('VES'),
                        \Filament\Infolists\Components\TextEntry::make('total_bs')
                            ->label('Total BS')
                            ->money('VES'),
                    ])
                    ->columns(2),
                \Filament\Infolists\Components\Section::make('Estado')
                    ->schema([
                        \Filament\Infolists\Components\BadgeEntry::make('status')
                            ->label('Estado')
                            ->colors([
                                'gray' => 'draft',
                                'warning' => 'confirmed',
                                'success' => 'printed',
                            ]),
                        \Filament\Infolists\Components\TextEntry::make('printed_at')
                            ->label('Impreso el')
                            ->dateTime(),
                        \Filament\Infolists\Components\TextEntry::make('notes')
                            ->label('Notas')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('budget_number')
                    ->label('Número')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('client.name')
                    ->label('Cliente')
                    ->searchable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nombre')
                    ->searchable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('subtotal_bs')
                    ->label('Subtotal BS')
                    ->money('BS')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('total_bs')
                    ->label('Total BS')
                    ->money('VES')
                    ->sortable(),
                \Filament\Tables\Columns\BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'gray' => 'draft',
                        'warning' => 'confirmed',
                        'success' => 'printed',
                    ]),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'draft' => 'Borrador',
                        'confirmed' => 'Confirmado',
                        'printed' => 'Impreso',
                    ]),
            ])
            ->actions([
                \Filament\Tables\Actions\ViewAction::make(),
                \Filament\Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BudgetItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBudgets::route('/'),
            'create' => CreateBudget::route('/create'),
            'view' => ViewBudget::route('/{record}'),
            'edit' => EditBudget::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->with(['client', 'items']);
    }
}
