<?php

namespace App\Filament\Resources\Sales\RelationManagers;

use App\Models\PaymentMethod;
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
use Filament\Support\RawJs;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SalePaymentRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('payment_method_id')
                    ->label('Método de pago')
                    ->relationship('paymentMethod', 'name')
                    ->required()
                    ->preload(),
                TextInput::make('amount')
                    ->label('Monto (Bs)')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required(),
                TextInput::make('amount_usd')
                    ->label('Monto (USD)')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                TextInput::make('reference')
                    ->label('Referencia')
                    ->maxLength(100),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('paymentMethod.name')->label('Método de pago'),
                TextEntry::make('amount')->label('Monto (Bs)')->money('VES'),
                TextEntry::make('amount_usd')->label('Monto (USD)')->money('USD'),
                TextEntry::make('reference')->label('Referencia'),
                TextEntry::make('paid_at')->label('Fecha de pago')->dateTime(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('paymentMethod.name')
            ->columns([
                TextColumn::make('paymentMethod.name')
                    ->label('Método de pago')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Monto (Bs)')
                    ->money('VES')
                    ->sortable(),
                TextColumn::make('amount_usd')
                    ->label('Monto (USD)')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('reference')
                    ->label('Referencia')
                    ->searchable(),
                TextColumn::make('paid_at')
                    ->label('Fecha')
                    ->dateTime()
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
