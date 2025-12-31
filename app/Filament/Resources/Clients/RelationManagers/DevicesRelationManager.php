<?php

namespace App\Filament\Resources\Clients\RelationManagers;

use Dom\Text;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DevicesRelationManager extends RelationManager
{
    protected static string $relationship = 'devices';

    protected static ?string $title = 'Equipos';

    protected static ?string $modelLabel = 'equipo';

    protected static ?string $pluralModelLabel = 'equipos';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre del equipo')
                    ->maxLength(150)
                    ->default(null),
                TextInput::make('type')
                    ->label('Tipo')
                    ->placeholder('Ej: PC, Laptop, Impresora, Smartphone, Tablet, etc.')
                    ->maxLength(50)
                    ->required(),
                TextInput::make('brand')
                    ->label('Marca')
                    ->maxLength(100)
                    ->default(null),
                TextInput::make('model')
                    ->label('Modelo')
                    ->maxLength(100)
                    ->default(null),
                TextInput::make('serial')
                    ->label('Serial del equipo')
                    ->maxLength(100)
                    ->default(null),
                TextInput::make('access_password')
                    ->label('Contraseña de acceso')
                    ->password()
                    ->revealable()
                    ->maxLength(150)
                    ->default(null),
                Textarea::make('notes')
                    ->label('Notas del equipo')
                    ->rows(3)
                    ->default(null)
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre del equipo')
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
                    ->label('Serial del equipo')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime('d/m/Y h:i a')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                // DissociateAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
