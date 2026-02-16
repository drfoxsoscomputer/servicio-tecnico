<?php

namespace App\Filament\Resources\Sales\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SaleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->relationship('client', 'name')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('service_id')
                    ->relationship('service', 'title'),
                TextInput::make('type')
                    ->required()
                    ->default('sale'),
                TextInput::make('net_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('discount_type')
                    ->required()
                    ->default('none'),
                TextInput::make('discount_value')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('discount_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('tax_percentage')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('tax_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
            ]);
    }
}
