<?php

namespace App\Filament\Resources\VariantAttributes;

use App\Filament\Resources\VariantAttributes\Pages\ManageVariantAttributes;
use App\Models\VariantAttribute;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VariantAttributeResource extends Resource
{
    protected static ?string $model = VariantAttribute::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string|\UnitEnum|null $navigationGroup = 'Productos';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre del Atributo (Ej: Capacidad, Color)')
                    ->required()
                    ->unique(ignoreRecord: true),
                Toggle::make('is_active')
                    ->label('Activo')
                    ->default(true),
                Repeater::make('values')
                    ->relationship('values')
                    ->label('Valores / Opciones')
                    ->addActionLabel('Agregar Valor (Ej: 32GB, Rojo)')
                    ->schema([
                        TextInput::make('name')
                            ->label('Valor')
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
                TextColumn::make('values_count')
                    ->label('Valores')
                    ->counts('values'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageVariantAttributes::route('/'),
        ];
    }
}
