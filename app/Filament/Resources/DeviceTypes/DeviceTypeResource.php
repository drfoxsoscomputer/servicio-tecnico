<?php

namespace App\Filament\Resources\DeviceTypes;

use App\Filament\Resources\DeviceTypes\Pages\ManageDeviceTypes;
use App\Models\DeviceType;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class DeviceTypeResource extends Resource
{
    protected static ?string $model = DeviceType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDevicePhoneMobile;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string |\UnitEnum| null $navigationGroup = 'Catálogos';

    protected static ?string $label = 'Tipo de Dispositivo';
    protected static ?string $pluralLabel = 'Tipos de Dispositivos';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('Celular, Laptop, Tablet...'),
                TextInput::make('icon')
                    ->maxLength(50)
                    ->placeholder('heroicon-o-device-phone-mobile'),
                Toggle::make('is_active')
                    ->default(true)
                    ->label('Activo'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('icon')
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Activo'),
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
            'index' => ManageDeviceTypes::route('/'),
        ];
    }
}
