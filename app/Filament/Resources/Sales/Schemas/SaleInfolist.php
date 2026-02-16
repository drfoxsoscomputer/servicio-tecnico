<?php

namespace App\Filament\Resources\Sales\Schemas;

use App\Models\Sale;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SaleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client.name')
                    ->label('Client'),
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('service.title')
                    ->label('Service')
                    ->placeholder('-'),
                TextEntry::make('type'),
                TextEntry::make('net_amount')
                    ->numeric(),
                TextEntry::make('discount_type'),
                TextEntry::make('discount_value')
                    ->numeric(),
                TextEntry::make('discount_amount')
                    ->numeric(),
                TextEntry::make('tax_percentage')
                    ->numeric(),
                TextEntry::make('tax_amount')
                    ->numeric(),
                TextEntry::make('total_amount')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Sale $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
